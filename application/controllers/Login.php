<?php

/* 
 * Sistema Super Redação - todos os direitos reservados
 * Desenvolvido por Marcos Andrade
 * suportetuxinfo@gmail.com
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
    
      public function __construct() {
        parent::__construct();
        $this->load->database();
       
    }
    
	public function index()
	{
		$this->load->view('v_login');
	}
        
        public function logar(){
              
               $this->db->where('email_funcionario', $this->input->post('email')); 
               $this->db->where('senha_funcionario', sha1($this->input->post('senha')));
               $this->db->where('status', '1'); 
               $query = $this->db->get('funcionarios'); 
               
				// pegando post puro
				$usuario = $this->input->post("email");
		
		
				//Se o usuário e senha combinarem, então basta eu redirecionar para a url base, pois agora o usuário irá passa
				//pela verificação que checa se ele está logado.
					if ($query->num_rows() == 1) {
						
					    $this->session->set_userdata("logado", 1);
                        
						
                        //carregando o model para pegar o usuario
                        $this->load->model('Getuser');
                        $news = $this->Getuser->get_user('funcionarios',$usuario);
                        
						//armazena o usuario na variavel
                        $UsuarioNome = $news['nome_funcionario'];
                        $UsuarioID = $news['id_funcionario'];
                        $UsuarioFuncao = $news['funcao_funcionario'];
                        $Departamento = $news['departamento'];
                        
                        // define o nome do usuario na sessão
                        $this->session->set_userdata("Usuario",$UsuarioNome);
                        $this->session->set_userdata("ID",$UsuarioID);
                        $this->session->set_userdata("Funcao",$UsuarioFuncao);
                        $this->session->set_userdata("Departamento",$Departamento);
                         
                     
                      
                       if($Departamento == 7){
                           
                       }
                       else{
                          
                        //direciona para a pagina principal
                       redirect(base_url('home'));
                       }
		} else {
			//caso a senha/usuário estejam incorretos, então mando o usuário novamente para a tela de login com uma mensagem de erro.
			$dados['erro'] = "Usuário/Senha incorretos";
			$this->load->view("v_login", $dados);
		}
                
                
	}
        
        public function logout(){
		$this->session->unset_userdata("logado");
		redirect(base_url());
		
	}
}      
    ?>