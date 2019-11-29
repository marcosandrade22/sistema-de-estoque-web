<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_requisicao extends CI_Model {
 
    var $table = 'requisicao';
    var $column_order = array('id_requisicao', 'nome_requisicao', 'data_requisicao', 'nome_departamento', 'tipo_requisicao', 'fechado'); //set column field database for datatable orderable
    var $column_search = array( 'id_requisicao', 'nome_requisicao', 'data_requisicao'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('id_requisicao' => 'desc'); // default order
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
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
    
      public function listProduto_semzero_id($id){
   // $this->db->order_by('nome_produto', asc);
    $this->db->where('id_produto', $id);
    
    
   // $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
   // $this->db->join('estoque_qt', 'estoque_qt.id_produto_qt=produtos.id_produto');
   // $this->db->where('quantidade_qt !=', 0 );
     $query =  $this->db->get('produtos');
     //return $query->row();  
      $row = $query->row();
      return $row->qt_produto;
    }
 
    public function get_requisicao($id){
       $this->db->where('id_requisicao', $id);
       $this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_requisicao');
       $query = $this->db->get('requisicao');
       return $query->result();
        
    }
    public function check_itens($id){
       $this->db->where('id_req_est', $id);
       //$this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_requisicao');
       $query = $this->db->get('estoque_rq');
         return $query->row();
        
    }
     public function check_requisicao_fechada($id){
       $this->db->where('id_requisicao', $id);
       //$this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_requisicao');
       $query = $this->db->get('requisicao');
        $row = $query->row();
        return $row->fechado;
        
    }
    
    public function lista_itens_rq($id){
        //$this->db->join('dep_requisicao', 'dep_requisicao.id_dep_req=estoque_rq.departamento_estoque');
         // $this->db->join('estoque_qt', 'estoque_qt.id_produto_qt=estoque_rq.id_pro_req_est');
        $this->db->join('departamentos', 'departamentos.id_departamento=estoque_rq.departamento_rq');
        $this->db->join('produtos', 'produtos.id_produto=estoque_rq.id_pro_req_est');
        $this->db->where('id_req_est', $id);
        $query = $this->db->get('estoque_rq');
        return $query->result();
        
    }
     public function lista_itens_rq_dev($id){
        //$this->db->join('dep_requisicao', 'dep_requisicao.id_dep_req=estoque_rq.departamento_estoque');
         // $this->db->join('estoque_qt', 'estoque_qt.id_produto_qt=estoque_rq.id_pro_req_est');
        //$this->db->join('departamentos', 'departamentos.id_departamento=estoque.produto_estoque');
        $this->db->join('produtos', 'produtos.id_produto=estoque.produto_estoque');
         $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
        $this->db->where('id_nf_estoque', $id);
        $this->db->where('tipo_movimento', 3);
        $query = $this->db->get('estoque');
        return $query->result();
        
    }
    public function lista_requisicoes(){
          $this->load->model('Controleacesso');
    if($this->Controleacesso->acesso_dep() == true){
        
    }else{
         $dep_arr = M_requisicao::dep_array();
        $this->db->where_in('id_departamento',$dep_arr);
       // $this->db->where('id_departamento',$this->session->userdata('Departamento'));
        
    }
         $this->db->order_by('data_requisicao', 'DESC');
       // $this->db->join('dep_requisicao', 'dep_requisicao.id_dep_req=requisicao.dep_requisicao');
        $this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_requisicao');
       // $this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_cedente AND departamentos.id_departamento=requisicao.dep_requisicao', 'left');
        $query = $this->db->get('requisicao');
        return $query->result();
        
    }
    public function lista_requisicoes_tipo($data_in, $data_fim, $tipo){
          $this->load->model('Controleacesso');
    if($this->Controleacesso->acesso_dep() == true){
        
    }else{
         $dep_arr = M_requisicao::dep_array();
        $this->db->where_in('id_departamento',$dep_arr);
       // $this->db->where('id_departamento',$this->session->userdata('Departamento'));
        
    }
        $this->db->where('data_requisicao >=',$data_in);  
        $this->db->where('data_requisicao <=',$data_fim);     
        $this->db->order_by('data_requisicao', 'ASC');
        $this->db->where('tipo_requisicao',$tipo);
        $this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_requisicao');
       // $this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_cedente AND departamentos.id_departamento=requisicao.dep_requisicao', 'left');
        $query = $this->db->get('requisicao');
        return $query;
        
    }
    
    public function lista_requisicoes_dep($data_in, $data_fim, $departamento){
          $this->load->model('Controleacesso');
    if($this->Controleacesso->acesso_dep() == true){
        
        
    }else{
         $dep_arr = M_requisicao::dep_array();
        $this->db->where_in('id_departamento',$dep_arr);
       // $this->db->where('id_departamento',$this->session->userdata('Departamento'));
       
    }
        
        $this->db->where('data_requisicao >=',$data_in);  
        $this->db->where('data_requisicao <=',$data_fim); 
        $this->db->where('dep_requisicao',$departamento);
        $this->db->order_by('data_requisicao', 'DESC');
       // $this->db->join('dep_requisicao', 'dep_requisicao.id_dep_req=requisicao.dep_requisicao');
        $this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_requisicao');
       // $this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_cedente AND departamentos.id_departamento=requisicao.dep_requisicao', 'left');
        $query = $this->db->get('requisicao');
        return $query;
        
    }
     public function lista_requisicoes_dep_tipo($data_in, $data_fim, $departamento, $tipo){
          $this->load->model('Controleacesso');
    if($this->Controleacesso->acesso_dep() == true){
        
    }else{
         $dep_arr = M_requisicao::dep_array();
        $this->db->where_in('id_departamento',$dep_arr);
       // $this->db->where('id_departamento',$this->session->userdata('Departamento'));
       
    }
        $this->db->where('data_requisicao >=',$data_in);  
        $this->db->where('data_requisicao <=',$data_fim); 
        $this->db->where('dep_requisicao',$departamento);
         $this->db->where('tipo_requisicao',$tipo);
        $this->db->order_by('data_requisicao', 'DESC');
        $this->db->where('tipo_requisicao',$tipo);
        $this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_requisicao');
       // $this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_cedente AND departamentos.id_departamento=requisicao.dep_requisicao', 'left');
        $query = $this->db->get('requisicao');
        return $query;
        
    }
      public function lista_requisicoes_data($data_in, $data_fim){
          $this->load->model('Controleacesso');
    if($this->Controleacesso->acesso_dep() == true){
        
    }else{
         $dep_arr = M_requisicao::dep_array();
        $this->db->where_in('id_departamento',$dep_arr);
       // $this->db->where('id_departamento',$this->session->userdata('Departamento'));
        
    }
        $this->db->where('data_requisicao >=',$data_in);  
        $this->db->where('data_requisicao <=',$data_fim);        
        $this->db->order_by('data_requisicao', 'DESC');
       //$this->db->join('dep_requisicao', 'dep_requisicao.id_dep_req=requisicao.dep_requisicao');
        $this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_requisicao');
       // $this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_cedente AND departamentos.id_departamento=requisicao.dep_requisicao', 'left');
        $query = $this->db->get('requisicao');
        return $query;
        
    }
    
    public function lista_requisicoes_abertas(){
          $this->load->model('Controleacesso');
    if($this->Controleacesso->acesso_dep() == true){
        
    }else{
         $dep_arr = M_requisicao::dep_array();
        $this->db->where_in('id_departamento',$dep_arr);
       // $this->db->where('id_departamento',$this->session->userdata('Departamento'));
        
    }
    $this->db->where('fechado',0);
         $this->db->order_by('data_requisicao', 'DESC');
       // $this->db->join('dep_requisicao', 'dep_requisicao.id_dep_req=requisicao.dep_requisicao');
        $this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_requisicao');
       // $this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_cedente AND departamentos.id_departamento=requisicao.dep_requisicao', 'left');
        $query = $this->db->get('requisicao');
        return $query->result();
        
    }
    
     public function lista_requisicoes_abertas_qt(){
      
    $this->db->where('fechado',0);
    $this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_requisicao');
    $query = $this->db->get('requisicao');
    if($query->num_rows() == 0){
       
     }else{
      return $query->num_rows();
     }
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
   


    public function lista_dep_req(){
     $this->load->model('Controleacesso');
    if($this->Controleacesso->acesso_dep() == true){
        
    }else{
       $dep_arr = M_requisicao::dep_array();
        $this->db->where_in('id_departamento',$dep_arr);
       // $this->db->where('id_departamento',$this->session->userdata('Departamento'));
    }
    return $this->db->get('departamentos');
        //return $query->result();
        
    }
    
     public function lista_tipo_rq(){
    return $this->db->get('tipo_requisicao');
        //return $query->result();
        
    }
    public function grava_itens_rq($data) {
        //print_r($data);
        
          $this->db->insert('estoque_rq', $data);  
    }

    public function listProduto(){
         $this->db->order_by('nome_produto', 'asc');
    $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
    $this->db->join('estoque_qt', 'estoque_qt.id_produto_qt=produtos.id_produto');
     return $this->db->get('produtos');
    // return $query->result();   
    }
     public function listProduto_semzero(){
    $this->db->order_by('nome_produto', 'asc');
    
    $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
    //$this->db->join('estoque_qt', 'estoque_qt.id_produto_qt=produtos.id_produto');
    $this->db->where('qt_produto !=', 0 );
     return $this->db->get('produtos');
    // return $query->result();   
    }
    
     public function listProduto_semzero_bk(){
    $this->db->order_by('nome_produto', 'asc');
    
    $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
    $this->db->join('estoque_qt', 'estoque_qt.id_produto_qt=produtos.id_produto');
    $this->db->where('quantidade_qt !=', 0 );
     return $this->db->get('produtos');
    // return $query->result();   
    }
    public function listProdutoDep($id){
        $this->db->join('estoque_qt', 'estoque_qt.id_produto_qt=produtos.id_produto');
        $this->db->where('id_dep_qt' , $id);
        $this->db->where('quantidade_qt !=' , 0);
     return $this->db->get('produtos');
    // return $query->result();   
    }

    public function listDep(){
     return $this->db->get('dep_requisicao');
    // return $query->result();   
    }

    public function listFor(){
     return $this->db->get('fornecedor');
    // return $query->result();   
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
 
    
    
        public function lista_requisicoes2(){
          $this->load->model('Controleacesso');
    if($this->Controleacesso->acesso_dep() == true){
        
    }else{
         $dep_arr = M_requisicao::dep_array();
        $this->db->where_in('id_departamento',$dep_arr);
       // $this->db->where('id_departamento',$this->session->userdata('Departamento'));
        
    }
         $this->db->order_by('data_requisicao', 'DESC');
       // $this->db->join('dep_requisicao', 'dep_requisicao.id_dep_req=requisicao.dep_requisicao');
        $this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_requisicao');
       // $this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_cedente AND departamentos.id_departamento=requisicao.dep_requisicao', 'left');
        $query = $this->db->get('requisicao');
        return $query->result();
        
    }
    function get_datatables()
    {
     $this->load->model('Controleacesso');
    if($this->Controleacesso->acesso_dep() == true){
        
    }else{
         $dep_arr = M_requisicao::dep_array();
        $this->db->where_in('id_departamento',$dep_arr);
       // $this->db->where('id_departamento',$this->session->userdata('Departamento'));
        
    }
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        
       // $this->db->order_by('data_requisicao', 'DESC');
       $this->db->join('departamentos', 'departamentos.id_departamento=requisicao.dep_requisicao');
        
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
        $this->db->where('id_requisicao',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
    


    public function save($data)
    {
        $this->db->insert('requisicao', $data);
        return $this->db->insert_id();
    }
 
    public function update($data, $where)
    {
      $this->db->where('id_requisicao', $where);
      $this->db->update('requisicao', $data);
      return $this->db->affected_rows();
    }
 
    public function delete_by_id($id)
    {
        $this->db->where('id_est_rq', $id);
        $this->db->delete('estoque_rq');
    }
    public function delete_itens_rq($id){
      $this->db->where('id_req_est', $id);
      $this->db->delete('estoque_rq');  
    }
    
     public function delete_rq_by_id($id)
    {
        $this->db->where('id_requisicao', $id);
        $this->db->delete('requisicao');
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

    public function remove_qt($data, $where) {
      $this->db->where('id_dep_qt', $where);  
     ///  $this->db->insert('estoque_qt', $data);
      $this->db->update('estoque_qt', $data);
    }
    public function fecha_rq($data){
        $this->db->where('id_requisicao', $data);
         $dados = array(
           "fechado" => '1',
       );
       $this->db->update('requisicao', $dados);
    }
    public function abre_rq($data){
        $this->db->where('id_requisicao', $data);
         $dados = array(
           "fechado" => '0',
       );
       $this->db->update('requisicao', $dados);
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