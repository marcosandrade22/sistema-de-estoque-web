<?php

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adm_usuarios_bk extends MY_Controller {

    public function __construct()
	{
	parent::__construct();

	$this->load->database();
	$this->load->helper('url');
        $this->load->model('M_usuarios');
          $this->load->model('Controleacesso');
       
          }
          public function index()
	{
         //controle de acesso
        $controller="adm_usuarios";
        if($this->Controleacesso->acesso($controller) == true){
        $data['pagina'] = "Usuários";
        $data['lista'] = $this->M_usuarios->lista_usuarios();
        $data['funcao'] = $this->M_usuarios->lista_func();
        $data['departamento'] = $this->M_usuarios->get_dep();
        $data['title'] = "Usuários - ".title_global;
        $this->load->model('Getuser');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $this->load->view('v_usuarios', $data);
        
             }
        else{
          $this->load->view('v_header',$data);  
          $this->load->view('sem_acesso');
        }
                        
	}
        
         public function ajax_add()
         {
        $this->_validate();
        $data = array(
            
            'nome_funcionario' => $this->input->post('nome'),
            'email_funcionario' => $this->input->post('email'),
            'funcao_funcionario' => $this->input->post('funcao'),
            'departamento' => $this->input->post('departamento'),
            'status' => $this->input->post('status'),
           
            );
        $insert = $this->M_usuarios->save($data);
        echo json_encode(array("status" => TRUE));
         }
 
        
          public function ajax_edit($id)
        {
        $data = $this->M_usuarios->get_by_id($id);
        // $data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
        }
          
        public function ajax_update()
        {
        $this->_validate();
       
        $data = array(
            
            'nome_funcionario' => $this->input->post('nome'),
            'email_funcionario' => $this->input->post('email'),
            'funcao_funcionario' => $this->input->post('funcao'),
            'departamento' => $this->input->post('departamento'),
            'status' => $this->input->post('status'),
           
            );
        $this->M_usuarios->update($this->input->post('id_funcionario'),$data);
        echo json_encode(array("status" => TRUE));
        }
        
          public function ajax_update_pass()
        {
       $this->_validate_pass();
      
        $data = array(
            
            'senha_funcionario' => sha1($this->input->post('senha')),
            );
        $this->M_usuarios->update($this->input->post('id_funcionario'),$data);
        echo json_encode(array("status" => TRUE));
        }
        
        public function ajax_delete($id)
    {
        $this->M_usuarios->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
    
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('nome') == '')
        {
            $data['inputerror'][] = 'nome';
            $data['error_string'][] = 'Nome é nesessário';
            $data['status'] = FALSE;
        }
        
        if($this->input->post('email') == '')
        {
            $data['inputerror'][] = 'email';
            $data['error_string'][] = 'E-mail é nesessário';
            $data['status'] = FALSE;
        }
        
         if($this->input->post('funcao') == '')
        {
            $data['inputerror'][] = 'funcao';
            $data['error_string'][] = 'Função é nesessário';
            $data['status'] = FALSE;
        }
 
         if($this->input->post('status') == '')
        {
            $data['inputerror'][] = 'status';
            $data['error_string'][] = 'Status é nesessário';
            $data['status'] = FALSE;
        }
        
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
    
    private function _validate_pass()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
 
        if($this->input->post('senha') == '')
        {
            $data['inputerror'][] = 'senha';
            $data['error_string'][] = 'Senha é nesessária';
            $data['status'] = FALSE;
        }
         if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
 
 
 
 
}