<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_devolucao extends CI_Model {
 
    var $table = 'visao_nota';
    var $column_order = array('data_visao', 'fornecedor_visao', 'numero_visao', 'visao_nota'); //set column field database for datatable orderable
    var $column_search = array('data_visao', 'fornecedor_visao', 'numero_visao', 'visao_nota'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('data_visao' => 'desc'); // default order
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    public function get_nota($id){
        $this->db->where('cod_nota', $id);
        $this->db->join('fornecedor', 'fornecedor.id_fornecedor=nota.id_fornecedor');
        $query = $this->db->get('nota');
        return $query->result();
        
    }
    public function lista_itens_nf($id){
        $this->db->join('departamentos', 'departamentos.id_departamento=estoque.departamento_estoque');
        $this->db->join('produtos', 'produtos.id_produto=estoque.produto_estoque');
        $this->db->where('id_nf_estoque', $id);
        $query = $this->db->get('estoque');
        return $query->result();
        
    }
    public function grava_itens_nf($data) {
          $this->db->insert('estoque', $data);  
    }

    
    
    public function listProduto(){
     return $this->db->get('produtos');
    // return $query->result();   
    }

    public function listDep(){
     return $this->db->get('departamentos');
    // return $query->result();   
    }

    public function listFor(){
     $query = $this->db->get('fornecedor');
     return $query->result();   
    }
    public function ListaFor() {
          return $this->db->get('fornecedor');
    }
    
    public function listNota(){
     $query = $this->db->get('visao_nota');
     return $query->result();   
    }
     public function delete($id = null){
		if ($id) {
                    $this->db->where('id_estoque', $id);
                    return $this->db->delete('estoque');
                    }
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
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
 
    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('visao_nota',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
    public function for_by_id($id){
        $this->db->where('id_fornecedor',$id);
        $query = $this->db->get('fornecedor');
        return $query->row();
    }
 
    public function save($data)
    {
        $this->db->insert('nota', $data);
        return $this->db->insert_id();
    }
     public function save_for($data)
    {
        $this->db->insert('fornecedor', $data);
        return $this->db->insert_id();
    }
 
    public function update($data, $where)
    {
       $this->db->where('cod_nota', $where);
      $this->db->update('nota', $data);
      return $this->db->affected_rows();
    }
    public function update_for($data, $where){
      $this->db->where('id_fornecedor', $where);
      $this->db->update('fornecedor', $data);
      return $this->db->affected_rows();
    }
 
    public function delete_by_id($id)
    {
        $this->db->where('cod_nota', $id);
        $this->db->delete('nota');
    }
    public function delete_for_by_id($id)
    {
        $this->db->where('id_fornecedor', $id);
        $this->db->delete('fornecedor');
    }
    
    public function check_produto($id_produto, $departamento){
        
        $this->db->where('id_produto_qt', $id_produto);
        $this->db->where('id_dep_qt', $departamento);
         $query = $this->db->get('estoque_qt');
        return $query->row();
       
    }
    
    public function check_produto_qt($id_produto, $departamento){
        
        $this->db->where('id_produto_qt', $id_produto);
        $this->db->where('id_dep_qt', $departamento);
         $query = $this->db->get('estoque_qt');
        //return $query->row();
       return $query->num_rows();
    }
    
    
    
     
    public function qt_produto($id_produto, $departamento){
        
        $this->db->where('id_produto_qt', $id_produto);
        $this->db->where('id_dep_qt', $departamento);
         $query = $this->db->get('estoque_qt');
        return $query->result();
       
    }

    public function adiciona_qt($data) {
       $this->db->insert('estoque_qt', $data);
     
    }
    public function fecha_nota($data){
        $this->db->where('cod_nota', $data);
         $dados = array(
           "fechado" => '1',
       );
       $this->db->update('nota', $dados);
    }
    public function abre_nota($data){
        $this->db->where('cod_nota', $data);
         $dados = array(
           "fechado" => '0',
       );
       $this->db->update('nota', $dados);
    }
    public function abrir_nota($data){
        $this->db->where('id_produto_qt', $data);
        return $this->db->delete('estoque_qt');
    }
    public function update_qt($dados, $id_produto, $departamento) {
      $this->db->where('id_produto_qt', $id_produto);
      $this->db->where('id_dep_qt', $departamento);  
      $this->db->update('estoque_qt', $dados);
    }
 
 
}