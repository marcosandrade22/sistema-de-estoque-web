<?php 

	class M_estoque extends CI_Model{

		function addEstoque($data)
		{
			$this->db->insert('produtos', $data);
		}

		function listEstoque()
		{
			//$this->db->join('produto', 'estoque.produto = produto.id_produto');
			return $this->db->get('produtos');
		}

		function getEstoque($id)
		{
			return $this->db->get_where('produtos', array('id_produto'=> $id));
		}

		function getEstoqueByProduto($id) {
			return $this->db->get_where('produtos', array('id_produto'=> $id));
		}
		
		function updateEstoque($id, $data)
		{
			$this->db->where('id_produto', $id);
			$this->db->update('produtos', $data); 
		}

		function deleteEstoque($id)
		{
			$this->db->where('id_produto', $id);
			$this->db->delete('produtos'); 
		}

	}

/* End of file mestoque.php */
/* Location: ./system/application/models/mestoque.php */