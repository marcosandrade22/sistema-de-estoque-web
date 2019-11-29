<?php 

	class M_configuracoes extends CI_Model{
            
             public function __construct()
	{
                // Call the CI_Model constructor
                parent::__construct();
                
        }
        

		public function addMenu($data)
		{
			$this->db->insert('produtos', $data);
		}

		public function listMenu()
		{
			//$this->db->join('apresentacao', 'apresentacao.id_apresentacao = produto.unidade');
			//$this->db->join('categoria', 'categoria.id_categoria = produto.categoria');
			//$this->db->order_by('nome_produto', 'asc');
			return $this->db->get('menu');
		}

		function getMenu($id)
		{
			return $this->db->get_where('produtos', array('id_produto'=> $id));
		}

		function updateMenu($id, $data)
		{
			$this->db->where('id_produto', $id);
			$this->db->update('produtos', $data); 
		}

		function deleteMenu($id)
		{
			$this->db->where('id_produto', $id);
			$this->db->delete('produtos'); 
		}
                
                
                public function delete($id = null, $senha){
		if ($id) {
                  
                    $this->db->where('senha_deletar', $senha);
                    $this->db->where('id_artigo', $id);
                    return $this->db->delete('artigos');
			//return $this->db->where('id_artigo', $id)->delete('artigos');
		}
	}
        
         public function menus($limite, $offset){
            $this->db->limit($limite, $offset);
            //$this->db->order_by("data_criacao", "desc");
            $this->db->join('acesso_menu', 'acesso_menu.menu_id = menu.id_menu');
          //$this->db->join('funcoes', 'funcoes.id_funcao = acesso_menu.funcao_id');
            $query = $this->db->get('menu');
            return $query->result();
            }
    
        
        
         public function store($dados = null, $id = null) {
		
		if ($dados) {
			if ($id) {
				$this->db->where('id_artigo', $id);
				if ($this->db->update("artigos", $dados)) {
					return true;
				} else {
					return false;
				}
			} else {
				if ($this->db->insert("artigos", $dados)) {
					return true;
				} else {
					return false;
				}
			}
		}
		
	}

	}

/* End of file mproduto.php */
/* Location: ./system/application/models/mproduto.php */