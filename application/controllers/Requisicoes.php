<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Requisicoes extends MY_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_requisicao', 'requisicao');
        $this->load->model('M_requisicao', '', TRUE);
        $this->load->model('M_nota');
        $this->load->library('table');
        $this->load->model('Getuser');
        $this->load->model('Controleacesso');
        $this->load->model('Ajax_model');
        $this->load->helper('url');
    }
 
    
     public function nova_requisicao()
    {  // controle de acesso
        $controller="requisicoes/nova_requisicao";
        if($this->Controleacesso->acesso($controller) == true){
           
        $data['lista'] = $this->requisicao->lista_requisicoes();
        $data['dep'] = $this->requisicao->lista_dep_req();
        $data['dep_ced'] = $this->requisicao->lista_dep_req();
        $data['tipo'] = $this->requisicao->lista_tipo_rq();
            
        $data['pagina'] = "Requisições";
        $data['title'] = "Requisições - ".title_global;
        $this->load->model('Getuser');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $this->load->view('v_requisicao2',$data);
        
          }
        else{
        $this->load->view('v_header',$data);  
        $this->load->view('sem_acesso');
        }
    }
    
    public function myformAjax($id) { 
       //$result = $this->db->where("id_produto",$id)->get("produtos")->result();
       $result = $this->M_requisicao->listProduto_semzero_id($id);
       
       $requisicao = $this->M_nota->checa_item_rq_qt($id);
       $total =$result-$requisicao;
       $data=array('qt_produto'=>$total);
       echo json_encode($data);
       
    }
    
    public function nova_requisicao2(){
        // controle de acesso
        $controller="requisicoes/nova_requisicao";
        if($this->Controleacesso->acesso($controller) == true){
        
        $this->load->model('M_requisicao', '', TRUE);
        $data['pagina'] = "Requisições";
        $data['lista'] = $this->requisicao->lista_requisicoes();
        $data['dep'] = $this->requisicao->lista_dep_req();
        $data['dep_ced'] = $this->requisicao->lista_dep_req();
        $data['tipo'] = $this->requisicao->lista_tipo_rq();
        $data['title'] = "Requisições - ".title_global;
        $this->load->model('Getuser');
        $this->load->helper('url');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
         print_r($this->requisicao->dep_array());
         
        $this->load->view('v_requisicao', $data);
        }
         else{
                  $this->load->view('v_header',$data);  
                  $this->load->view('sem_acesso');
         }
    }
    
    public function gera_alerta_rq(){
        $this->load->model('M_requisicao', '', TRUE);
        echo $this->M_requisicao->lista_requisicoes_abertas_qt();
    }
     
    
    public function monitor_requisicao(){
          // controle de acesso
        $controller="requisicoes/monitor_requisicao";
        if($this->Controleacesso->acesso($controller) == true){
        
        $this->load->model('M_requisicao', '', TRUE);
        $data['pagina'] = "Requisições Pendentes";
        $data['lista'] = $this->requisicao->lista_requisicoes_abertas();
        $data['dep'] = $this->requisicao->lista_dep_req();
        $data['dep_ced'] = $this->requisicao->lista_dep_req();
        $data['tipo'] = $this->requisicao->lista_tipo_rq();
        $data['title'] = "Requisições - ".title_global;
        $this->load->model('Getuser');
        $this->load->helper('url');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $this->load->view('v_monitor_requisicao', $data);
        }
         else{
                  $this->load->view('v_header',$data);  
                  $this->load->view('sem_acesso');
         }
    }
    
    public function tipo_requisicao(){
      $controller="requisicoes/tipo_requisicao";
        if($this->Controleacesso->acesso($controller) == true){  
        $this->load->model('M_requisicao', '', TRUE);
        $data['pagina'] = "Tipos de Requisições"; 
        $data['tipo'] = $this->requisicao->lista_tipo_rq();  
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
         $this->load->view('v_tipo_requisicao', $data);
         }
         else{
           $this->load->view('v_header',$data);  
           $this->load->view('sem_acesso');
           }
        } 
    
 
    public function ajax_list(){
         $this->load->model('M_requisicao');
        $list = $this->requisicao->get_datatables();
         $data = array();
        $no = $_POST['start'];
        foreach ($list as $produtos) {
            $no++;
            $row = array();
            $row[] = $produtos->id_requisicao;
            if(empty($produtos->usuario_requisicao)){
              $row[] = $produtos->nome_requisicao;  
            }else{
            $row[] = $produtos->nome_requisicao. '<br><small><small> Criada por '. $this->Getuser->get_nome($produtos->usuario_requisicao).'</small></small><br>';
            }
            $row[] = date('d-m-Y' , strtotime($produtos->data_requisicao));
            $row[] = $this->M_requisicao->get_dep($produtos->dep_requisicao); 
            if($produtos->tipo_requisicao == 1){
                $row[] ='Doação';
                }
                elseif($produtos->tipo_requisicao == 2){
               $row[] = 'Repasse';
                }
         if($produtos->fechado == 0){ 
                               
                                if($this->Controleacesso->acesso_funcao(19) == true){
                              $row[] = '<a href="requisicoes/add_itens/'.$produtos->id_requisicao.'" class="btn btn btn-sm btn-primary" ><i class="glyphicon glyphicon-plus"></i> Itens </a>';
                               }else{
                                 $row[] = '<a  class="btn btn btn-sm btn-primary" disabled ><i class="glyphicon glyphicon-plus"></i> Itens </a>';
                                 
                                }
                                
                                }
                                else{ 
                             
                           
                              if($this->Controleacesso->acesso_funcao(20) == true){
                                $row[] =  '<a class="btn btn-sm disabled btn-danger" >Requisição fechada</a> <a href="requisicoes/add_itens/'.$produtos->id_requisicao.'" class="btn btn btn-sm btn-success" ><i class="glyphicon glyphicon-search"></i> Visualizar </a> ';
                                    }
                                    else{
                                        $row[] =  '<a class="btn btn-sm disabled btn-danger" >Requisição fechada</a> <a disabled class="btn btn btn-sm btn-success" ><i class="glyphicon glyphicon-search"></i> Visualizar </a> ';
                                
                                    }
                                   
                         }
                
             
             
              if($produtos->fechado == 0){ 
                              if($this->Controleacesso->acesso_funcao(17) == true){
                           $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_produtos('.$produtos->id_requisicao.')"><i class="glyphicon glyphicon-pencil"></i> Editar</a>';
                            }
                            else{
                              $row[] = '<a class="btn btn-sm btn-primary"  title="Edit" disabled ><i class="glyphicon glyphicon-pencil"></i> Editar</a>';
                            }
                          
                                if($this->Controleacesso->acesso_funcao(18) == true){
                                    
                                    if($this->M_requisicao->check_itens($produtos->id_requisicao)){
                                    //if(1==2){  
                                        $row[] =  ' <a class="btn btn-sm btn-danger"  title="Hapus" disabled ><i class="glyphicon glyphicon-trash"></i> Del</a>';
                                    
                                        }else{
                                    //$row[] = $this->M_requisicao->check_itens($produtos->id_requisicao);
                                        $row[] =  ' <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_produtos('.$produtos->id_requisicao.')"><i class="glyphicon glyphicon-trash"></i> Del</a>';
                                    }
                                    
                                    }
                                else{
                                 $row[] =  ' <a class="btn btn-sm btn-danger"  title="Hapus" disabled ><i class="glyphicon glyphicon-trash"></i> Del</a>';
                                 
                                }
                          }
                           else{ 
                            if($this->Controleacesso->acesso_funcao(17) == true){
                              $row[] =  '<a class="btn btn-sm btn-primary disabled" href="javascript:void(0)" title="Edit" ><i class="glyphicon glyphicon-pencil"></i> Editar</a>';
                            }
                            else{$row[] =  '<a class="btn btn-sm btn-primary disabled" href="javascript:void(0)" title="Edit" ><i class="glyphicon glyphicon-pencil"></i> Editar</a>';}
                          
                            if($this->Controleacesso->acesso_funcao(18) == true){
                               $row[] =  '<a class="btn btn-sm btn-danger disabled" href="javascript:void(0)" title="Hapus" ><i class="glyphicon glyphicon-trash"></i> Del</a>';
                               }
                            else{ $row[] =  '<a class="btn btn-sm btn-danger disabled" href="javascript:void(0)" title="Hapus" ><i class="glyphicon glyphicon-trash"></i> Del</a>';
                            }
                               
                            } 
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->requisicao->count_all(),
                        "recordsFiltered" => $this->requisicao->count_filtered(),
                        "data" => $data,
                );
       
        echo json_encode($output);
        
    }
    
  
  function get_itens(){
    
    if (isset($_GET['term'])){
      $q = strtolower($_GET['term']);
      $this->Ajax_model->get_itens($q);
    }
  }
    function get_item_ajax()
   {
      
        $search=  $this->input->get('search');
       // $query = $this->Ajax_model->EmployeeModel($search);
        $query = $this->Ajax_model->search($search);
       echo json_encode($query);
   }

    public function lookup(){  
        // process posted form data  
        $keyword = $this->input->post('term');  
        $data['response'] = 'false'; //Set default response  
        $query = $this->Ajax_model->search($keyword); //Search DB  
        if( ! empty($query) )  
        {  
            $data['response'] = 'true'; //Set response  
            $data['message'] = array(); //Create array  
            foreach( $query as $row )  
            {  
            $data['message'][] = array(   
                                        'id'=>$row->id_produto,  
                                        'value' => $row->nome_produto,  
                                        'id_produto' => $row->id_produto
                                     );  //Add a row to array  
            }  
        }  
        if('IS_AJAX')  
        {  
            echo json_encode($data); //echo json string if ajax request  
        }  
        else 
        {  
            $this->load->view('v_add_itens_rq',$data); //Load html view of search results  
        }  
    } 
        
    

    public function add_itens($id){
       
        $this->load->model('M_requisicao', '', TRUE);
       // $data['funcao'] = $this->Getuser->get_funcao('funcoes', )
        $data['pagina'] = "Requisição - Adicionar Itens";
        $data['title'] = "Requisição - ".title_global;
        $data['nf'] = $this->M_requisicao->get_requisicao($id);
        $data['id'] = $id;
        //$data['produtos'] = $this->M_requisicao->listProdutoDep($id);
       
        $data['itens'] = $this->M_requisicao->lista_itens_rq($id);
        $data['dev'] = $this->M_requisicao->lista_itens_rq_dev($id);
        $this->load->model('Getuser');
        $this->load->helper('url');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $this->load->view('v_add_itens_rq', $data);
        $this->load->view('v_table_nota', $data);
    }
    
    
    public function gera_pdf($id){
        $this->load->model('M_requisicao', '', TRUE);
        $data['nf'] = $this->M_requisicao->get_requisicao($id);
        $data['produtos'] = $this->M_requisicao->listProduto();
       
        $data['itens'] = $this->M_requisicao->lista_itens_rq($id);
        $data['dev'] = $this->M_requisicao->lista_itens_rq_dev($id);
        
        $this->load->helper('mpdf');
     
        $html = $this->load->view('v_head_pdf_rq',$data, true);
        $html .= $this->load->view('v_rel_requisicao',$data, true);
      $filename = 'Requisicao_de_estoque_'.$id;
         pdf($html, $filename);
        }
        
    public function gera_pdf_dev($id){
        $this->load->model('M_requisicao', '', TRUE);
        $data['nf'] = $this->M_requisicao->get_requisicao($id);
        $data['produtos'] = $this->M_requisicao->listProduto();
       
        //$data['itens'] = $this->M_requisicao->lista_itens_rq($id);
        $data['itens'] = $this->M_requisicao->lista_itens_rq_dev($id);
        
        $this->load->helper('mpdf');
     
        $html = $this->load->view('v_head_dev_pdf',$data, true);
        $html .= $this->load->view('v_rel_dev_requisicao',$data, true);
        $filename = 'Devolucao_de_estoque_'.$id;
        pdf($html, $filename);
        }
        
    public function gera_pdf_requisicoes(){
      $data_in = $this->input->post('data_in');
      $data_fim = $this->input->post('data_fim');
      $departamento = $this->input->post('departamento');
      $tipo = $this->input->post('tipo');
      
      $this->load->helper('mpdf');
      
      $data['tipo_rel'] = "";
      $data['data_in'] = $data_in;
      $data['data_fim'] = $data_fim;
      $data['departamento'] = $departamento;
      //$data['eventos'] = $this->produtos->est_in($data_in, $data_fim);
      if($departamento == 0){
          // todos os departamentos
          if($tipo == 0){
            
           $data['relatorio'] = $this->requisicao->lista_requisicoes_data($data_in, $data_fim);
          }
          else{
           
            $data['relatorio'] = $this->requisicao->lista_requisicoes_tipo($data_in, $data_fim, $tipo);   
          }
          
           
      }
      else{
          // seleção de departamento
          if($tipo == 0){
             
            $data['relatorio'] = $this->requisicao->lista_requisicoes_dep($data_in, $data_fim, $departamento);
          }
          else{
             
            $data['relatorio'] = $this->requisicao->lista_requisicoes_dep_tipo($data_in, $data_fim,$departamento, $tipo);   
          }
          
      }
      
     
      $html = $this->load->view('v_head_pdf_requisicoes',$data, true);
      $html .= $this->load->view('v_rel_requisicoes',$data, true); 
      $filename = 'Relatorio_Estoque_'.$data_in.' - '.$data_fim;
      pdf($html, $filename);
    }
    
    public function cadastra_item() {
        
        $this->load->model('M_nota');
        
         if($this->M_nota->checa_item_rq($this->input->post('id_req_est'),$this->input->post('id_pro_req_est') )){
             echo '<script>alert("Produto já cadastrado na Requisição, para alterar a quantidade por favor remova e adicione com a nova quantidade!"), history.go(-1)</script>';
         }
         else{
             
        $this->load->model('M_requisicao');
        $produto = $this->input->post('id_pro_req_est');
        $query4 = $this->db->query("SELECT * FROM produtos WHERE id_produto=$produto");
        foreach($query4->result() as $item):
        $departamento = $item->departamento_produto; 
        $venda = $item->preco_venda; 
        endforeach;
       
        $query5 = $this->db->query("SELECT * FROM estoque WHERE produto_estoque=$produto");
        foreach($query5->result() as $item):
            if($this->input->post('tipo_requisicao') == 1){
                $custo = $item->custo_medio; 
            }
            elseif($this->input->post('tipo_requisicao') == 2){
                $custo = $venda; 
            }
        endforeach;
        $dados = array(
       // "valor_rq" => $this->input->post('valor_rq'),
        "valor_rq" => $custo,
        //"departamento_rq" => $this->input->post('departamento_rq'),
        //"departamento_rq" => $this->input->post('id_ced_est'),
        "departamento_rq" => $departamento,
        "id_req_est" => $this->input->post('id_req_est'),
	"id_pro_req_est" => $this->input->post('id_pro_req_est'),
        "qt_pro_req_est" => $this->input->post('qt_pro_req_est'),
        "data_rq"  => $this->input->post('data_rq'),   
         );
       /// print_r($dados);
        
            if ($this->M_requisicao->grava_itens_rq($dados)) {
            }
            else{
            redirect(base_url().'requisicoes/add_itens/'.$this->input->post('id_req_est'), 'refresh');
            }
         }
        }
      
    public function delete(){
            $this->load->model('M_requisicao');
            $id = $this->input->post('id');
            $requisicao = $this->input->post('nota');
            if ( $this->M_requisicao->delete_by_id($id)) {
             redirect(base_url().'requisicoes/add_itens/'.$requisicao, 'refresh');
            }
            else{
            redirect(base_url().'requisicoes/add_itens/'.$requisicao, 'refresh');
            }
        }
      
    public function acertar(){
         $query4 = $this->db->query("SELECT * FROM estoque_rq WHERE id_req_est=7748");  
         // $query4 = $this->db->query("SELECT * FROM estoque_rq WHERE id_req_est=15572"); 
         foreach($query4->result() as $item):   
         echo $item->id_req_est.' - '.$item->id_pro_req_est.' - '.$item->qt_pro_req_est.'<br>';
         
         // if($this->M_nota->remove_item( $item->id_pro_req_est,$item->id_req_est)){
        //      echo 'ok';
        //  }else{
              
         //     echo 'erro';
         // }
         endforeach;
        }


        public function abrir($id){
            $this->load->model('M_requisicao');
             $movimentacoes = 0;
            $query_mov = $this->db->query("SELECT * FROM estoque WHERE id_rq_estoque=$id");
            foreach($query_mov->result() as $item):
                $id_estoque = $item->id_estoque;
                $id_produto =  $item->produto_estoque;
                //echo    'ID da RQ '. $id_estoque;
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
                    //echo 'Reaaliza movimento<br>';
                        // consulta dados do produto na requisicao
                        //$query4 = $this->db->query("SELECT * FROM estoque_rq INNER JOIN requisicao ON requisicao.id_requisicao=estoque_rq.id_req_est WHERE id_req_est=$id");
                        $query4 = $this->db->query("SELECT * FROM estoque_rq WHERE id_req_est=$id");


                        foreach($query4->result() as $item):
                        $id_produto =  $item->id_pro_req_est;
                        $requisicao = $item->id_req_est;
                        $quantidade = $item->qt_pro_req_est;
                        ////$cedente = $item->dep_cedente;
                        $departamento = $item->departamento_rq;
                        $valor = $item->valor_rq;
                        //echo $id_produto.' - '.$quantidade.'<br>';

                        //pegar quantidade na tabela produto e adicionar a quantidade total
                        $this->db->query("UPDATE produtos SET qt_produto=qt_produto + $quantidade WHERE id_produto=$id_produto ");  

                         //pegando os produtos e removendo da tabela estoque
                        $this->M_nota->remove_item_rq($id_produto, $requisicao);

                        endforeach;
                        $this->M_requisicao->abre_rq($id);
                       echo '<script>history.go(-1)</script>';
                }
            }
            //desuso
            public function dev_item(){
              $data_dev = date('Y-m-d');
              $id_dev =  $this->input->post('id_dev');
              $requisicao =  $this->input->post('id_rq');
              $quantidade =  $this->input->post('qt_dev');
              $id_produto =  $this->input->post('id_produto');
              $departamento =  $this->input->post('departamento');
              $valor =  $this->input->post('valor');
              
              
              ////////
              
             //$id_produto =  $item->id_pro_req_est;
            //$requisicao = $item->id_req_est;
            //$quantidade = $item->qt_pro_req_est;
            
            //$cedente = $item->dep_cedente;
            // $cedente2 = $item->departamento_rq;
           
            //verifica o ultimo item da nota
            $ultimo_estoque =  $this->M_nota->check_last_estoque($id_produto);
            $nova_qt = $ultimo_estoque + $quantidade;
            
            //$query = $this->db->query("UPDATE estoque_qt set quantidade_qt = quantidade_qt-$quantidade where id_dep_qt=$cedente2 AND id_produto_qt=$id_produto");
            //nova rotina
            $dados = array(
                       "quantidade_estoque" => $nova_qt,
                       "entrada_estoque" => $quantidade,
                       "id_nf_estoque" => $requisicao,
                       "nf_estoque" =>$requisicao,
                       "produto_estoque" =>$id_produto,
                       "tipo_movimento" => 3,
                       "data_estoque" => date('Y-m-d')
                       );
            
             $this->M_nota->adiciona_qt($dados);
             $this->M_nota->update_qt_produto($nova_qt, $id_produto);
             //atualizar a quantidade na requisição
            $this->db->query("UPDATE estoque_rq SET qt_pro_req_est=qt_pro_req_est - $quantidade WHERE id_pro_req_est=$id_produto AND id_req_est=$requisicao");  
              
              //////
              /*
              //verifica se já existe uma devolução deste item
              $query3 = $this->db->query("SELECT * FROM estoque_rq_dev WHERE id_pro_req_est=$id_produto AND id_req_est=$id_rq AND departamento_rq=$departamento");   
                foreach($query3->result() as $qt):
                $quantidade_atual = $qt->qt_pro_req_est;  
              endforeach;
              // se não existir insere o item
              if(!isset($quantidade_atual)){
             $query3 = $this->db->query("INSERT INTO estoque_rq_dev (id_req_est, id_pro_req_est, qt_pro_req_est, data_rq, departamento_rq, valor_rq)
             VALUES ($id_rq, $id_produto, $qt_dev, '$data_dev', $departamento, $valor)  ");   
                  
              }
              // se existir soma o item
              else{
               $query3 = $this->db->query("UPDATE estoque_rq_dev set qt_pro_req_est = qt_pro_req_est+$qt_dev where id_pro_req_est =$id_produto AND departamento_rq=$departamento AND id_req_est=$id_rq ");   
              }
                 
              
              $query = $this->db->query("UPDATE estoque_rq set qt_pro_req_est = qt_pro_req_est-$qt_dev where id_est_rq =$id_dev ");
            $query2 = $this->db->query("UPDATE estoque_qt set quantidade_qt = quantidade_qt+$qt_dev where id_produto_qt =$id_produto AND id_dep_qt =$departamento  ");
              */
              
               echo '<script>history.go(-1)</script>';
                
            }
            
            
            public function dev_item_bk() {
              $data_dev = date('Y-m-d');
              $id_dev =  $this->input->post('id_dev');
              $id_rq =  $this->input->post('id_rq');
              $qt_dev =  $this->input->post('qt_dev');
              $id_produto =  $this->input->post('id_produto');
              $departamento =  $this->input->post('departamento');
              $valor =  $this->input->post('valor');
              //verifica se já existe uma devolução deste item
              $query3 = $this->db->query("SELECT * FROM estoque_rq_dev WHERE id_pro_req_est=$id_produto AND id_req_est=$id_rq AND departamento_rq=$departamento");   
                foreach($query3->result() as $qt):
                $quantidade_atual = $qt->qt_pro_req_est;  
              endforeach;
              // se não existir insere o item
              if(!isset($quantidade_atual)){
             $query3 = $this->db->query("INSERT INTO estoque_rq_dev (id_req_est, id_pro_req_est, qt_pro_req_est, data_rq, departamento_rq, valor_rq)
             VALUES ($id_rq, $id_produto, $qt_dev, '$data_dev', $departamento, $valor)  ");   
                  
              }
              // se existir soma o item
              else{
               $query3 = $this->db->query("UPDATE estoque_rq_dev set qt_pro_req_est = qt_pro_req_est+$qt_dev where id_pro_req_est =$id_produto AND departamento_rq=$departamento AND id_req_est=$id_rq ");   
              }
                 
              
              $query = $this->db->query("UPDATE estoque_rq set qt_pro_req_est = qt_pro_req_est-$qt_dev where id_est_rq =$id_dev ");
            $query2 = $this->db->query("UPDATE estoque_qt set quantidade_qt = quantidade_qt+$qt_dev where id_produto_qt =$id_produto AND id_dep_qt =$departamento  ");
              
              
               echo '<script>history.go(-1)</script>';
                
            }
            
            
            //desuso
            public function canc_dev(){
              $data_dev = date('Y-m-d');
              $id_dev =  $this->input->post('id_dev');
              $id_rq =  $this->input->post('id_rq');
              $qt_dev =  $this->input->post('qt_dev');
              $id_produto =  $this->input->post('id_produto');
              $departamento =  $this->input->post('departamento');
              $valor =  $this->input->post('valor');    
                
            //verifica a quantidade atual
            $query3 = $this->db->query("SELECT * FROM estoque_rq_dev WHERE id_pro_req_est=$id_produto AND id_req_est=$id_rq AND departamento_rq=$departamento");   
            foreach($query3->result() as $qt):
           $quantidade_atual = $qt->qt_pro_req_est;  
            endforeach;
             
            // se a quantidade digitada for maior que a que foi devolvida não faz nada
            if ($quantidade_atual < $qt_dev){
               echo '<script>alert("A quantidade é superior a que foi devolvida!!"), history.go(-1)</script>'; 
            }
              else{
              
            $query = $this->db->query("UPDATE estoque_rq set qt_pro_req_est = qt_pro_req_est+$qt_dev where id_req_est =$id_rq AND id_pro_req_est=$id_produto AND departamento_rq=$departamento ");
            $query2 = $this->db->query("UPDATE estoque_qt set quantidade_qt = quantidade_qt-$qt_dev where id_produto_qt =$id_produto AND id_dep_qt =$departamento  ");
            //verifica se a quantidade devolvida é igual a que vai ser restabelecida  
            // se for igual apaga o registro
                 
                    if($quantidade_atual == $qt_dev){
                       $query4 = $this->db->query("DELETE FROM estoque_rq_dev where id_est_rq =$id_dev ");
                    }
                    // se não for igual subtrai 
                    else{
                     
                      $query4 = $this->db->query("UPDATE estoque_rq_dev set qt_pro_req_est = qt_pro_req_est-$qt_dev where id_est_rq=$id_dev");
                
                     }
              echo '<script>history.go(-1)</script>';
              }
            }
            public function testar(){
                $id = '12872';
               $this->load->model('M_nota');
            // consulta dados do produto na requisicao
            ///$query4 = $this->db->query("SELECT * FROM estoque_rq INNER JOIN requisicao ON requisicao.id_requisicao=estoque_rq.id_req_est WHERE id_req_est=$id AND fechado=0");
            $query4 = $this->db->query("SELECT * FROM estoque_rq WHERE id_req_est=$id ");
            echo json_encode($query4->result());
            echo '<br>';
            foreach($query4->result() as $item):
                
            $id_produto =  $item->id_pro_req_est;
            $requisicao = $item->id_req_est;
            $quantidade = $item->qt_pro_req_est;
            
            //$cedente = $item->dep_cedente;
            $cedente2 = $item->departamento_rq;
            echo $id_produto. ' - ';
            //verifica o ultimo item da nota
            $ultimo_estoque =  $this->M_nota->check_last_estoque_bk($id_produto);
            $nova_qt = $ultimo_estoque-$quantidade;
            echo $ultimo_estoque;
            //$query = $this->db->query("UPDATE estoque_qt set quantidade_qt = quantidade_qt-$quantidade where id_dep_qt=$cedente2 AND id_produto_qt=$id_produto");
            //nova rotina
            $dados = array(
                       "quantidade_estoque" => $nova_qt,
                       "saida_estoque" => $quantidade,
                       "id_nf_estoque" => $requisicao,
                       "nf_estoque" =>$requisicao,
                       "produto_estoque" =>$id_produto,
                       "tipo_movimento" => 2,
                       "data_estoque" => date('Y-m-d H:i:s')
                       );
            //echo ' ultimo-estoque '.$ultimo_estoque.' | Quantidade '. $quantidade.' | Nova qt: '.$nova_qt. ' | '.$id_produto .'<br>';
            print_r($dados);echo '<br>';
            //usleep(500000);
             //$this->M_nota->adiciona_qt($dados);
             //$this->M_nota->update_qt_produto($nova_qt, $id_produto);
            unset($item);
             endforeach;
            
            //$this->M_requisicao->fecha_rq($id);
            //echo '<script>history.go(-1), reload_table()</script>';
            }
            public function fechar($id){
         
            if($this->M_requisicao->check_requisicao_fechada($id) == 1){
                   echo '<script>alert("Esta requisição já foi fechada!"), history.go(-1)</script>';
            }
            else
                {
            $this->load->model('M_nota');
            // consulta dados do produto na requisicao
            ///$query4 = $this->db->query("SELECT * FROM estoque_rq INNER JOIN requisicao ON requisicao.id_requisicao=estoque_rq.id_req_est WHERE id_req_est=$id AND fechado=0");
            $query4 = $this->db->query("SELECT * FROM estoque_rq WHERE id_req_est=$id ");
            foreach($query4->result() as $item):
            $id_produto =  $item->id_pro_req_est;
            $requisicao = $item->id_req_est;
            $quantidade = $item->qt_pro_req_est;
            
            //$cedente = $item->dep_cedente;
            $cedente2 = $item->departamento_rq;
           
            //verifica o ultimo item da nota
            $ultimo_estoque =  $this->M_nota->check_last_estoque_bk($id_produto);
            $nova_qt = $ultimo_estoque-$quantidade;
            
            //$query = $this->db->query("UPDATE estoque_qt set quantidade_qt = quantidade_qt-$quantidade where id_dep_qt=$cedente2 AND id_produto_qt=$id_produto");
            //nova rotina
            $dados = array(
                       "quantidade_estoque" => $nova_qt,
                       "saida_estoque" => $quantidade,
                       "id_rq_estoque" => $requisicao,
                       "nf_estoque" =>$requisicao,
                       "produto_estoque" =>$id_produto,
                       "tipo_movimento" => 2,
                       "data_estoque" => date('Y-m-d H:i:s'),
                       "usuario_estoque" => $this->session->userdata('ID')
                       );
            
             $this->M_nota->adiciona_qt($dados);
             $this->M_nota->update_qt_produto($nova_qt, $id_produto);
             usleep(500000);
             endforeach;
            
            $this->M_requisicao->fecha_rq($id);
            echo '<script>history.go(-1), reload_table()</script>';
            
            }
            }


    public function relatorio() {
         $this->load->model('M_requisicao', '', TRUE);
        $data['dep'] = $this->M_requisicao->lista_dep_req();
        
        $data['pagina'] = "Relatório de Requisição";
       $data['title'] = "Relatório de Requisição - ".title_global;
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $this->load->view('v_filtra_relatorio_rq', $data);
        
    }
         
     
      public function ajax_edit($id)
    {
        $data = $this->requisicao->get_by_id($id);
        // $data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
    public function add_rq(){
         // controle de acesso
        $controller="adm_menus";
        if($this->Controleacesso->acesso($controller) == true){
        
        $this->load->model('M_requisicao', '', TRUE);
        $data['pagina'] = "Requisições";
        $data['lista'] = $this->requisicao->lista_requisicoes();
        $data['dep'] = $this->requisicao->lista_dep_req();
        $data['dep_ced'] = $this->requisicao->lista_dep_req();
        $data['title'] = "Requisições - ".title_global;
       $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $this->load->view('v_nova_rq', $data); 
        }
         else{
                  $this->load->view('v_header',$data);  
                  $this->load->view('sem_acesso');
               }
    }
function create(){
    $this->load->model('M_requisicao', '', TRUE);
    $id = $this->M_requisicao->save($_POST);
    //echo json_encode(array("status" => TRUE));
    redirect('requisicoes/add_itens/'.$id, 'refresh');
}
           

        public function ajax_add()
    {
        $this->_validate();
        $data = array(
               'nome_requisicao' => $this->input->post('nome_requisicao'),
               'dep_requisicao' => $this->input->post('dep_requisicao'),
               'tipo_requisicao' => $this->input->post('tipo_requisicao'),
               'data_requisicao' => $this->input->post('data_requisicao'),
                
        );
        //$id = $this->M_requisicao($_POST);
        $insert = $this->requisicao->save($data);
        echo json_encode(array("status" => TRUE));
       
       // redirect('requisicoes/add_itens/'.$id, 'refresh');
    }
 
    public function ajax_update()
    {
        $this->_validate();
       
        $data = array(
            
            'nome_requisicao' => $this->input->post('nome_requisicao'),
            'dep_requisicao' => $this->input->post('dep_requisicao'),
             'tipo_requisicao' => $this->input->post('tipo_requisicao'),
            'data_requisicao' => $this->input->post('data_requisicao'),
           
            );
        $this->requisicao->update($data, $this->input->post('id_requisicao'));
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->requisicao->delete_rq_by_id($id);
        $this->M_requisicao->delete_itens_rq($id);
        echo json_encode(array("status" => TRUE));
    }
 
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('nome_requisicao') == '')
        {
            $data['inputerror'][] = 'nome_requisicao';
            $data['error_string'][] = 'Nome é nesessário';
            $data['status'] = FALSE;
        }
        
        if($this->input->post('data_requisicao') == '')
        {
            $data['inputerror'][] = 'data_requisicao';
            $data['error_string'][] = 'Data é nesessária';
            $data['status'] = FALSE;
        }
        
        if($this->input->post('dep_requisicao') == '')
        {
            $data['inputerror'][] = 'dep_requisicao';
            $data['error_string'][] = 'Departamento Solicitante é nesessário';
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
	
 
}