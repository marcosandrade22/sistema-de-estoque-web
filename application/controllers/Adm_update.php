<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Adm_update extends MY_Controller {
 
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
        $controller="adm_update";
        if($this->Controleacesso->acesso($controller) == true){
        
        $this->load->model('M_nota', '', TRUE);
        $data['pagina'] = "Atualização";
        $data['title'] = "Atualização - ".title_global;
        $this->load->model('Getuser');
        $this->load->helper('url');
        $this->load->view('v_header',$data);
        $this->load->view('v_menu');
        $this->load->view('v_update', $data);
        }
              else{
              $this->load->view('v_header',$data);  
              $this->load->view('sem_acesso');
           }
            
    }
    
}
