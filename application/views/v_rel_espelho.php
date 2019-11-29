<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->load->database();
$this->load->model('M_requisicao', '', TRUE);
?>

<div id="page-wrapper" style="min-height: 529px;">
            <div class="row">
                
                  <?php       foreach ($nf as $nf):
                    $cod_nota = $nf->cod_nota;
                    $status = $nf->fechado;
                     ?>
               Fornecedor : <b><?php echo $nf->razao_social; ?></b>  - Departamento : <b> <?php echo $nf->nome_departamento; ?> </b>
               <br>Número da Nota : <b><?php echo $nf->cod_nota; ?> - <?php echo $nf->serie_nota; ?></b> -
               Data : <b> <?php echo date('d-m-Y' , strtotime($nf->data_nota)); ?> </b><br>
               
                
          
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row ">
               
             <div class="panel panel-default">
                <!-- Default panel contents -->
                 <div class="panel-heading">
                     <h3 class="panel-title">Itens desta Nota </h3>
                 </div>

                <!-- Table -->
                <table class="table" >
                 <thead> 
                     <tr> 
                         
                         <th>Produto</th> 
                         <th>Quantidade</th> 
                         <th>Departamento</th>
                         <th>Valor Unit.</th>
                         <th>valor Total</th>
                         
                     </tr> 
                 </thead>
                 <tbody> 
                     
                     <?php  $total = ''; 
                     foreach($itens as $itens):
                        
                         ?>
                    
                     <tr>
                        
                         <td><?php echo $itens->nome_produto; ?></td> 
                        <td><?php echo $itens->quantidade_estoque; ?></td>
                         <td><?php echo $itens->nome_departamento; ?></td> 
                        <td><?php echo number_format($itens->preco_estoque,2,',','.'); ?></td> 
                        <td><?php echo number_format($itens->quantidade_estoque*$itens->preco_estoque, 2, ',', '.') ; ?></td> 
                         
                     </tr> 
                     
                     <?php
                     $total = $total+$itens->preco_estoque*$itens->quantidade_estoque;
                     endforeach; ?>
                    
                 </tbody>
                
                  
                </table><br>
                Total da Nota : R$ <?php echo number_format($total, 2, ',', '.') ; ?>
                </div>
            </div> 
                
                <?php endforeach;?>
            
</div><!-- /.modal -->
<footer class="footer" style="font-family: Arial;">
    
  
      <div class="container" style="font-family: Arial;">
        <p class="text-muted" style="font-family: Arial;">Relatório Administrativo - <?php echo title_global; ?> - &copy;Todos os direitos reservados</p>
      </div>
    </footer>