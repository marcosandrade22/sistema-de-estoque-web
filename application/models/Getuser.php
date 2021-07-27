<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Getuser extends CI_Model{
     public function get_user($tabela,$email) {
   
      $query = $this->db->get_where($tabela, array('email_funcionario' => $email));
      return $query->row_array();
       
     }
     
     public function get_usuario($tabela,$email) {
   
      $query = $this->db->get_where($tabela, array('email_usuario' => $email));
      return $query->row_array();
       
     }
     
      public function get_hash($tabela,$hash) {
   
      $query = $this->db->get_where($tabela, array('hash' => $hash));
      return $query->row_array();
       
     }
     
     public function get_funcao($tabela,$id) {
   
      $query = $this->db->get_where($tabela, array('id_funcionario' => $id));
      return $query->row_array();
       
     }
     
      public function get_nome($id){
        $this->db->where('id_funcionario', $id);
        $query = $this->db->get('funcionarios');
        $row = $query->row();
		
		if($row){
			return $row->nome_funcionario;
		}
    }
}
?>