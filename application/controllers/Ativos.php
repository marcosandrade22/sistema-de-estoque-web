<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Ativos extends MY_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_ativos', '', TRUE);
        $this->load->model('Controleacesso');
         $this->load->model('M_nota', '', TRUE);
    }
 
    public function index(){
        // controle de acesso
        
        $controller="ativos";
        if($this->Controleacesso->acesso($controller) == true){
            
        $data['pagina'] = "Ativos";
        $data['title'] = "Ativos - ".title_global;
        $this->load->model('Getuser');
        $this->load->helper('url');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $data['lista'] = $this->M_ativos->lista_ativos();
        $data['departamento'] = $this->M_nota->listDep();
        $this->load->view('v_lista_ativos', $data);
        }
                  else{
                  $this->load->view('v_header',$data);  
                  $this->load->view('sem_acesso');
               }
    }
      public function gera_alerta_rq_ativo(){
       echo $this->M_ativos->lista_requisicoes_abertas_qt();
        }
       public function gera_alerta_rq_nao_devolvida(){
       echo $this->M_ativos->lista_requisicoes_nao_devolvidas();
        } 
        
    
     public function nova_requisicao(){
        // controle de acesso
        $controller="ativos/nova_requisicao";
        if($this->Controleacesso->acesso($controller) == true){
        
        $this->load->model('M_ativos', '', TRUE);
        $data['pagina'] = "Requisições de Ativo";
        $data['lista'] = $this->M_ativos->lista_requisicoes();
        $data['departamento'] = $this->M_nota->listDep();
        //$data['dep_ced'] = $this->requisicao->lista_dep_req();
       // $data['tipo'] = $this->requisicao->lista_tipo_rq();
        $data['title'] = "Requisições - ".title_global;
        $this->load->model('Getuser');
        $this->load->helper('url');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $this->load->view('v_requisicao_ativo', $data);
        }
         else{
                  $this->load->view('v_header',$data);  
                  $this->load->view('sem_acesso');
         }
    }
 
    public function add_itens($id){
      
   
        $data['pagina'] = "Requisição de Ativos- Adicionar Itens";
        $data['title'] = "Requisição - ".title_global;
        $data['nf'] = $this->M_ativos->get_requisicao($id);
        $data['itens'] = $this->M_ativos->lista_itens_rq($id);
       
        $this->load->model('Getuser');
        $this->load->helper('url');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $this->load->view('v_add_itens_rq_ativo', $data);
        $this->load->view('v_table_nota', $data);  
    }
    
    public function cadastra_item() {
       
        $produto = $this->input->post('id_produto_rq_ativo');
        $query4 = $this->db->query("SELECT * FROM ativos WHERE id_ativo=$produto");
        foreach($query4->result() as $item):
        $departamento = $item->dep_ativo;  
        $custo = $item->valor_ativo;
        endforeach;
        $dados = array(
        "vl_rq_ativo" => $custo,
        "id_requisicao_rq_ativo" => $this->input->post('id_rq_ativo'),
	"id_produto_rq_ativo" => $this->input->post('id_produto_rq_ativo'),
        "qt_rq_ativo" => $this->input->post('qt_rq_ativo'),
         );
       
        
            if ($this->M_ativos->grava_itens_rq($dados)) {
            }
           else{
               echo '<script>history.go(-1)</script>'; 
            redirect(base_url().'ativo/add_itens/'.$this->input->post('id_req_est'), 'refresh');
            }
        }
        
        public function delete_item(){
          
            $id = $this->input->post('id');
            $requisicao = $this->input->post('nota');
            if ( $this->M_ativos->delete_item_by_id($id)) {
             echo '<script>history.go(-1)</script>'; 
            }
            else{
            echo '<script>history.go(-1)</script>'; 
            }
        }
        
          public function fechar($id){
            $query4 = $this->db->query("SELECT * FROM estoque_rq_ativo INNER JOIN ativos ON ativos.id_ativo=estoque_rq_ativo.id_produto_rq_ativo WHERE id_requisicao_rq_ativo=$id ");
            foreach($query4->result() as $item):
            $id_produto =  $item->id_produto_rq_ativo;
            $requisicao = $item->id_reqisicao_rq_ativo;
            $quantidade = $item->qt_rq_ativo;
           
            $departamento = $item->dep_ativo;
            $query = $this->db->query("UPDATE ativos set disponivel_ativo = disponivel_ativo-$quantidade where dep_ativo=$departamento AND id_ativo=$id_produto");
            endforeach;
            
            $this->M_ativos->fecha_rq($id);
            echo '<script>history.go(-1), reload_table()</script>';
            }
            
             public function abrir($id){
            
            // consulta dados do produto na requisicao
            //$query4 = $this->db->query("SELECT * FROM estoque_rq_ativo INNER JOIN requisicao_ativo ON requisicao_ativo.id_rq_ativo=estoque_rq_ativo.id_requisicao_rq_ativo WHERE id_requisicao_rq_ativo=$id");
            $query4 = $this->db->query("SELECT * FROM estoque_rq_ativo INNER JOIN ativos ON ativos.id_ativo=estoque_rq_ativo.id_produto_rq_ativo WHERE id_requisicao_rq_ativo=$id ");
            foreach($query4->result() as $item):
            $id_produto =  $item->id_produto_rq_ativo;
            $requisicao = $item->id_requisicao_rq_ativo;
            $quantidade = $item->qt_rq_ativo;
            $cedente = $item->dep_ativo;
            //$departamento = $item->departamento_rq;
            $valor = $item->valor_rq_ativo;
          
            
            $query = $this->db->query("UPDATE ativos set disponivel_ativo = disponivel_ativo+$quantidade where dep_ativo=$cedente AND id_ativo=$id_produto");
            endforeach;
            $this->M_ativos->abre_rq($id);
            echo '<script>history.go(-1)</script>';
            
            }
            public function baixa_requisicao($id){
            
            // consulta dados do produto na requisicao
            //$query4 = $this->db->query("SELECT * FROM estoque_rq_ativo INNER JOIN requisicao_ativo ON requisicao_ativo.id_rq_ativo=estoque_rq_ativo.id_requisicao_rq_ativo WHERE id_requisicao_rq_ativo=$id");
            $query4 = $this->db->query("SELECT * FROM estoque_rq_ativo INNER JOIN ativos ON ativos.id_ativo=estoque_rq_ativo.id_produto_rq_ativo WHERE id_requisicao_rq_ativo=$id ");
            foreach($query4->result() as $item):
            $id_produto =  $item->id_produto_rq_ativo;
            $requisicao = $item->id_requisicao_rq_ativo;
            $quantidade = $item->qt_rq_ativo;
            $cedente = $item->dep_ativo;
            //$departamento = $item->departamento_rq;
            $valor = $item->valor_rq_ativo;
          
            
           $query = $this->db->query("UPDATE ativos set disponivel_ativo = disponivel_ativo+$quantidade where dep_ativo=$cedente AND id_ativo=$id_produto");
            endforeach;
            $this->M_ativos->baixa_rq($id);
            echo '<script>history.go(-1)</script>';
            
            }
            
            

    public function ativo_edit($id)
    {
        $data = $this->M_ativos->get_by_id($id);
       // $data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
    
     public function ativo_rq_edit($id)
    {
        $data = $this->M_ativos->get_rq_by_id($id);
       // $data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
 
 
    public function ativo_add()
    {
        $this->_validate();
        $data = array(
               'nome_ativo' => $this->input->post('nome_ativo'),
               'quantidade_ativo' => $this->input->post('quantidade_ativo'),
               'disponivel_ativo' => $this->input->post('quantidade_ativo'),
               'valor_ativo' => $this->input->post('valor_ativo'),
               'dep_ativo' => $this->input->post('dep_ativo'),
            );
        $insert = $this->M_ativos->save($data);
        echo json_encode(array("status" => TRUE));
    }
      public function ativo_rq_add(){
        $this->load->model('M_ativos', '', TRUE);
        
       // print_r($_POST);
        $id = $this->M_ativos->save_rq($_POST);
        redirect('ativos/add_itens/'.$id, 'refresh');
    }
 
    public function ativo_update()
    {
        $this->_validate();
       
        $data = array(
                'nome_ativo' => $this->input->post('nome_ativo'),
                'quantidade_ativo' => $this->input->post('quantidade_ativo'),
                'valor_ativo' => $this->input->post('valor_ativo'),
                'dep_ativo' => $this->input->post('dep_ativo'),
            );
        
        $this->M_ativos->update($this->input->post('id_ativo'), $data);
        echo json_encode(array("status" => TRUE));
    }
    
    
    
     public function ativo_rq_update()
    {
        //$this->_validate();
       
        $data = array(
                'nome_rq_ativo' => $this->input->post('nome_rq_ativo'),
                'data_saida' => date('Y-m-d'),
               'data_retorno' => $this->input->post('data_retorno'),
               'dep_rq_ativo' => $this->input->post('dep_rq_ativo'),
            );
        
        $this->M_ativos->update_rq($this->input->post('id_rq_ativo'), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ativo_delete($id)
    {
        //$this->produtos->delete_by_id($id);
        //echo json_encode(array("status" => TRUE));
    }
 
  public function ativo_rq_delete($id)
    {
        $this->M_ativos->delete_rq_by_id($id);
        $this->M_ativos->delete_itens_rq($id);
        echo json_encode(array("status" => TRUE));
    }
     public function gera_pdf($id){
        
        $data['nf'] = $this->M_ativos->get_requisicao($id);
        $data['produtos'] = $this->M_ativos->listProduto();
       $data['itens'] = $this->M_ativos->lista_itens_rq($id);
       
        
        $this->load->helper('mpdf');
        $html = $this->load->view('v_head_pdf_rq_at',$data, true);
        $html .= $this->load->view('v_rel_requisicao_at',$data, true);
      $filename = 'Requisicao_de_ativo_'.$id;
         pdf($html, $filename);
        }
    
 
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('nome_ativo') == '')
        {
            $data['inputerror'][] = 'nome_ativo';
            $data['error_string'][] = 'Nome é necessario';
            $data['status'] = FALSE;
        }
        if($this->input->post('quantidade_ativo') == '')
        {
            $data['inputerror'][] = 'quantidade_ativo';
            $data['error_string'][] = 'Quantidade é necessaria';
            $data['status'] = FALSE;
        }
        
        if($this->input->post('dep_ativo') == '')
        {
            $data['inputerror'][] = 'dep_ativo';
            $data['error_string'][] = 'Departamento é necessario';
            $data['status'] = FALSE;
        }
 
        
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
    public function info(){
       
        echo phpinfo();
    }
 
}