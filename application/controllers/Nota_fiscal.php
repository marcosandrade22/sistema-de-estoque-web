<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Nota_fiscal extends MY_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_nota', 'produtos');
        $this->load->library('table');
        $this->load->model('Getuser');
        $this->load->model('Controleacesso');
    }
 
    public function index(){
        // controle de acesso
        $controller="nota_fiscal";
        if($this->Controleacesso->acesso($controller) == true){
        
        $this->load->model('M_nota', '', TRUE);
        $data['pagina'] = "Nota Fiscal";
        $data['title'] = "Nota Fiscal - ".title_global;
        $data['fornecedor'] = $this->M_nota->listNota();
        $data['fornecedor2'] = $this->M_nota->ListaFor();
        $data['departamento'] = $this->M_nota->ListaDep();
        $this->load->model('Getuser');
        $this->load->helper('url');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $this->load->view('v_lista_nota', $data);
        }
              else{
              $this->load->view('v_header',$data);  
              $this->load->view('sem_acesso');
           }
            
    }
    
    public function fornecedores(){
        // controle de acesso
        $controller="nota_fiscal/fornecedores";
        if($this->Controleacesso->acesso($controller) == true){
        
        $this->load->model('M_nota', '', TRUE);
        $data['pagina'] = "Fornecedores";
        $data['title'] = "Fornecedores - ".title_global;
        $data['fornecedor'] = $this->M_nota->listFor();
        $this->load->model('Getuser');
        $this->load->helper('url');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $this->load->view('v_lista_fornecedor', $data);
        }
              else{
              $this->load->view('v_header',$data);  
              $this->load->view('sem_acesso');
                }
    }
 
 
    public function ajax_list()
    {
        $list = $this->produtos->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $produtos) {
            $no++;
            $row = array();
            $row[] = $produtos->numero_visao;
            $row[] = $produtos->serie_visao;
            $row[] = $produtos->fornecedor_visao;
            $row[] = $produtos->data_visao;
           // $row[] = $produtos->data_nota;
            //$row[] = $produtos->dob;
            if($produtos->fechado_visao == 0){
             $row[] = '<a href="nota_fiscal/add_itens/'.$produtos->visao_nota.'" class="btn btn btn-sm btn-primary" ><i class="glyphicon glyphicon-plus"></i> Itens </a> '
                     . '';
            }
            else{
                $row[] = '<a class="btn btn-sm   btn-danger" >Nota fechada</a> '
                        . '<a href="nota_fiscal/add_itens/'.$produtos->visao_nota.'" class="btn btn btn-sm btn-success" ><i class="glyphicon glyphicon-search"></i> Visualizar </a>  ';
            }
             
            //add html for action
             if($produtos->fechado_visao == 0){
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_produtos('."'".$produtos->visao_nota."'".')"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_produtos('."'".$produtos->visao_nota."'".')"><i class="glyphicon glyphicon-trash"></i> Del</a>';
             }
             else{
              $row[] = '<a class="btn btn-sm btn-primary disabled" href="javascript:void(0)" title="Edit" onclick="edit_produtos('."'".$produtos->visao_nota."'".')"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
                  <a class="btn btn-sm btn-danger disabled" href="javascript:void(0)" title="Hapus" onclick="delete_produtos('."'".$produtos->visao_nota."'".')"><i class="glyphicon glyphicon-trash"></i> Del</a>';
               
             }
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->produtos->count_all(),
                        "recordsFiltered" => $this->produtos->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
        
    }
    
      public function gera_pdf($id){
        $this->load->model('M_nota', '', TRUE);
         $data['pagina'] = "Nota Fiscal - Adicionar Itens";
        $data['title'] = "Nota Fiscal - ".title_global;
       
         $data['nf'] = $this->M_nota->get_nota($id);
        //$data['produtos'] = $this->M_nota->listProduto();
        $data['departamentos'] = $this->M_nota->listDep();
        $data['itens'] = $this->M_nota->lista_itens_nf($id);
        
        $this->load->helper('mpdf');
        
        $html = $this->load->view('v_head_pdf_esp',$data, true);
        $html .= $this->load->view('v_rel_espelho',$data, true);
        $filename = 'Espelho_NF_'.$id;
         pdf($html, $filename);
        }
    
    public function add_itens($id){
        echo $id;
        $this->load->model('M_nota', '', TRUE);
       // $data['funcao'] = $this->Getuser->get_funcao('funcoes', )
        $data['pagina'] = "Nota Fiscal - Adicionar Itens";
        $data['title'] = "Nota Fiscal - ".title_global;
        $data['nf'] = $this->M_nota->get_nota($id);
        //$data['produtos'] = $this->M_nota->listProduto();
        $data['departamentos'] = $this->M_nota->listDep();
        $data['itens'] = $this->M_nota->lista_itens_nf($id);
        $this->load->model('Getuser');
        $this->load->helper('url');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $this->load->view('v_add_itens_nf', $data);
        $this->load->view('v_table_nota', $data);
    }
    
    public function cadastra_item() {
       
        $this->load->model('M_nota');
        
         if($this->M_nota->checa_item_nf($this->input->post('cod_nota'),$this->input->post('produto') )){
             echo '<script>alert("Produto já cadastrado na nota, para alterar a quantidade por favor remova e adicione com a nova quantidade!"), history.go(-1)</script>';
         }
         else{
             
        $produto = $this->input->post('produto');
       $query4 = $this->db->query("SELECT * FROM produtos WHERE id_produto=$produto");
       foreach($query4->result() as $item):
             $departamento = $item->departamento_produto;   
        endforeach;
       //echo $departamento;
       //echo $produto;
        $dados = array(
                                "data_estoque" => date('Y-m-d'),
                                "id_nf_estoque" => $this->input->post('cod_nota'),
				"nf_estoque" => $this->input->post('numero_nota'),
                                "produto_estoque" => $this->input->post('produto'),
                                "preco_estoque" => $this->input->post('preco'),
                                "quantidade_estoque" => $this->input->post('quantidade'),
				//"departamento_estoque" => $this->input->post('departamento'),
                                "departamento_estoque" => $departamento,
                       );
       
        
        if ($this->M_nota->grava_itens_nf($dados)) {
            
          redirect(base_url().'nota_fiscal/add_itens/'.$this->input->post('cod_nota'), 'refresh');
        }
        else{
          redirect(base_url().'nota_fiscal/add_itens/'.$this->input->post('cod_nota'), 'refresh');
        }
        
    }
      }
      
    public function delete(){
            $this->load->model('M_nota');
            $id = $this->input->post('id');
            $nota = $this->input->post('nota');
            if ( $this->M_nota->delete($id)) {
            redirect(base_url().'nota_fiscal/add_itens/'.$nota, 'refresh');
            }
            else{
            redirect(base_url().'nota_fiscal/add_itens/'.$nota, 'refresh');
            }
        }
      
    public function abrir($id){
            $this->load->model('M_nota');
            $movimentacoes = 0;
            $query_mov = $this->db->query("SELECT * FROM estoque WHERE id_nf_estoque=$id");
            foreach($query_mov->result() as $item):
                $id_estoque = $item->id_estoque;
                $id_produto =  $item->produto_estoque;
               // echo    'ID da NF '. $id_estoque;
                $posterior = $this->M_nota->checa_movimento_posterior($id_produto);
                //echo '<br>Id posterior'. $posterior;
                if($id_estoque < $posterior){
                    $movimentacoes++;
                }
               // echo '<br>Movimentações '.$movimentacoes.'<br>';
            endforeach;
            //verificando movimentações posteriores
                if($movimentacoes > 0){
                
                  //echo 'existe maior';  
                   echo '<script>alert("Existem Movimentações que impedem que esta nota seja aberta"), history.go(-1)</script>';
                }else{
                    //echo 'Realiza a movimentação';
                    
                    $query4 = $this->db->query("SELECT * FROM estoque_nf WHERE id_nf_estoque=$id");

                    //pega os itens da nota fiscal selecionada
                    foreach($query4->result() as $item):
                        $id_estoque = $item->id_estoque;
                        $id_produto =  $item->produto_estoque;
                        $departamento = $item->departamento_estoque;
                        $quantidade = $item->quantidade_estoque;
                        $custo = $item->preco_estoque;



                        //pegar quantidade na tabela produto e remover a quantidade total
                        $this->db->query("UPDATE produtos SET qt_produto=qt_produto - $quantidade WHERE id_produto=$id_produto ");   

                        //pegando os produtos e removendo da tabela estoque
                        $this->M_nota->remove_item_nf($id_produto, $id);


                    endforeach;
                     //abrir a nota  
                   $this->M_nota->abre_nota($id);
                   redirect(base_url().'nota_fiscal/add_itens/'.$id, 'refresh');
                }
           
           
           
        }


        public function fechar($id){
         //echo $id;
            $this->load->model('M_nota');
            
            // consulta dados do produto na nota fiscal
            $query4 = $this->db->query("SELECT * FROM estoque_nf WHERE id_nf_estoque=$id");
            foreach($query4->result() as $item):
            $id_produto =  $item->produto_estoque;
            
            $departamento = $item->departamento_estoque;
            $quantidade = $item->quantidade_estoque;
            $custo = $item->preco_estoque;
            $nf_estoque = $item->nf_estoque;
            //print_r($query4->result());
            
             //verifica o ultimo item da nota
            if($this->M_nota->check_last_estoque($id_produto)){
            $ultimo_estoque =  $this->M_nota->check_last_estoque($id_produto);   
            }else{
                $ultimo_estoque = 0;
            }
            
            //pega o ultimo custo medio
            $custo_medio = $this->M_nota->check_last_custo($id_produto); 
            
            
             //calculo de custo
                //custo antigo é igual ao estoque atual vezes o custo medio
                $custo_antigo = $ultimo_estoque*$custo_medio;
                //echo $ultimo_estoque;
            
                // novo custo é igual ao custo antigo vezes a quantidade
                $novo_custo = $custo*$quantidade; 
                //custo total é igual ao novo custo mais custo antigo
                $custo_total = $custo_antigo+$novo_custo;
             
                $nova_qt = $quantidade + $ultimo_estoque;
                $novo_custo_medio = $custo_total/$nova_qt;
             
             
              $dados = array(
                       "custo_entrada" => $custo,
                       "custo_medio" =>$novo_custo_medio,
                       "quantidade_estoque" => $nova_qt,
                       "entrada_estoque" => $quantidade,
                       "id_nf_estoque" => $id,
                       "nf_estoque" =>$nf_estoque,
                       "produto_estoque" =>$id_produto,
                       "tipo_movimento" => 1,
                       "data_estoque" => date('Y-m-d'),
                       "usuario_estoque" => $this->session->userdata('ID')
                       );
              //print_r($dados);
                 echo '<br>';
              $this->M_nota->adiciona_qt($dados);
              $this->M_nota->update_qt_produto($nova_qt, $id_produto);
           
           
            
         endforeach;
        $this->M_nota->fecha_nota($id);
        echo '<script>history.go(-1)</script>';
        
         
      }


      public function ajax_edit($id)
    {
        $data = $this->produtos->get_by_id($id);
       // $data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        //$this->_validate();
        $data = array(
               'numero_nota' => $this->input->post('numero_nota'),
               'serie_nota' => $this->input->post('serie_nota'),
               'data_nota' => $this->input->post('data_nota'),
               'id_fornecedor' => $this->input->post('fornecedor'),
           // 'departamento_nota' => $this->input->post('departamento'),
            );
        $insert = $this->produtos->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
       
        $data = array(
            'numero_nota' => $this->input->post('numero_nota'),
            'serie_nota' => $this->input->post('serie_nota'),
            'data_nota' => $this->input->post('data_nota'),
            'id_fornecedor' => $this->input->post('fornecedor'),
            //'departamento_nota' => $this->input->post('departamento'),
            );
        $this->produtos->update($data, $this->input->post('numero'));
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->produtos->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('numero_nota') == '')
        {
            $data['inputerror'][] = 'numero_nota';
            $data['error_string'][] = 'Número é nesessário';
            $data['status'] = FALSE;
        }
        
        if($this->input->post('data_nota') == '')
        {
            $data['inputerror'][] = 'data_nota';
            $data['error_string'][] = 'Data é nesessária';
            $data['status'] = FALSE;
        }
        
        if($this->input->post('fornecedor') == '')
        {
            $data['inputerror'][] = 'fornecedor';
            $data['error_string'][] = 'Fornecedor é nesessário';
            $data['status'] = FALSE;
        }
 
        
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
    
    
   
    function listing($id)
	{
		$this->load->model('M_itempedido','',TRUE);
		$qry = $this->M_itempedido->getItens($id);
		$table = $this->table->generate($qry);
		$tmpl = array ( 'table_open'  => '<table id="tabela" class="table table-striped table-bordered table-hover">' );
		$this->table->set_template($tmpl);
		$this->table->set_empty("&nbsp;");
		$this->table->set_heading('Editar', 'Baixa', 'Produto', 'Quantidade', 'Obs', 'Excluir');
		$table_row = array();
		foreach ($qry->result() as $item)
		{
			$table_row = NULL;
			if ($item->flag_baixa == 'S') {
				$table_row[] = NULL;
				$table_row[] = NULL;
			} else {
				$table_row[] = anchor('itempedido/editItem/' . $item->id_item_pedido . '/' . $item->cod_pedido, '<span class="ui-icon ui-icon-pencil"></span>');
				$table_row[] = anchor('itempedido/baixaItem/' . $item->id_item_pedido . '/' . $item->cod_pedido, '<span class="ui-icon ui-icon-check"></span>');
			}
			$this->load->model('MProduto', '', TRUE);
			$produto = $this->MProduto->getProduto($item->cod_produto)->result();
			$table_row[] = $produto[0]->nome_produto;
			$table_row[] = $item->quantidade;
			$table_row[] = $item->obs;
			if ($item->flag_baixa == 'S') {
				$table_row[] = NULL;
			} else {
				$table_row[] = anchor('itempedido/deleteItem/' . $item->id_item_pedido . '/'.$item->cod_pedido, '<span class="ui-icon ui-icon-trash"></span>',
						"onClick=\" return confirm('Tem certeza que deseja remover o registro?')\"");
			}
			$this->table->add_row($table_row);
		}
		return $table = $this->table->generate();
	}
        
        
        //////////////////////////
        
	

      public function fornecedor_edit($id)
    {
        $data = $this->produtos->for_by_id($id);
       // $data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
 
    public function fornecedor_add()
    {
        $this->fornecedor_validate();
        $data = array(
               'razao_social' => $this->input->post('razao_social'),
               'cnpj' => $this->input->post('cnpj'),
               'telefone' => $this->input->post('telefone'),
            );
        $insert = $this->produtos->save_for($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function fornecedor_update(){
        $this->fornecedor_validate();
        $data = array(
            'razao_social' => $this->input->post('razao_social'),
            'cnpj' => $this->input->post('cnpj'),
            'telefone' => $this->input->post('telefone'),
            );
        $this->produtos->update_for($data, $this->input->post('id_fornecedor'));
        echo json_encode(array("status" => TRUE));
    }
 
    public function fornecedor_delete($id)
    {
        $this->produtos->delete_for_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function fornecedor_validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('razao_social') == '')
        {
            $data['inputerror'][] = 'razao_social';
            $data['error_string'][] = 'Razão Social é nesessário';
            $data['status'] = FALSE;
        }
        
        if($this->input->post('cnpj') == '')
        {
            $data['inputerror'][] = 'cnpj';
            $data['error_string'][] = 'CNPJ é nesessário';
            $data['status'] = FALSE;
        }
             
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
    
 
}