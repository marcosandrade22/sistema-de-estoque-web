<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Produtos extends MY_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_produto', 'produtos');
        $this->load->model('Controleacesso');
         $this->load->model('M_nota', '', TRUE);
    }
 
    public function index(){
        // controle de acesso
        
        $controller="produtos";
        if($this->Controleacesso->acesso($controller) == true){
            
        $data['pagina'] = "Produtos";
        $data['title'] = "Produtos - ".title_global;
        $this->load->model('Getuser');
        $this->load->helper('url');
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
 
    public function ajax_list()
    {
        $list = $this->produtos->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $produtos) {
            $no++;
            $row = array();
            $row[] = $produtos->id_produto;
            $row[] = $produtos->nome_produto;
            $row[] = $produtos->cod_barras;
            
            $last =  $this->M_nota->check_last($produtos->id_produto);   
            foreach($last as $qt):
                 //pega o ultimo estoque   
             $ultimo_estoque = $qt->quantidade_estoque;
            endforeach;
            $row[] = $ultimo_estoque;
            
            //$row[] = $produtos->lastName;
            //$row[] = $produtos->gender;
            //$row[] = $produtos->address;
            //$row[] = $produtos->dob;
 
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_produtos('."'".$produtos->id_produto."'".')"><i class="glyphicon glyphicon-pencil"></i> Editar</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_produtos('."'".$produtos->id_produto."'".')"><i class="glyphicon glyphicon-trash"></i> Del</a>';
         
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
 
    public function ajax_edit($id)
    {
        $data = $this->produtos->get_by_id($id);
       // $data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $this->_validate();
        $data = array(
               'nome_produto' => $this->input->post('nome_produto'),
               'cod_barras' => $this->input->post('cod_barras'),
               'descricao_produto' => $this->input->post('descricao_produto'),
            );
        $insert = $this->produtos->save($data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
       
        $data = array(
                'nome_produto' => $this->input->post('nome_produto'),
                'cod_barras' => $this->input->post('cod_barras'),
                'descricao_produto' => $this->input->post('descricao_produto'),
            );
        $this->produtos->update(array('id_produto' => $this->input->post('id_produto')), $data);
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
 
}