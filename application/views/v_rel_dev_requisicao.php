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
                
                 <?php foreach ($nf as $nf):?>  
               Número da Requisição : <b><?php echo $nf->id_requisicao; ?> </b><br>
               Data : <b> <?php echo date('d-m-Y' , strtotime($nf->data_requisicao)); ?> </b><br>
               Solicitante : <b> <?php echo $nf->nome_requisicao; ?> </b><br>
               Dep. Solicitante : <b> <?php echo $this->M_requisicao->get_dep($nf->dep_requisicao); ?> </b> &nbsp; Dep. Cedente : <b> <?php echo $this->M_requisicao->get_dep($nf->dep_cedente); ?> </b>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row ">
               
             <div class="panel panel-default">
                <!-- Default panel contents -->
                 <div class="panel-heading">
                     <h3 class="panel-title">Itens devolvidos </h3>
                 </div>

                <!-- Table -->
                <table class="table" >
                 <thead> 
                     <tr> 
                         
                         <th>Produto</th> 
                         <th>Dep.</th>
                         <th>Quantidade</th> 
                         
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
                          <td><?php echo $itens->nome_departamento; ?></td> 
                         <td><?php echo $itens->qt_pro_req_est; ?></td>
                       
                         <td><?php echo number_format($itens->valor_rq,2,',','.'); ?></td> 
                         <td>R$ <?php echo number_format($itens->valor_rq*$itens->qt_pro_req_est, 2, ',', '.') ; ?></td> 
                         
                     </tr> 
                     
                     <?php
                     $total = $total+$itens->valor_rq*$itens->qt_pro_req_est;
                     endforeach; ?>
                    
                 </tbody>
                
                  
                </table><br>
                <div class="valor-total">
                Total da devolução : R$ <?php echo number_format($total, 2, ',', '.') ; ?>
                </div>
                </div>
            </div> 
            
            <div class="assinatura">
                 __________________________________________<br>
                Assinatura Requisitante
            </div>
                
                <?php endforeach;?>
            
</div><!-- /.modal -->
<footer class="footer" style="font-family: Arial;">
    
    __________________________________________<br>
    Asinatura Requisitante
    <br><br>
      <div class="container" style="font-family: Arial;">
        <p class="text-muted" style="font-family: Arial;">Relatório Administrativo - <?php echo title_global; ?> - &copy;Todos os direitos reservados</p>
      </div>
    </footer>