<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_home extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function qt_resumo() {
      $query = $this->db->query("SELECT * FROM estoque_qt GROUP BY id_dep_qt");   
      
      return $query->result();
    }
    
     public function resumo_estoque() {
     $query = $this->db->get('departamentos');
     return $query->result();
     }
}