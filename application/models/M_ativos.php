<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_ativos extends CI_Model {
 
    var $table = 'ativos';
    var $column_order = array('nome_produto'); //set column field database for datatable orderable
    var $column_search = array('id_produto','nome_produto'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('id_produto' => 'desc'); // default order
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    
     public function get_requisicao($id){
       $this->db->where('id_rq_ativo', $id);
       $this->db->join('departamentos', 'departamentos.id_departamento=requisicao_ativo.dep_rq_ativo');
       $query = $this->db->get('requisicao_ativo');
       return $query->result();
        
    }
    
  
    public function listProduto(){
    $this->db->order_by('nome_ativo', 'asc');
    $this->db->join('departamentos', 'departamentos.id_departamento=ativos.dep_ativo');
    //$this->db->join('estoque_qt', 'estoque_qt.id_produto_qt=produtos.id_produto');
     return $this->db->get('ativos');
    // return $query->result();   
    }
      
    public function lista_itens_rq($id){
       
        
        $this->db->join('ativos', 'ativos.id_ativo=estoque_rq_ativo.id_produto_rq_ativo');
        $this->db->join('departamentos', 'departamentos.id_departamento=ativos.dep_ativo');
        $this->db->where('id_requisicao_rq_ativo', $id);
        $query = $this->db->get('estoque_rq_ativo');
        return $query->result();
    }
    
    
    function lista_ativos(){
     $this->db->join('departamentos', 'departamentos.id_departamento=ativos.dep_ativo');
    // $this->db->join('produtos', 'estoque_qt.id_produto_qt=produtos.id_produto');
    $query = $this->db->get('ativos');
    return $query->result();  
    }
    
    function lista_requisicoes(){
    $this->db->join('departamentos', 'departamentos.id_departamento=requisicao_ativo.dep_rq_ativo');
    // $this->db->join('produtos', 'estoque_qt.id_produto_qt=produtos.id_produto');
    $query = $this->db->get('requisicao_ativo');
    return $query->result();  
    }
    
    public function get_dep($param) {
        $this->db->where('id_departamento', $param);
       // $this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_requisicao');
        $query = $this->db->get('departamentos');
        foreach($query->result() as $dep):
        $nome = $dep->nome_departamento;
         endforeach;
         return $nome;
    }
   
      public function grava_itens_rq($data) {
        $this->db->insert('estoque_rq_ativo', $data);  
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
        $this->db->where('id_ativo',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
 
     public function get_rq_by_id($id)
    {
        $this->db->from('requisicao_ativo');
        $this->db->where('id_rq_ativo',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
    
    public function save($data)
    {
        $this->db->insert('ativos', $data);
        return $this->db->insert_id();
    }
     public function save_rq($data)
    {
      $this->db->insert('requisicao_ativo', $data);
      return $this->db->insert_id();
    }
    
 
 
    public function update($where, $data)
    { $this->db->where('id_ativo', $where);
      $this->db->update('ativos', $data);
      return $this->db->affected_rows();
    }
     public function update_rq($where, $data)
    { $this->db->where('id_rq_ativo', $where);
      $this->db->update('requisicao_ativo', $data);
      return $this->db->affected_rows();
    }
    public function delete_item_by_id($id)
    {
        $this->db->where('id_est_ativo', $id);
        $this->db->delete('estoque_rq_ativo');
    }
    
    public function fecha_rq($data){
        $this->db->where('id_rq_ativo', $data);
         $dados = array(
           "status_rq_ativo" => '1',
       );
       $this->db->update('requisicao_ativo', $dados);
    }
     public function abre_rq($data){
        $this->db->where('id_rq_ativo', $data);
         $dados = array(
           "status_rq_ativo" => '0',
       );
       $this->db->update('requisicao_ativo', $dados);
    }
    public function baixa_rq($data){
        $this->db->where('id_rq_ativo', $data);
        
         $dados = array(
           "devolvido" => '1',
             "data_devolucao" => date('Y-m-d'),
       );
       $this->db->update('requisicao_ativo', $dados);
    }
 
     public function lista_requisicoes_abertas_qt(){
      
    $this->db->where('status_rq_ativo',0);
    //$this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_requisicao');
    $query = $this->db->get('requisicao_ativo');
    if($query->num_rows() == 0){
     }else{
      return $query->num_rows();
     }
    }
    
      public function lista_requisicoes_nao_devolvidas(){
    $this->db->where('devolvido',0);
   //pode estar causando laco infinito
     $this->db->where('data_retorno <',date('Y-m-d'));  
    $query = $this->db->get('requisicao_ativo');
    if($query->num_rows() == 0){
     }else{
      return $query->num_rows();
     }
    }
    public function delete_by_id($id)
    {
        $this->db->where('id_produto', $id);
        $this->db->delete($this->table);
    }
 
    public function delete_rq_by_id($id)
    {
        $this->db->where('id_rq_ativo', $id);
        $this->db->delete('requisicao_ativo');
    }
    public function delete_itens_rq($id){
      $this->db->where('id_requisicao_rq_ativo', $id);
      $this->db->delete('estoque_rq_ativo');  
    }
 
}