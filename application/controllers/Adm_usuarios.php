<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adm_usuarios extends MY_Controller {

	public function __construct(){
		parent::__construct();
		//$this->check_isvalidated();
                $this->load->model('M_configuracoes');
                $this->load->helper('url');
                $this->load->library('grocery_CRUD');
                $this->load->model('Controleacesso');
                $this->load->model('M_usuarios');
	}
	
     
         public function _example_output($output = null)
	{     
               $this->load->model('Getuser');
        $data['title'] = "Página Inicial - ".$title_global;
        $data['headline'] = "Controle de Estoque";
        $this->load->view('v_header', $data);  
             
                $this->load->view('v_menu');
		$this->load->view('v_funcionarios_crud.php',$output);
                $this->load->view('v_footer');
	}
        

        public function index()
	{
            
         
	// controle de acesso
        $controller="adm_menus";
             if($this->Controleacesso->acesso($controller) == true){
       
            try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('funcionarios');
			$crud->set_subject('Funcionario');
                          $crud->unset_read();
                       // $crud->where('id_pai','1');
			$crud->required_fields('id_funcionario');
                        $crud->field_type('status','dropdown',
                        array( "1"  => "Ativo", "2" => "Inativo"));
                        $crud->set_relation_n_n( 'departamento', 'usuario_dep','departamentos', 'user_user','dep_user' ,'nome_departamento');
                        
                        $crud->set_relation( 'funcao_funcionario',  'funcoes', 'nome_funcao');
                        $crud->edit_fields('nome_funcionario','email_funcionario','funcao_funcionario', 'status', 'departamento');
			$crud->columns('id_funcionario', 'nome_funcionario','email_funcionario','funcao_funcionario','status');
                        $crud->display_as('nome_menu','Nome do menu')
				 ->display_as('pai_menu','Menu Relacionado')
                                ->display_as('acesso_menu','Permissão de acesso')
				 ;
                       $crud->add_action('Edit. Senha', '', 'adm_usuarios/edit_senha','ui-icon-pencil');
                      // $crud->unset_jquery();
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
        
        public function edit_senha($id) {
           $data['id'] = $id;
           $this->load->view('v_header');
           $this->load->view('v_menu');
           $this->load->view('v_altera_senha',$data);
            
        }
         public function edit_senha2($id)
	{
            
         
	// controle de acesso
        $controller="adm_menus";
             if($this->Controleacesso->acesso($controller) == true){
       
            try{
			$crud = new grocery_CRUD($id);

			$crud->set_theme('datatables');
			$crud->set_table('funcionarios');
			$crud->set_subject('Funcionario');
                        $crud->where('id_funcionario',$id);
                        $crud->unset_add();
                        $crud->unset_delete();
                      
			$crud->required_fields('id_funcionario');
                        $crud->field_type('status','dropdown',
                        array( "1"  => "Ativo", "2" => "SubInativoMenu"));
                        $crud->set_relation( 'funcao_funcionario',  'funcoes', 'nome_funcao');
                        $crud->edit_fields('senha_funcionario');
			$crud->columns('id_funcionario', 'nome_funcionario','email_funcionario','funcao_funcionario','status');
                        $crud->display_as('nome_menu','Nome do menu')
				 ->display_as('pai_menu','Menu Relacionado')
                                ->display_as('acesso_menu','Permissão de acesso')
				 ;
                       //$crud->add_action('Edit. Senha', '', 'adm_usuarios/edit_senha','ui-icon-pencil');
                      // $crud->unset_jquery();
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
        
//}