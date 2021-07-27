<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_nota extends CI_Model {
 
    var $table = 'nota';
    var $column_order = array('data_nota', 'id_fornecedor', 'numero_nota', 'cod_nota'); //set column field database for datatable orderable
    var $column_search = array('data_nota', 'id_fornecedor', 'numero_nota', 'cod_nota'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('data_visao' => 'desc'); // default order
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    public function get_nota($id){
        $this->db->where('cod_nota', $id);
        //$this->db->join('departamentos', 'departamentos.id_departamento=nota.departamento_nota');
        $this->db->join('fornecedor', 'fornecedor.id_fornecedor=nota.id_fornecedor');
        $query = $this->db->get('nota');
        return $query->result();
        
    }
    public function lista_itens_nf($id){
            //$this->db->join('departamentos', 'departamentos.id_departamento=estoque_nf.departamento_estoque');
        $this->db->join('produtos', 'produtos.id_produto=estoque_nf.produto_estoque');
        $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
        $this->db->where('id_nf_estoque', $id);
        $query = $this->db->get('estoque_nf');
        return $query->result();
        
    }
    public function grava_itens_nf($data) {
        //print_r($data);
          $this->db->insert('estoque_nf', $data);  
    }

     public function listProdutoDep($id){
         $this->db->where('departamento_produto', $id);
     return $this->db->get('produtos');
    // return $query->result();   
    }
    
    public function listProduto(){
        $this->db->order_by('nome_produto', 'asc');
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
    public function ListaDep() {
          return $this->db->get('departamentos');
    }
    
    public function listNota(){
        $this->db->order_by('data_nota', 'DESC');
		$this->db->join('fornecedor', 'fornecedor.id_fornecedor=nota.id_fornecedor');
     $query = $this->db->get('nota');
     return $query->result();   
    }
     public function delete($id = null){
		if ($id) {
                    $this->db->where('id_estoque', $id);
                    return $this->db->delete('estoque_nf');
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
    
    public function remove_item_nf($produto, $nota)
    {
        $this->db->where('produto_estoque', $produto);
        $this->db->where('id_nf_estoque', $nota);
        return $this->db->delete('estoque');
    }
    public function remove_item_rq($produto, $requisicao)
    {
        $this->db->where('produto_estoque', $produto);
        $this->db->where('id_rq_estoque', $requisicao);
        return $this->db->delete('estoque');
    }
    public function remove_item_requisicao($produto, $nota)
    {
        $this->db->where('produto_estoque', $produto);
        $this->db->where('id_nf_estoque', $nota);
        $this->db->delete('estoque'); 
        
    }
    
    public function checa_movimento_posterior($id){
        $this->db->where('produto_estoque', $id);
        $this->db->order_by('id_estoque', 'desc');
        $query = $this->db->get('estoque');
       $row = $query->row();
        return $row->id_estoque;
    }
     public function qt_remove($produto, $nota)
        {
        $this->db->where('produto_estoque', $produto);
        $this->db->where('id_nf_estoque', $nota);
        $this->db->select_sum('entrada_estoque');
        $query = $this->db->get('estoque');
        $row = $query->row();
        return $row->entrada_estoque;
        }
     public function qt_remove_bk($produto, $nota)
    {
        $this->db->where('produto_estoque', $produto);
        $this->db->where('id_nf_estoque', $nota);
        $query = $this->db->get('estoque');
        return $query->result();
       
    }
    public function checa_item_nf($id_nf, $id_produto){
        $this->db->where('id_nf_estoque', $id_nf);
        $this->db->where('produto_estoque', $id_produto);
        $query = $this->db->get('estoque_nf');
        return $query->row();
    }
    public function checa_item_rq($id_nf, $id_produto){
        $this->db->where('id_req_est', $id_nf);
        $this->db->where('id_pro_req_est', $id_produto);
        $query = $this->db->get('estoque_rq');
        return $query->row();
    }
    public function checa_item_rq_qt($id_produto){
        //$this->db->where('id_req_est', $id_nf);
        $this->db->join('requisicao', 'requisicao.id_requisicao=estoque_rq.id_req_est');
        $this->db->where('fechado', 0);
        $this->db->where('id_pro_req_est', $id_produto);
        $query = $this->db->get('estoque_rq');
        $row = $query->row();
        return $row->qt_pro_req_est;
    }
    
     public function check_last($id_produto){
        
        $this->db->where('produto_estoque', $id_produto);
        $this->db->order_by('id_estoque', 'desc');
        $this->db->limit(1);
        // $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
       // $this->db->where('id_dep_qt', $departamento);
        $query = $this->db->get('estoque');
        return $query->result();
       
    }
   
    public function check_last_estoque_bk($id_produto){
        $this->db->where('produto_estoque', $id_produto);
        $this->db->order_by('id_estoque', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('estoque');
        $row = $query->row();
        return $row->quantidade_estoque;
    }
    public function check_last_estoque($id_produto){
        $this->db->where('id_produto', $id_produto);
        $query = $this->db->get('produtos');
        $row = $query->row();
        return $row->qt_produto;
    }
    
    public function check_last_custo($id_produto){
        
        $this->db->where('produto_estoque', $id_produto);
        $this->db->where('tipo_movimento', 1);
        $this->db->order_by('id_estoque', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('estoque');
        $row = $query->row();
        return $row->custo_medio;
       
    }
    public function check_produto($id_produto){
        
        $this->db->where('id_produto_qt', $id_produto);
        // $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
       // $this->db->where('id_dep_qt', $departamento);
         $query = $this->db->get('estoque_qt');
        return $query->row();
       
    }
    
    public function check_produto_qt($id_produto){
        
        $this->db->where('id_produto_qt', $id_produto);
       // $this->db->where('id_dep_qt', $departamento);
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
       $this->db->insert('estoque', $data);
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
    public function update_qt($dados, $id_produto) {
      $this->db->where('id_produto_qt', $id_produto);
     // $this->db->where('id_dep_qt', $departamento);  
      $this->db->update('estoque_qt', $dados);
    }
    public function update_qt_produto($quantidade, $id_produto) {
         $dados = array(
                       "qt_produto" => $quantidade
                       );
      $this->db->where('id_produto', $id_produto);
     // $this->db->where('id_dep_qt', $departamento);  
      $this->db->update('produtos', $dados);
    }
 
 
}