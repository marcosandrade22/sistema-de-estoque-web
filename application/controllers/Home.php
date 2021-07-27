<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
    
	public function __construct()
    {
        parent::__construct();
	}
	
	/*private function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            redirect('login');
        }
    }*/
	
	public function sair(){
        $this->session->sess_destroy();
        redirect('login');
        }
        public function debug(){
            $this->output->enable_profiler(TRUE);
        }

        public function index()
	{
        
        $this->load->model('M_home');
        $this->load->model('Getuser');
        $data['title'] = "Página Inicial - ".title_global;
        $data['headline'] = "Controle de Estoque";
        $data['resumo'] = $this->M_home->resumo_estoque();
        $data['qt_resumo'] = $this->M_home->qt_resumo();
        $this->load->view('v_header', $data);
        $this->load->view('v_menu', $data);
        $this->load->view('v_home', $data);
		}
        
       function listar()
	{
           $this->load->model('M_produto','',TRUE);
            $qry = $this->M_produto->listProduto();
            $table = $this->table->generate($qry);
            $tmpl = array ( 'table_open'  => '<table id="tabela" class="table table-striped table-responsive">' );
            $this->table->set_template($tmpl);
            $this->table->set_empty("&nbsp;"); 
            $this->table->set_heading('Editar', 'Codigo', 'Nome', 'Categoria', 'Unidade',  'Excluir');
            $table_row = array();
		foreach ($qry->result() as $produto)
		{
			$table_row = NULL;
			$table_row[] = anchor('produto/edit/' . $produto->id_produto, '<span class="ui-icon ui-icon-pencil"></span>');
			$table_row[] = $produto->id_produto;
			$table_row[] = $produto->nome_produto;
			$table_row[] = $produto->departamento_produto;
			$table_row[] = $produto->quantidade_produto;
			//$table_row[] = $produto->qtd_minima;
			$table_row[] = anchor('produto/delete/' . $produto->id_produto, '<span class="ui-icon ui-icon-trash"></span>', 
							"onClick=\" return confirm('Tem certeza que deseja remover o registro?')\"");
			$this->table->add_row($table_row);
		}    
		$table = $this->table->generate();
		$data['title'] = "Listagem de Produtos - Controle de Estoque";
		$data['headline'] = "Listagem de Produtos";
		$data['include'] = 'produto_listing';
		$data['data_table'] = $table;
                $this->load->view('template',$data);
		$this->load->view('template_lista', $data);
	}
}