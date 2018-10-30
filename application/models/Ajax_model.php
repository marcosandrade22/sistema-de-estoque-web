<?php if (! defined('BASEPATH')) exit('No direct script access');

class Ajax_model extends CI_Model
{
    public function __construct()
        {
                $this->load->database();
        }

    public function search ($title){
        //$this->db->select('title');
        //$this->db->select('text');
        $this->db->like('nome_produto', $title, 'both');
        $query = $this->db->get('produtos');
        return $query->result();
       // return $this->db->get('produtos')->result();
    }
    
     function lookup($keyword){ 
        $this->db->select('*')->from('produtos'); 
        $this->db->like('printable_name',$keyword,'after'); 
        //$this->db->or_like('iso',$keyword,'after'); 
        $query = $this->db->get();     
        return $query->result(); 
    }
    
    function get_itens($q){
    $this->db->select('nome_produto');
    $this->db->like('nome_produto', $q);
    $query = $this->db->get('produtos');
    if($query->num_rows() > 0){
      foreach ($query->result_array() as $row){
        //$new_row['nome'] = htmlentities(stripslashes($row['nome_produto'])); //build an array
        //$new_row['value']=htmlentities(stripslashes($row['aka']));
        $row_set[] = htmlentities(stripslashes($row['nome_produto'])); //build an array
      }
      echo json_encode($row_set); //format the array into json data
    }
  }
    
     function getEmployee($search){
    $this->db->select("NOME_PRODUTO");
     $whereCondition = array('NOME_PRODUTO' =>$search);
     $this->db->where($whereCondition);
    $this->db->from('produtos');
     $query = $this->db->get();
    return $query->result();
 }

}

?>