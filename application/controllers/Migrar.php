<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Migrar extends MY_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_estoqueqt', 'produtos');
        $this->load->model('M_produto', 'cadastro');
        $this->load->library('table');
        $this->load->model('Getuser');
        $this->load->model('Controleacesso');
        $this->load->model('M_nota', '', TRUE);
            $this->load->helper('url');
            
        
    }
    /*
    public function calebe(){
        $db2 = $this->load->database('ativo', TRUE);
         $query4 = $db2->query("SELECT * FROM estoque_rq WHERE id_pro_req_est=490");
         foreach($query4->result() as $item):
             $qt = $item->qt_pro_req_est;
         echo $qt.' =';
         $total = $total+$qt;
         echo $total.'<br>';
         endforeach;
        
        
        
    }
     public function check_last_estoque($id_produto){
        
        $this->db->where('produto_estoque', $id_produto);
        $this->db->order_by('id_estoque', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('estoque');
        $row = $query->row();
        return $row->quantidade_estoque;
    }
    
    //produtos
    public function produtos(){
       $db2 = $this->load->database('ativo', TRUE);
       $query4 = $db2->query("SELECT * FROM produtos  ");
        foreach($query4->result() as $item):
        $this->db->query("INSERT INTO produtos (id_produto, cod_barras, nome_produto,descricao_produto, departamento_produto,imagem_produto ) VALUES ('$item->id_produto', '$item->cod_barras', '$item->nome_produto','$item->descricao_produto', '$item->departamento_produto', '$item->imagem_produto')");
        endforeach;
       echo "ok!"; 
    }
    
    //migrar o custo
   public function migrar_custo(){
       $db2 = $this->load->database('ativo', TRUE);
        $query4 = $db2->query("SELECT * FROM estoque_qt  ");
        foreach($query4->result() as $item):
          // echo  $item->id_produto_qt;
         $this->db->query("UPDATE estoque SET custo_medio=$item->custo_medio WHERE produto_estoque=$item->id_produto_qt");   
        endforeach;
       
   }
    //requisições
    // restaurar a tabela permaneceram iguais
    
    //estoque rq
    //reataurar a tabela permaneceram iguais
    
    //entradas
    public function migrar_entradas(){
        $db2 = $this->load->database('ativo', TRUE);
        
        $query4 = $db2->query("SELECT * FROM estoque INNER JOIN produtos ON produtos.id_produto=estoque.produto_estoque ");
       //$query4 = $this->db->query("SELECT * FROM produtos ");
       
        foreach($query4->result() as $item):
        
        $id1 = $item->produto_estoque;
        $nome1 = $item->nome_produto;  
        $estoque1 = $item->quantidade_estoque;
        $imagem1 = $item->imagem_produto;
        //$preco = $item->preco_estoque;
        $custo_medio = $item->preco_estoque;
        
        $soma = $item->quantidade_estoque + Migrar::check_last_estoque($id1);
        
        $data = date('Y-m-d' , strtotime($item->data_estoque));
       
        $id_nf = $item->id_nf_estoque;
        $nf = $item->nf_estoque;
        
        echo $id1.' - '.$nome1.' - '.$estoque1.'- '.$data.' - '.$soma.'<br>';
        
        $this->db->query("INSERT INTO estoque (produto_estoque, id_nf_estoque, nf_estoque,quantidade_estoque, entrada_estoque, tipo_movimento, custo_entrada, data_estoque) VALUES ($id1, $id_nf, $nf,$soma, $estoque1, 1, '$preco', '$data')");
                
                
        //$this->db->query("UPDATE produtos SET qt_produto=$estoque1 imagem_produto=$imagem1 WHERE id_produto=$id1");
        //$this->db->query("UPDATE estoque SET quantidade_estoque=$estoque1 WHERE produto_estoque=$id1");
       
        endforeach;
     }
     
     
     
      //entradas
    public function migrar_entradas_nf(){
        $db2 = $this->load->database('ativo', TRUE);
        
        $query4 = $db2->query("SELECT * FROM estoque  ");
       //$query4 = $this->db->query("SELECT * FROM produtos ");
       
        foreach($query4->result() as $item):
        
        $id1 = $item->produto_estoque;
        //$nome1 = $item->nome_produto;  
        $estoque1 = $item->quantidade_estoque;
        //$imagem1 = $item->imagem_produto;
        $preco = $item->preco_estoque;
        $dapartamento = $item->departamento_estoque;
        
       // $soma = $item->quantidade_estoque + Migrar::check_last_estoque($id1);
        
        $data = date('Y-m-d' , strtotime($item->data_estoque));
       
        $id_nf = $item->id_nf_estoque;
        $nf = $item->nf_estoque;
        
        echo $id_nf.' -  - '.$estoque1.'- '.$data.' - <br>';
        
        //$this->db->query("INSERT INTO estoque_nf (produto_estoque, id_nf_estoque, nf_estoque,quantidade_estoque, tipo_movimento, preco_estoque, data_estoque) VALUES ($id1, $id_nf, $nf, $estoque1, 1, '$preco', '$data')");
                
                
        $this->db->query("UPDATE produtos SET qt_produto=$estoque1 imagem_produto=$imagem1 WHERE id_produto=$id1");
        //$this->db->query("UPDATE estoque SET quantidade_estoque=$estoque1 WHERE produto_estoque=$id1");
       
        endforeach;
     }
     public function apagar_entrada_repetida(){
         $inicio = 1803;
         while($inicio <= 3342){
             echo $inicio.'<br>';
              $this->db->query("DELETE FROM estoque_nf WHERE id_estoque=$inicio");
             $inicio ++;
         }
         
     }
     
     
    //saidas
    public function migrar_saidas(){
        $db2 = $this->load->database('ativo', TRUE);
        $query4 = $db2->query("SELECT * FROM estoque_rq ");
       //$query4 = $this->db->query("SELECT * FROM produtos ");
       
        foreach($query4->result() as $item):
        
        $id1 = $item->id_pro_req_est;
        $id_rq = $item->id_est_rq;
        $req = $item->id_req_est;  
        $estoque1 = $item->qt_pro_req_est;
        $imagem1 = $item->imagem_produto;
        $preco = $item->valor_rq;
        $soma = Migrar::check_last_estoque($id1) - $item->qt_pro_req_est;
        
        $data = date('Y-m-d' , strtotime($item->data_rq));
       
        echo $id1.' - '.$nome1.' - '.$estoque1.'- '.$data.' <br>';
        
      $this->db->query("INSERT INTO estoque (produto_estoque, id_nf_estoque, nf_estoque,quantidade_estoque, saida_estoque, tipo_movimento,  data_estoque) VALUES ($id1, $id_rq, $req,$soma, $estoque1, 2,  '$data')");
                
                
        //$this->db->query("UPDATE produtos SET saida_estoque=$estoque1 data_estoque='$data' WHERE id_produto=$id1");
        //$this->db->query("UPDATE estoque SET quantidade_estoque=$estoque1 WHERE produto_estoque=$id1");
       
        endforeach;
    }
    
    // preco _venda
    public function preco_venda(){
        $db2 = $this->load->database('ativo', TRUE);
        $query4 = $db2->query("SELECT * FROM produtos INNER JOIN estoque ON estoque.produto_estoque=produtos.id_produto ");
       //$query4 = $this->db->query("SELECT * FROM produtos ");
       
        foreach($query4->result() as $item):
        $id1 = $item->id_produto;
        $nome1 = $item->nome_produto;  
        $estoque1 = $item->quantidade_qt;
        $preco1 = $item->preco_estoque;
        
        echo $id1.' - '.$nome1.' - '.$estoque1.' - '.$preco1.'<br>';
        
        $this->db->query("UPDATE produtos SET preco_venda=$preco1 WHERE id_produto=$id1");
       
       
        endforeach;
    }
    
   //estoque
    public function estoque(){
        //$query4 = $db2->query("SELECT * FROM produtos INNER JOIN estoque ON estoque.produto_estoque=produtos.id_produto ");
        $query4 = $this->db->query("SELECT * FROM estoque ");
       
        foreach($query4->result() as $item):
        $id1 = $item->produto_estoque;
        $nome1 = $item->nome_produto;  
        $estoque1 = $item->quantidade_qt;
        $preco1 = $item->preco_estoque;
        $soma = Migrar::check_last_estoque($id1);
        
        echo $id1.' - '.$nome1.' - '.$estoque1.' - '.$soma.'<br>';
        $this->db->query("UPDATE produtos SET qt_produto=$soma WHERE id_produto=$id1");
       
       
        endforeach;
    }*/
    public function ajuste_estoque(){
      $query4 = $this->db->query("SELECT * FROM estoque WHERE produto_estoque=1039 ORDER BY data_estoque ASC");
      foreach($query4->result() as $item):
          
          echo $item->id_estoque. ' - '.$item->data_estoque. ' ';
          if($item->tipo_movimento == 1){
              echo 'Entrada';
              echo ' = '.$item->entrada_estoque;
              
              $estoque = $estoque+$item->entrada_estoque;
              echo ' Soma = '.$estoque.' + '.$item->entrada_estoque;
              echo ' - <b><span style="color: blue">'. $estoque.'</span></b>';
          }
          
          elseif($item->tipo_movimento == 2){
              echo 'Saida';
              echo ' = '.$item->saida_estoque;
              $estoque = $estoque-$item->saida_estoque;
              echo ' Subtração = '.$estoque .' - '.$item->saida_estoque;
              echo ' - <b><span style="color: red">'. $estoque.'</span></b>';
          }
          
          elseif ($item->tipo_movimento == 3) {
              
                echo 'Devolução';
                echo  ' = '.$item->entrada_estoque;
                $estoque = $estoque-$item->entrada_estoque;
                echo ' - <b>'. $estoque.'</b>';
            }
            //$this->db->query("UPDATE estoque SET quantidade_estoque=$estoque WHERE id_estoque=$item->id_estoque");
           //echo ' - <b>'. $estoque.'</b>';
            echo ' - <b>'. $item->quantidade_estoque.'</b>';
            echo '<br>';
          
      endforeach;
    }
}
