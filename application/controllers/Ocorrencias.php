<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ocorrencias extends MY_Controller {

	public function __construct(){
		parent::__construct();
		//$this->check_isvalidated();
                $this->load->model('M_configuracoes');
                $this->load->helper('url');
                $this->load->library('grocery_CRUD');
                $this->load->model('Controleacesso');
	}
	
        public function index(){
            $this->load->view('v_header',$data);
           $this->load->view('v_menu',$data);
        }
}