<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_produto extends CI_Model {
 
    var $table = 'produtos';
    var $column_order = array('id_produto','cod_barras','nome_produto','imagem_produto','nome_departamento','qt_produto', 'preco_venda'); //set column field database for datatable orderable
    var $column_search = array('id_produto','cod_barras','nome_produto','imagem_produto','nome_departamento','qt_produto', 'preco_venda'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('id_produto' => 'asc'); // default order
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
         
        $this->db->from($this->table);
        
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
            
        }
    }
 
     function get_datatables()
    {
    $this->load->model('Controleacesso');
    if($this->Controleacesso->acesso_dep() == true){
        
    }else{
        $dep_arr = M_produto::dep_array();
        $this->db->where_in('departamento_produto',$dep_arr);
       // $this->db->where('id_dep_qt',$this->session->userdata('Departamento'));
    }
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        
        $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
       // $this->db->join('estoque', 'estoque.produto_estoque=produtos.id_produto');
        $query = $this->db->get();
        return $query->result();
   
    }
    function count_filtered()
    {
        $this->_get_datatables_query();
         $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
    function lista_produto(){
     $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
    // $this->db->join('produtos', 'estoque_qt.id_produto_qt=produtos.id_produto');
    $query = $this->db->get('produtos');
    return $query->result();  
    }
    function lista_produto_id($id){
    $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
   $this->db->where('id_produto',$id);
    $query = $this->db->get('produtos');
    return $query->result();  
    }
     function lista_produto_array($id){
    $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
    $this->db->where_in('id_produto',$id);
    $query = $this->db->get('produtos');
    return $query->result();  
    }
    
    public function nome_produto($id){
       $this->db->where('id_produto',$id);
    $query = $this->db->get('produtos');
    //return $query->result();  
    foreach($query->result() as $produto):
     $nome = $produto->nome_produto;
      endforeach;
      return $nome;
    }
    
    public function nome_departamento($id){
    $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
    $this->db->where('id_produto',$id);
    $query = $this->db->get('produtos');
    //return $query->result();  
    foreach($query->result() as $produto):
     $nome = $produto->nome_departamento;
      endforeach;
      return $nome;
    }


  
    public function dep_array(){
         
         $this->db->where('user_user', $this->session->userdata('ID'));
         $query = $this->db->get('usuario_dep');
        $dep_arr = array();
         foreach($query->result() as $dep):
         $dep_arr[] = $dep->dep_user;
            endforeach;
         return $dep_arr;
    }
     public function get_produto_id($id)
    {
        /*$this->db->from($this->table);
        $this->db->where('id_produto',$id);
        $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
        $query = $this->db->get();
 
        return $query->result();*/
        
	$this->db->where('id_produto', $id);
	
	  $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
         return $this->db->get('produtos');
    }
 
  
 
    
 
    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('id_produto',$id);
        $this->db->join('estoque_qt', 'estoque_qt.id_produto_qt=produtos.id_produto');
        $query = $this->db->get();
 
        return $query->row();
    }
    public function get_by_id0($id)
    {  $this->db->from($this->table);
        $this->db->where('id_produto',$id);
         $query = $this->db->get();
 
        return $query->row();
    }
    public function check_estoque($id) {
      $this->db->where('id_produto_qt',$id);
         $query = $this->db->get(estoque_qt);
         return $query->num_rows();
    }
    public function check_estoque2($id) {
        $this->db->where('id_produto',$id);
         $query = $this->db->get('produtos');
         return $query->num_rows();
    }
    public function check_cat($id) {
      $this->db->where('id_produto',$id);
       $query = $this->db->get('produtos');
    
    foreach($query->result() as $produto):
     $nome = $produto->departamento_produto;
      endforeach;
      return $nome;
    }
     public function nome_cat($id) {
      $this->db->where('id_produto',$id);
      $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
      $query = $this->db->get('produtos');
    
    foreach($query->result() as $produto):
     $nome = $produto->nome_departamento;
      endforeach;
      return $nome;
    }
    
      public function store($dados = null, $id = null) {
		
		if ($dados) {
			if ($id) {
				$this->db->where('id_produto', $id);
				if ($this->db->update("produtos", $dados)) {
					return true;
				} else {
					return false;
				}
			} else {
				if ($this->db->insert("produtos", $dados)) {
					return true;
				} else {
					return false;
				}
			}
		}
		
	}
          public function store_imagem($dados = null, $id = null) {
		//print_r($dados);
                //echo $id;
		if ($dados) {
			
				$this->db->where('id_produto', $id);
				if ($this->db->update("produtos", $dados)) {
					return true;
				} else {
					return false;
				}
			
		}
		
	}
    public function save($data)
    {
        $this->db->insert('produtos', $data);
        return $this->db->insert_id();
      
    }
 
    public function update($where, $data)
    {
        $this->db->update('produtos', $data, $where);
        return $this->db->affected_rows();
    }
 
    public function delete_by_id($id)
    {
        $this->db->where('id_produto', $id);
        $this->db->delete($this->table);
    }
 
 
}