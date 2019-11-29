<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MY_Controller extends CI_Controller {
 
 	public function __construct()
    {
        parent::__construct();
        
              $this->load->library('session');
              $this->load->helper('url');
			$logado = $this->session->userdata("logado");
			
     
			if ($logado != 1) {
                redirect('/login');	
               
            }
					
       }
       
       public function acesso_usuario() {
           $this->load->library('session');
               $this->load->helper('url');
			$logado = $this->session->userdata("user_logado");
			
			if ($logado != 1) 
				 redirect('/index.php');
           
       }
}
?>