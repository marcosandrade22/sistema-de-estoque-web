<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adm_acesso extends MY_Controller {

	public function __construct(){
		parent::__construct();
		//$this->check_isvalidated();
                $this->load->model('M_configuracoes');
                $this->load->helper('url');
                $this->load->library('grocery_CRUD');
                $this->load->model('Controleacesso');
	}
	
     
         public function _example_output($output = null)
	{     
            
        $this->load->model('Getuser');
        $data['title'] = "Página Inicial - ".title_global;
        $data['headline'] = "Controle de Estoque";
        $this->load->view('v_header', $data);  
             
                $this->load->view('v_menu');
		$this->load->view('v_itens_menu.php',$output);
                $this->load->view('v_footer');
	}
        

        public function index()
	{
            
         
	// controle de acesso
        $controller="adm_acesso";
             if($this->Controleacesso->acesso($controller) == true){
       
            try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('funcao_programa');
			$crud->set_subject('Funcao');
                        //$crud->where('id_pai','1');
			$crud->required_fields('id_funcao');
                       //$crud->set_relation( 'pai_menu',  'menu', 'nome_menu');
                        
			//$crud->set_relation('tipo_menu','menu_sub', 'tipo_pai' );
                       //    $crud->set_relation_n_n( 'acesso_menu', 'acesso_menu','funcoes', 'menu_id','funcao_id' ,'nome_funcao');
                        
                        $crud->set_relation_n_n( 'acesso_funcao', 'acesso_funcao','funcoes', 'id_acesso_funcao','id_funcao_acesso' ,'nome_funcao');
                        $crud->columns('id_funcao','nome_funcao_acesso', 'acesso_funcao');
                       // $crud->display_as('nome_menu','Nome do menu')
			//	 ->display_as('pai_menu','Menu Relacionado')
                        //        ->display_as('acesso_menu','Permissão de acesso')
			//	 ;
                      // $crud->add_action('Menus', '', 'adm_menus/sub_menu','ui-icon-plus');
                      // $crud->unset_jquery();
            if($this->session->userdata("Funcao") == 1){    }
            else{
                $crud->unset_add();
                $crud->unset_delete();
                $crud->unset_edit();
            }
			$output = $crud->render();
                        

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
                  //fim do controle de acesso
                 } 
           else{
            $this->load->view('v_header',$data);  
            $this->load->view('sem_acesso');
           }
        }
        
         public function sub_menu($id){
          
            $this->load->model('Controleacesso');
            $controller="adm_menus";
             if($this->Controleacesso->acesso($controller) == true){
       
            try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('menu');
			$crud->set_subject('Menus');
                        $crud->where('pai_menu',$id);
			$crud->required_fields('id_menu');
                        $crud->order_by('nome_menu');
                        // $crud->set_relation( 'pai_menu',  'menu', 'nome_menu');
                        //$crud->set_relation( 'acesso_menu',  'funcoes', 'nome_funcao');
			
                        $crud->set_relation_n_n( 'acesso_menu', 'acesso_menu','funcoes', 'menu_id','funcao_id' ,'nome_funcao');
                        $crud->columns('nome_menu','apelido',  'acesso_menu');
                        $crud->display_as('nome_menu','Nome do menu')
			->display_as('pai_menu','Menu Relacionado')
                        ->display_as('acesso_menu','Permissão de acesso')
				 ;
                        $crud->edit_fields('nome_menu', 'apelido', 'link_menu', 'acesso_menu');
                        $crud->unset_add();
			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
                  //fim do controle de acesso
                 } 
           else{
               $this->load->view('admin/v_header_adm');
               $this->load->view('admin/v_menu');
               echo 'Acesso negado';
              // $this->load->view('v_acesso_negado');
           }
            
        }


}
        
//}