<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_ajuste extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function save_tipo($data)
    {
        $this->db->insert('tipo_ajuste', $data);
        return $this->db->insert_id();

    }
    public function save_ajuste($data)
    {
        $this->db->insert('ajustes', $data);
        return $this->db->insert_id();

    }
    public function update_tipo($where, $data)
    {
        $this->db->update('tipo_ajuste', $data, $where);
        return $this->db->affected_rows();
    }
    function lista_tipo_ajuste(){
    $query = $this->db->get('tipo_ajuste');
    return $query->result();
    }
    public function get_tipo_by_id($id)
    {
        $this->db->from('tipo_ajuste');
        $this->db->where('id_tipo_ajuste',$id);
        $query = $this->db->get();
        return $query->row();
    }


    function lista_ajuste(){
    $this->db->join('tipo_ajuste', 'tipo_ajuste.id_tipo_ajuste=ajustes.tipo_ajuste');
    $this->db->join('funcionarios', 'funcionarios.id_funcionario=ajustes.usuario_ajuste');
    $query = $this->db->get('ajustes');
    return $query->result();
    }
    public function listTipo(){
     return $this->db->get('tipo_ajuste');
    }

  }
