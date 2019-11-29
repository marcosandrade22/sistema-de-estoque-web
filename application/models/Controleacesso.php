<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Controleacesso extends CI_Model{
     public function get_user($tabela,$email) {
   
      $query = $this->db->get_where($tabela, array('email_usuario' => $email));
      return $query->row_array();
       
     }
     
     public function get_menu($tabela) {
    if($title != FALSE) {
      $query = $this->db->get_where($tabela);
      return $query->row_array();
        }
        else {
             return FALSE;
            }
        }
        function unidade_acesso(){
            if ($this->session->userdata("Funcao") == 1){
                return true;
            }
            elseif($this->session->userdata("Funcao") != 1){
               return false;
            }
        }
        
        
        function acesso($controller){
            
            $usuario = $this->session->userdata("Funcao");
         
         $query = $this->db->query("SELECT * FROM menu INNER JOIN acesso_menu ON menu.id_menu=acesso_menu.menu_id AND link_menu='$controller' and funcao_id='$usuario'");
         foreach ($query->result() as $row){ 
              if( $row->funcao_id == $this->session->userdata("Funcao")){
               return true;
              
              }
              else{
                  return FALSE;
               
              }
           
         }
        }
        
        function acesso_dep(){
            if( $this->session->userdata('Funcao') == 1 OR $this->session->userdata('Funcao') == 2 OR $this->session->userdata('Funcao') == 3 OR $this->session->userdata('Funcao') == 5){
                return true;
            }
            else{
                return false;
            }
        }
        
        function acesso_funcao($id){
         $usuario = $this->session->userdata("Funcao");
         $query = $this->db->query("SELECT * FROM funcao_programa INNER JOIN acesso_funcao ON funcao_programa.id_funcao=acesso_funcao.id_funcao_acesso WHERE id_funcao_acesso='$usuario' AND id_acesso_funcao='$id' ");
         foreach ($query->result() as $row){ 
              if( $row->id_funcao_acesso == $this->session->userdata("Funcao")){
               return true;
              
              }
              else{
                  return FALSE;
               
              }
           }
        }
        
        function series($unidade){
            $query = $this->db->query("SELECT * FROM series WHERE unidade_serie='$unidade'"); 
             foreach ($query->result() as $row){ 
             
              
              }
        }
       
        function menus(){
        $query = $this->db->query("SELECT * FROM menu INNER JOIN acesso_menu ON menu.id_menu=acesso_menu.menu_id ORDER BY ordem_menu");
              foreach ($query->result() as $row){ 
                    if($row->pai_menu == 0 AND $row->funcao_id == $this->session->userdata("Funcao")){  
               ?>

<li> <a data-toggle="dropdown" data-target="#<?php //echo $row->apelido;?>" href="#<?php //echo $row->link_menu;?>"><?php echo $row->nome_menu;?>   <span class="caret"></span></a>
                  <?php 
                  echo '<ul id="'.$row->apelido.'" class="dropdown-menu">';
                  
                  if($row->pai_menu == $row->pai_menu AND $row->funcao_id == $this->session->userdata("Funcao") ){
                     $querysub = $this->db->query("SELECT * FROM menu INNER JOIN acesso_menu ON menu.id_menu=acesso_menu.menu_id WHERE pai_menu=$row->id_menu ");
                  foreach ($querysub->result() as $rowsub){  
                       if($rowsub->pai_menu != 0 AND $rowsub->funcao_id == $this->session->userdata("Funcao")){  
                      ?>
                      
<li class='has-sub'> <a href="<?php echo base_url() ?><?php echo $rowsub->link_menu;?>"><?php echo $rowsub->nome_menu;?> </a></li>
                         
                         <?php
                       }
                        }
                  
                      }
                     echo '</ul>';
                  
                  
                   }
                   
                   
                echo '</li>';  
                  }
              
              
                 
        }
        
         function Unidades(){
        $query = $this->db->query("SELECT * FROM unidades_educacionais");
        echo '<select name="unidade" class="form-control">';
              foreach ($query->result() as $row){     
               ?>
<option class='has-sub' value="<?php echo $row->cod_unidade;?>"><?php echo $row->nome_unidade;?> </option>
                         
                         <?php
                       }
                        
                     echo '</select>';
                    
        }
    
}
?>