<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_estoqueqt extends CI_Model {
 
    var $table = 'estoque';
    var $column_order = array('nome_produto', 'id_produto', 'cod_barras', 'departamento_produto', 'quantidade_estoque','custo_medio', 'preco_estoque'); //set column field database for datatable orderable
    var $column_search = array('nome_produto', 'id_produto', 'cod_barras', 'departamento_produto', 'quantidade_estoque','custo_medio', 'preco_estoque'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('produto_estoque' => 'asc'); // default order
 
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
      //  $this->db->where('id_dep_qt',$this->session->userdata('Departamento'));
    }
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        
        
        $this->db->join('produtos', 'estoque.produto_estoque=produtos.id_produto');
        $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
        $query = $this->db->get();
        return $query->result();
   
    }
     function count_filtered()
    {
        $this->_get_datatables_query();
         
        ///$this->db->join('departamentos', 'departamentos.id_departamento=estoque_qt.id_dep_qt');
        $this->db->join('produtos', 'estoque.produto_estoque=produtos.id_produto');
        $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
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
    
     function lista_estoque(){
        $this->load->model('Controleacesso');
    if($this->Controleacesso->acesso_dep() == true){
        
    }else{ 
        $this->db->join('produtos', 'estoque_qt.id_produto_qt=produtos.id_produto');
         $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
         $dep_arr = M_estoqueqt::dep_array();
          $this->db->where_in('id_dep_qt',$dep_arr);
       // $this->db->where('id_dep_qt',$this->session->userdata('Departamento'));
    }
      ///  $this->db->join('departamentos', 'departamentos.id_departamento=estoque_qt.id_dep_qt');
       
        $query = $this->db->get('estoque_qt');
        return $query->result();  
    }
    
    
    function detalhe_estoque($id){
        $this->db->where('produto_estoque', $id);
        $this->db->join('nota', 'nota.numero_nota=estoque.nf_estoque');
         $this->db->join('departamentos', 'departamentos.id_departamento=estoque.departamento_estoque');
        $query = $this->db->get('estoque');
        return $query->result();
    }
    
    function detalhe_saida_estoque($id){
        $this->db->where('id_pro_req_est', $id);
        //$this->db->join('nota', 'nota.numero_nota=estoque.nf_estoque');
        $this->db->join('departamentos', 'departamentos.id_departamento=estoque_rq.departamento_rq');
        $query = $this->db->get('estoque_rq');
        return $query->result();
    }
    function detalhe_produto($id){
        $this->db->where('id_produto', $id);
        $query = $this->db->get('produtos');
        return $query->result();
    }
    function detalhe_produto_estoque($id){
        $this->db->where('produto_estoque', $id);
        $this->db->join('produtos', 'estoque.produto_estoque=produtos.id_produto');
        $query = $this->db->get('estoque');
        return $query->result();
    }
    function extrato($id){
        $this->db->where('produto_estoque', $id);
        $this->db->join('produtos', 'estoque.produto_estoque=produtos.id_produto');
        //$this->db->order_by('data_estoque', 'asc');
        $this->db->order_by('id_estoque', 'asc');
        $query = $this->db->get('estoque');
        return $query->result();
    }
    function check_documento($id){
        $this->db->where('id_estoque', $id);
        $query = $this->db->get('estoque');
        $row = $query->row();
        return $row->id_nf_estoque;
    }
    function listDep(){
      $query = $this->db->get('departamentos');
      return $query->result();  
    }
    function detalhe_transf($id){
        $this->db->where('id_visao', $id);
        $query = $this->db->get('visao_estoque');
        return $query->result();
    }
    function detalhe_baixa($id){
        $this->db->where('id_qt', $id);
        $query = $this->db->get('estoque_qt');
        return $query->result();
    }
    public function get_by_id($id)
    {
        $this->db->where('id_produto_qt',$id);
        $query = $this->db->get('estoque_qt');
        return $query->row();
    }
    public function dep_by_id($id){
        $this->db->where('id_departamento',$id);
        $query = $this->db->get('departamentos');
        return $query->row();
    }
    public function relatorio(){
        
        ///$this->db->join('departamentos', 'departamentos.id_departamento=estoque_qt.id_dep_qt');
        $this->db->join('produtos', 'estoque_qt.id_produto_qt=produtos.id_produto');
        $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
        $query = $this->db->get('estoque_qt');
        return $query->result();
    }
    public function entradas($data1, $data2){
       /*$query = $this->db->query("
                SELECT estoque.produto_estoque, estoque.departamento_estoque, estoque.quantidade_estoque, SUM(quantidade_estoque), estoque.preco_estoque, estoque.data_estoque, produtos.nome_produto, produtos.id_produto 
                FROM estoque 
                INNER JOIN produtos ON (estoque.produto_estoque=produtos.id_produto) 
                WHERE (data_estoque BETWEEN '$data1' AND  '$data2')
                GROUP BY estoque.produto_estoque, estoque.departamento_estoque  " );*/
      $this->db->select('*');
      ////$this->db->from('estoque');
      $this->db->group_by('produto_estoque'); 
      $this->db->select_sum('quantidade_estoque');
      $this->db->join('produtos', 'estoque.produto_estoque=produtos.id_produto');
      $this->db->where('data_estoque >=',$data1);  
      $this->db->where('data_estoque <=',$data2);  
      $query = $this->db->get('estoque');
      //return $query->result();
        return $query;
    }
    
    public function estoque_bk($data1, $data2) {
        // $this->db->join('produtos', 'estoque_qt.id_produto_qt=produtos.id_produto');
       // $this->db->group_by('departamento_estoque'); 
        $this->db->group_by('produto_estoque'); 
        $this->db->join('produtos', 'estoque.produto_estoque=produtos.id_produto');
        $this->db->join('departamentos', 'estoque.departamento_estoque=departamentos.id_departamento');
       
         $this->db->join('estoque_qt', 'estoque_qt.id_produto_qt=estoque.id_estoque');
        //$this->db->where('quantidade_qt !=',0);
        $this->db->where('quantidade_qt >',0);
        
       // $this->db->where('data_estoque >=',$data1);  
        //$this->db->where('data_estoque <=',$data2);
        $query = $this->db->get('estoque');
        return $query;
    }
    
    public function estoque($data1, $data2) {
        $this->db->group_by('produto_estoque'); 
        $this->db->join('produtos', 'estoque.produto_estoque=produtos.id_produto');
        $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
        $this->db->where('quantidade_estoque >',0);
        $this->db->order_by('nome_produto', 'asc');
        //$this->db->where('data_estoque >= date("'.$data1.'")');
        //$this->db->where('data_estoque <= date("'.$data2.'")');
        $query = $this->db->get('estoque');
        return $query;
    }
     public function estoque_dep_bk($data1, $data2, $dep) {
       
        $this->db->group_by('produto_estoque'); 
        $this->db->join('produtos', 'estoque.produto_estoque=produtos.id_produto');
       // $this->db->join('departamentos', 'estoque.departamento_estoque=departamentos.id_departamento');
        $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
        //$this->db->join('estoque_qt', 'estoque_qt.id_produto_qt=estoque.id_estoque');
        $this->db->join('estoque_qt', 'estoque_qt.id_produto_qt=estoque.produto_estoque');
       
        $this->db->where('quantidade_qt >',0);
        $this->db->where('departamento_produto',$dep);
        
        $this->db->where('departamento_estoque', $dep);
        $query = $this->db->get('estoque');
        return $query;
    }
    
     public function estoque_dep($data1, $data2, $dep) {
        $this->db->group_by('produto_estoque'); 
        $this->db->join('produtos', 'estoque.produto_estoque=produtos.id_produto');
        $this->db->join('departamentos', 'departamentos.id_departamento=produtos.departamento_produto');
        //$this->db->where('data_estoque >= date("'.$data1.'")');
        //$this->db->where('data_estoque <= date("'.$data2.'")');
        $this->db->order_by('nome_produto', 'asc');
        $this->db->where('quantidade_estoque >',0);
        $this->db->where('departamento_produto', $dep);
        $query = $this->db->get('estoque');
        return $query;
    }
    public function check_estoque($id){
        $this->db->where('produto_estoque',$id);
        $this->db->order_by('id_estoque', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('estoque');
        //return $query;
        $row = $query->row();
        return $row->quantidade_estoque;
    }
    
    public function check_estoque_valor($id){
        $this->db->where('produto_estoque',$id);
        $this->db->where('tipo_movimento',1);
        $this->db->order_by('id_estoque', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('estoque');
        //return $query;
        $row = $query->row();
        return $row->custo_medio;
    }
    
    
    public function estoque_in($data1, $data2) {
        // $this->db->join('produtos', 'estoque_qt.id_produto_qt=produtos.id_produto');
        $this->db->group_by('departamento_estoque'); 
        $this->db->join('produtos', 'estoque.produto_estoque=produtos.id_produto');
        $this->db->join('departamentos', 'estoque.departamento_estoque=departamentos.id_departamento');
        $this->db->where('data_estoque <=',$data1);  
      //  $this->db->where('data_estoque <=',$data2);
        $query = $this->db->get('estoque');
        return $query;
    }
    
    public function est_in($data1, $data2){
    $this->db->select('*');
      ////$this->db->from('estoque');
      $this->db->group_by('produto_estoque'); 
      $this->db->select_sum('quantidade_estoque');
      $this->db->join('produtos', 'estoque.produto_estoque=produtos.id_produto');
      $this->db->where('data_estoque >=',$data1);  
      $this->db->where('data_estoque <=',$data2);  
      $query = $this->db->get('estoque');
      //return $query->result();
        return $query;
    }

    public function get_dep($id){
        $this->db->where('id_departamento',$id);
        $query = $this->db->get('departamentos');
        return $query;
        //return $query->result();
    }
    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
 
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
    
    public function update_pr($where, $data)
    {
        $this->db->update('estoque_qt', $data, $where);
        return $this->db->affected_rows();
    }
     public function update_dep($data,$where)
    {$this->db->where('id_departamento', $where);
    $this->db->update('departamentos', $data);
    return $this->db->affected_rows();
    }
    public function save_dep($data){
        $this->db->insert('departamentos', $data);
        return $this->db->insert_id();
    }
    public function verifica_movimento($id){
       $this->db->where('produto_estoque', $id);
        $query = $this->db->get('estoque');
        return $query->num_rows();
       
    }
 
    public function delete_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }
     public function delete_dep_by_id($id)
    {
        $this->db->where('id_departamento', $id);
        $this->db->delete('departamentos');
    }
 
 
}