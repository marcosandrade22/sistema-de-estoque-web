<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configuracoes extends MY_Controller {

	public function Configuracoes()  {
		parent::__construct();
		//$this->check_isvalidated();
                $this->load->model('M_configuracoes');
                $this->load->library('grocery_CRUD');
               
	}
	
       
         
        public function adm_menus()
	{
            
       
	// controle de acesso
            $this->load->model('Controleacesso');
            $controller="adm_menus";
             if($this->Controleacesso->acesso($controller) == true){
       
            try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('menu');
			$crud->set_subject('Menus');
                        $crud->where('id_pai','1');
			$crud->required_fields('id_menu');
                        $crud->set_relation( 'pai_menu',  'menu', 'nome_menu');
                        //$crud->field_type('tipo_menu','dropdown',
                        //  array( "1"  => "Principal", "2" => "Sub-Menu"));
                        //$crud->set_relation( 'acesso_menu',  'funcoes', 'nome_funcao');
			$crud->set_relation('tipo_menu','menu_sub', 'tipo_pai' );
                        $crud->set_relation_n_n( 'acesso_menu', 'acesso_menu','funcoes', 'menu_id','funcao_id' ,'nome_funcao');
                        $crud->columns('nome_menu','apelido','acesso_menu');
                        $crud->display_as('nome_menu','Nome do menu')
				 ->display_as('pai_menu','Menu Relacionado')
                                ->display_as('acesso_menu','Permissão de acesso')
				 ;
                       $crud->add_action('Menus', '', 'configuracoes/sub_menu','ui-icon-plus');
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
            $controller="menus";
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