<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Estoque extends MY_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_estoqueqt', 'produtos');
        $this->load->model('M_estoqueqt');
        $this->load->model('M_produto', 'cadastro');
        $this->load->library('table');
        $this->load->model('Getuser');
        $this->load->model('Controleacesso');
        $this->load->model('M_nota', '', TRUE);
            $this->load->helper('url');
    }
    
    public function lista_estoque()
    {  // controle de acesso
        $controller="estoque/lista_estoque";
        if($this->Controleacesso->acesso($controller) == true){
        
        $data['departamentos'] = $this->M_nota->listDep();
        $data['pagina'] = "Estoque";
        $data['title'] = "Produtos - ".title_global;
        $this->load->model('Getuser');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $this->load->view('v_lista_estoque2',$data);
        
          }
        else{
        $this->load->view('v_header',$data);  
        $this->load->view('sem_acesso');
        }
    }
    public function produtos()
    {  // controle de acesso
        $controller="estoque/produtos";
        if($this->Controleacesso->acesso($controller) == true){
        $data['departamento'] = $this->M_nota->listDep();
        $data['pagina'] = "Produtos";
        $data['title'] = "Produtos - ".title_global;
        $this->load->model('Getuser');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $this->load->view('v_lista_produtos2',$data);
        
          }
        else{
        $this->load->view('v_header',$data);  
        $this->load->view('sem_acesso');
        }
    }
    public function lista_estoque2(){
        // controle de acesso
        
        $controller="estoque/lista_estoque";
        if($this->Controleacesso->acesso($controller) == true){
            
        $this->load->model('M_estoqueqt', '', TRUE);
        $data['pagina'] = "Estoque";
        $data['title'] = "Produtos - ".title_global;
        $data['departamentos'] = $this->M_nota->listDep();
        $data['lista'] = $this->produtos->lista_estoque();
        $this->load->model('Getuser');
        $this->load->helper('url');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $this->load->view('v_lista_estoque', $data);
        
        
        }
        else{
        $this->load->view('v_header',$data);  
        $this->load->view('sem_acesso');
        }
    }
    public function ajax_list()
    {
        $this->load->model('M_estoqueqt', '', TRUE);
        $list = $this->M_estoqueqt->get_datatables();
        
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $produtos) {
            $no++;
            $row = array();
            $row[] = $produtos->produto_estoque;
            $row[] = $produtos->cod_barras;
            $row[] = $produtos->nome_produto;
            $row[] = $produtos->nome_departamento;
            $row[] = $produtos->quantidade_estoque;
            $row[] = $produtos->custo_medio;
            $row[] = $produtos->preco_venda;
           
            $row[] = ' <a class="btn btn-sm btn-primary" href="estoque/detalhe/'.$produtos->produto_estoque.'" title="Edit" ><i class="glyphicon glyphicon-search"></i> Det.</a>';
             if($this->Controleacesso->acesso_funcao(9) == true){
             $row[] = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Edit" onclick="edit_produtos('.$produtos->produto_estoque.')"><i class="glyphicon glyphicon-pencil"></i> Edit.</a>';
             
             }
              else
              {
                $row[] = '<a class="btn btn-sm btn-success"  title="Edit" disabled><i class="glyphicon glyphicon-pencil"></i> Edit.</a>';  
              }
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->M_estoqueqt->count_all(),
                        "recordsFiltered" => $this->M_estoqueqt->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        
        echo json_encode($output);
    }
    public function ajax_list_produtos(){
         $this->load->model('M_produto', '', TRUE);
        $list = $this->cadastro->get_datatables();
        
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $produtos) {
            $no++;
            $row = array();
            $row[] = $produtos->id_produto;
            $row[] = $produtos->cod_barras;
            $row[] = $produtos->nome_produto;
            if($produtos->imagem_produto == null){
                $row [] = '';
            }else{
           $row[] ='<a class="thumbnail fancybox" rel="ligthbox" href="uploads/'.$produtos->imagem_produto.'" >
                    <img class="img-responsive" alt="" src="uploads/'.$produtos->imagem_produto.'" style=" max-height: 50px;"/>
                    </a>';
            }
            $row[] = $produtos->nome_departamento;
            $row[]= $produtos->qt_produto;
            $row[] = $produtos->preco_venda;
            
             $row[] = ' <a class="btn btn-sm btn-primary" href="estoque/detalhe/'.$produtos->id_produto.'" title="Edit" ><i class="glyphicon glyphicon-search"></i> Det.</a>';
            if($this->Controleacesso->acesso_funcao(11) == true){   
           //$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_produtos('.$produtos->id_produto.')"><i class="glyphicon glyphicon-pencil"></i> Editar</a>';
             $row[] = '<a class="btn btn-sm btn-primary" href="estoque/editar_produto/'.$produtos->id_produto.'" title="Edit" ><i class="glyphicon glyphicon-pencil"></i> Editar</a>';
            }
            else{ 
            $row[] =  '<a class="btn btn-sm btn-primary"  title="Edit" ><i class="glyphicon glyphicon-pencil"></i> Editar</a>';
            }
            
           if($this->Controleacesso->acesso_funcao(12) == true){
               // se o produto já possuiu movimentação
               if($this->M_estoqueqt->verifica_movimento($produtos->id_produto) >=1){
               //if($produtos->qt_produto > 0){
               $row [] ='<a class="btn btn-sm btn-danger" disabled  title="Hapus" ><i class="glyphicon glyphicon-trash"></i> Del</a>'; 
               }
               else
                   {
               $row[] = '<a class="btn btn-sm btn-danger" id="ver-delete" href="javascript:void(0)" title="Delete" onclick="delete_produtos('.$produtos->id_produto.')"><i class="glyphicon glyphicon-trash"></i> Del</a>';
               }
               }
           
                else{
                $row[] = '<a class="btn btn-sm btn-danger" disabled><i class="glyphicon glyphicon-trash"></i> Del</a>';
                }
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->M_produto->count_all(),
                        "recordsFiltered" => $this->M_produto->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
    public function produtos_antigo() {
         // controle de acesso
        $controller="estoque/produtos";
        if($this->Controleacesso->acesso($controller) == true){
            
        
        $this->load->model('M_produto', '', TRUE);
        $data['pagina'] = "Produtos";
        $data['title'] = "Produtos - ".title_global;
        $data['lista'] = $this->cadastro->lista_produto();
       
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
         $data['departamento'] = $this->M_nota->listDep();
        $this->load->view('v_lista_produtos', $data);
        }
        else{
        $this->load->view('v_header',$data);  
        $this->load->view('sem_acesso');
        }
    }
    public function editar_produto($id=null)
        {  // controle de acesso
        $controller="estoque/produtos";
        if($this->Controleacesso->acesso($controller) == true){
            
        $data['departamento'] = $this->M_nota->listDep();
        $data['pagina'] = "Editar  Produto";
        $data['title'] = "Produtos - ".title_global;
        $this->load->model('Getuser');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
            
        if ($id) {
	$artigos= $this->cadastro->get_produto_id($id);
			
			if ($artigos->num_rows() > 0 ) {
                                
                                $data['id_produto'] = $artigos->row()->id_produto;
				$data['cod_barras'] = $artigos->row()->cod_barras;
                                $data['nome_produto'] = $artigos->row()->nome_produto;
                                $data['preco_venda'] = $artigos->row()->preco_venda;
                                $data['descricao_produto'] = $artigos->row()->descricao_produto;
                                $data['imagem_produto'] = $artigos->row()->imagem_produto;
                                $data['departamento_produto'] = $artigos->row()->departamento_produto;
                                
                              //  $this->load->view('admin/v_adm_edit_artigos', $variaveis);
                                $this->load->view('produtos/v_edit_produtos',$data);
			} else {
				$variaveis['mensagem'] = "Registro não encontrado." ;
				$this->load->view('errors/html/v_erro', $variaveis);
			}
                        
        }
        
        
        
          }
        else{
        $this->load->view('v_header',$data);  
        $this->load->view('sem_acesso');
        }
    }
    public function salvar_produto($id = null){
		$id = $this->input->post('id_produto');
                
                $data = array(
                                'nome_produto' => $this->input->post('nome_produto'),
                                'cod_barras' => $this->input->post('cod_barras'),
                                'descricao_produto' => $this->input->post('descricao_produto'),
                                'departamento_produto' => $this->input->post('departamento'),
                                'preco_venda' => $this->input->post('preco_venda'),
				 ); 
                            
                if ($this->cadastro->store($data, $id)) {
                 
                 //processo de upload da imagem
                    if($this->db->insert_id() == 0){
                        $nome_imagem = $id;
                    }else{
                 $nome_imagem = $this->db->insert_id();
                    }
                 //verifica se foi selecionada imagem
                 if(!isset ($_FILES['imagem_produto'])){
                   //caso não tenha sido carragada imagem não faz nada 
                    }else{
                 //caso a imagem tenha sido carregada
                 //salvando a imagem no banco       
                 $data = array(
                               'imagem_produto' => $nome_imagem.'.jpg',
                   );   
                 
                 $this->cadastro->store_imagem($data,  $nome_imagem);
                 
               
                 //upload da imagem
                 $imagem    = $_FILES['imagem_produto'];
                $configuracao = array(
                'upload_path'   => 'uploads/',
                'allowed_types' => 'jpg|jpeg',
                //'file_name'     => $this->Url_amiga->sanitize_title_with_dashes($this->input->post('nome_produto')).$this->input->post('departamento').'.jpg',
                'file_name'     =>$nome_imagem.'.jpg',
                'max_size'      => '500',
                'overwrite'     => true
                );     
                //print_r($configuracao);
                $this->load->library('upload');
                $this->upload->initialize($configuracao);
                $this->upload->do_upload('imagem_produto');
                }    
                
              
                         //if (1==1){
                           // print_r($data);
                          //  echo "ok";
				echo '<script>alert("Dados inseridos com Sucesso!"), history.go(-2)</script>';
		} else {
                         //   echo 'erro';
                        //     print_r($data);
                        echo '<script>alert("Ocorreu um erro!"), history.go(-2)</script>';
			}
				
		
	}
    
    public function departamentos(){
          // controle de acesso
        $controller="estoque/departamentos";
        if($this->Controleacesso->acesso($controller) == true){
        
        $this->load->model('M_nota', '', TRUE);
        $data['pagina'] = "Departamentos";
        $data['title'] = "Departamentos - ".title_global;
        $data['fornecedor'] = $this->produtos->listDep();
        $this->load->model('Getuser');
        $this->load->helper('url');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $this->load->view('v_lista_departamento', $data);
        }
        else{
        $this->load->view('v_header',$data);  
        $this->load->view('sem_acesso');
        }
    }
    public function ajax_edit($id)
    {
        $data = $this->produtos->get_by_id($id);
       // $data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
    public function detalhe_bk($id){
        $data['lista'] =  $list = $this->produtos->detalhe_estoque($id);
        $data['saida'] =  $list = $this->produtos->detalhe_saida_estoque($id);
        $data['produto'] =  $list = $this->produtos->detalhe_produto($id);
        $data['pagina'] = "Extrato do Produto";
        $data['title'] = "Produtos - ".title_global;
        $this->load->model('Getuser');
        $this->load->helper('url');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $this->load->view('v_detalhes_produto', $data);
    }
    public function detalhe($id){
         $this->load->model('M_estoqueqt', '', TRUE);
        $data['lista'] =  $list = $this->produtos->extrato($id);
        //$data['saida'] =  $list = $this->produtos->detalhe_saida_estoque($id);
        $data['produto'] =  $list = $this->produtos->detalhe_produto($id);
        $data['pagina'] = "Extrato do Produto";
        $data['title'] = "Produtos - ".title_global;
        $this->load->model('Getuser');
        $this->load->helper('url');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $this->load->view('v_detalhes_produto', $data);
    }

    public function transferir($id){
        $data['lista'] =  $list = $this->produtos->detalhe_baixa($id);
        $data['produto'] =  $list = $this->produtos->detalhe_transf($id);
        $data['pagina'] = "Requisição";
        $data['title'] = "Produtos - ".title_global;
        $this->load->model('Getuser');
        $this->load->helper('url');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $this->load->view('v_transferencia', $data);
    }
    
    public function relatorio() {
        $this->load->model('M_requisicao', '', TRUE);
        $data['dep'] = $this->M_requisicao->lista_dep_req();
        
        
        $data['pagina'] = "Relatório de Estoque";
        $data['title'] = "Relatório de Estoque - ".title_global;
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $this->load->view('v_filtro_estoque', $data);
    }
    public function gera_pdf(){
      //
      $data_in = $this->input->post('data_in');
      $data_fim = $this->input->post('data_fim');
      $departamento = $this->input->post('departamento');
      
      $this->load->helper('mpdf');
      $data['tipo_rel'] = "";
      $data['data_in'] = $data_in;
      $data['data_fim'] = $data_fim;
      //$data['eventos'] = $this->produtos->est_in($data_in, $data_fim);
      if($departamento == 0){
          // todos os departamentos
      $data['relatorio'] = $this->produtos->estoque($data_in, $data_fim);
      }
      else{
          // seleção de departamento
      $data['relatorio'] = $this->produtos->estoque_dep($data_in, $data_fim, $departamento);
           
      }
      
      $data['nome_dep'] = $this->produtos->get_dep($departamento);
      //$data['nome_dep'] = $departamento;
      $html = $this->load->view('v_head_pdf',$data, true);
      $html .= $this->load->view('v_rel_estoque',$data, true);
      // $this->load->view('v_rel_estoque',$data); 
      $filename = 'Relatorio_Estoque_'.$data_in.' - '.$data_fim;
      //$this->load->view('v_head_pdf',$data);
      pdf($html, $filename);
    }
    
    public function ajax_update()
    {
        //$this->produto_validate();
       
        $data = array(
                'preco_venda' => $this->input->post('preco_venda'),
                'custo_medio' => $this->input->post('preco_custo'),
               // 'id_dep_qt' => $this->input->post('departamento'),
           );
        $this->produtos->update_pr(array('id_produto_qt' => $this->input->post('id_produto_qt')), $data);
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
 
        if($this->input->post('nome_produto') == '')
        {
            $data['inputerror'][] = 'nome_produto';
            $data['error_string'][] = 'Nome e necessario';
            $data['status'] = FALSE;
        }
 
        
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
    
    
     public function produto_edit($id)
    {
         if ($this->cadastro->check_estoque($id) == 0){
            $data = $this->cadastro->get_by_id0($id);
            
         }
         else{
        $data = $this->cadastro->get_by_id($id);
         }
       // $data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
 
    public function produto_add()
    {
        $this->produto_validate();
        $data = array(
               'nome_produto' => $this->input->post('nome_produto'),
               'cod_barras' => $this->input->post('cod_barras'),
               'descricao_produto' => $this->input->post('descricao_produto'),
               'departamento_produto' => $this->input->post('departamento'),
               'preco_venda' => $this->input->post('preco_venda')
            );
        $insert = $this->cadastro->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function produto_update()
    {
        $this->produto_validate();
       
        $data = array(
                'nome_produto' => $this->input->post('nome_produto'),
                'cod_barras' => $this->input->post('cod_barras'),
                'descricao_produto' => $this->input->post('descricao_produto'),
                'departamento_produto' => $this->input->post('departamento'),
                'preco_venda' => $this->input->post('preco_venda')
            );
        $this->cadastro->update(array('id_produto' => $this->input->post('id_produto')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function produto_delete($id)
    {
        $this->cadastro->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
        
    }
 
 
    private function produto_validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('nome_produto') == '')
        {
            $data['inputerror'][] = 'nome_produto';
            $data['error_string'][] = 'Nome e necessario';
            $data['status'] = FALSE;
        }
 
        
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
 
    
        //////////////////////////
        
	

    public function departamento_edit($id){
    $data = $this->produtos->dep_by_id($id);
    echo json_encode($data);
    }
 
    public function departamento_add()
    {
        $this->departamento_validate();
        $data = array(
               'nome_departamento' => $this->input->post('nome_departamento'),
                       );
        $insert = $this->produtos->save_dep($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function departamento_update(){
        $this->departamento_validate();
        $data = array(
            'nome_departamento' => $this->input->post('nome_departamento'),
            );
        $this->produtos->update_dep($data, $this->input->post('id_departamento'));
        echo json_encode(array("status" => TRUE));
    }
 
    public function departamento_delete($id)
    {
        $this->produtos->delete_dep_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function departamento_validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('nome_departamento') == '')
        {
            $data['inputerror'][] = 'nome_departamento';
            $data['error_string'][] = 'Nome é nesessário';
            $data['status'] = FALSE;
        }
                  
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
}