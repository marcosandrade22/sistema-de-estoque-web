<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_usuarios extends CI_Model {
 
    var $table = 'produtos';
    var $column_order = array('nome_produto'); //set column field database for datatable orderable
    var $column_search = array('id_produto','nome_produto'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('id_produto' => 'desc'); // default order
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
     function lista_usuarios(){
    $this->db->join('funcoes', 'funcoes.id_funcao=funcionarios.funcao_funcionario');
    $query = $this->db->get('funcionarios');
    return $query->result();  
    }
    
    public function get_dep(){
     return $this->db->get('departamentos');   
    }
    public function print_funcao($id){
    $this->db->where('id_funcao',$id);  
    $query = $this->db->get('funcoes');
      foreach ($query->result() as $row):
          $funcao = $row->nome_funcao;
      endforeach;
      echo $funcao;
    }

    public function get_by_id($id){
        $this->db->where('id_funcionario',$id);
        $query = $this->db->get('funcionarios');
 
        return $query->row();
    }
    public function lista_func(){
    return $this->db->get('funcoes');
     }
     
      public function update($where, $data)
    {
      $this->db->where('id_funcionario', $where);
      $this->db->update('funcionarios', $data);
      return $this->db->affected_rows();
    }
    
    public function delete_by_id($id)
    {
        $this->db->where('id_funcionario', $id);
        $this->db->delete('funcionarios');
    }
      public function save($data)
    {
        $this->db->insert('funcionarios', $data);
        return $this->db->insert_id();
   
    }
 
}