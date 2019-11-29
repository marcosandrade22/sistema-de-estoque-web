<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->load->database();
?>

<div id="page-wrapper" style="min-height: 529px;">
            <div class="row">
                <div class="col-lg-12">
                 
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row ">
                <label>Período :</label>
               <?php echo date('d-m-Y' , strtotime($data_in)) ; ?> - <?php echo date('d-m-Y' , strtotime($data_fim)); ?> <?php echo $departamento; ?> <br>
              
               
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          
                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="dataTables_length" id="dataTables-example_length">
                                                
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                          
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-responsive table-striped table-bordered table-hover dataTable no-footer table_header" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting table_header" tabindex="0" rowspan="1" colspan="1" style="//width: 10px;">Núm.</th>
                                          
                                            <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"  style="//width: 201px;">Solicitante</th>
                                            <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"  style="//width: 201px;">Departamento</th> 
                                            <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"style="//width: 20px;">Data</th>
                                              <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"style="//width: 20px;">Tipo</th>
                                              
                                            
                                              
                                              <!--<th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"style="//width: 20px;">Qt. Dev</th>
                                              <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"style="//width: 20px;">Vr. Dev</th>
                                              -->
                                           <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"  style="//width: 201px;">Valor</th>
                                          
                                      </thead>
                                    <tbody>
                                        
                                        <?php
                                         $total = ''; 
                                        foreach ($relatorio->result() as $relatorio):
                                      //  if(M_relatorio::soma_boletos_qt($relatorio->data_baixa, $relatorio->id_usuario) == M_relatorio::total_boletos_qt($relatorio->data_baixa, $relatorio->id_usuario)){
                                            
                                        
                                            ?>  
                                       
                               <tr class="gradeA even" role="row">
                                     <td style="text-align: left">
                                         <?php echo $relatorio->id_requisicao; ?>
                                   </td>       
                                   <td style="text-align: left">
                                       <?php echo $relatorio->nome_requisicao; ?>
                                   </td>
                                     <td style="text-align: left">
                                     <?php echo $relatorio->nome_departamento; ?>
                                   </td>
                                   
                                   <td>
                                      <?php echo date('d-m-Y' , strtotime($relatorio->data_requisicao)); ?>
                                   </td>
                                   <td style="text-align: left">
                                     <?php if($relatorio->tipo_requisicao == 1){
                                         echo 'Doação';
                                     }
                                     else{
                                         echo 'Venda';
                                     }
                                     ?>
                                   </td>
                                  
                                   
                                              
                                     <td class="center">
                                      <?php //quantidade inicial
                                       $query5 = $this->db->query("SELECT * FROM estoque_rq WHERE id_req_est=$relatorio->id_requisicao");   
                                       $valor_rq = '';
                                       foreach($query5->result() as $qt):
                                       $quant_rq= $qt->qt_pro_req_est; 
                                       $preco_rq = $qt->valor_rq;
                                       $valor_un = $quant_rq*$preco_rq;
                                       $valor_rq = $valor_rq+$valor_un;
                                       endforeach;
                                       echo number_format($valor_rq, 2, ',', '.') ;
                                       $total = $total+$valor_rq;
                                       ?>
                                     </td>
                                              
                                           
                                        </tr>
                                        
                                        <?php  endforeach;?>
                                    </tbody>
                                </table><br>
                                <div class="valor-total">
                            Valor total : R$ <?php echo number_format($total, 2, ',', '.') ; ?>
                                </div>
                                        </div>
                                    </div>
                                    <div class="row"><div class="col-sm-6">
                                                
                                        </div>
                                        <div class="col-sm-6"><div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
                                                   </div>
                            <!-- /.table-responsive -->
                           
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
        
        </div>

</div>
                    
                </div>
            </div>
</div><!-- /.modal -->
<footer class="footer" style="font-family: Arial;">
      <div class="container" style="font-family: Arial;">
        <p class="text-muted" style="font-family: Arial;">Relatório Administrativo - <?php echo title_global; ?> - &copy;Todos os direitos reservados</p>
      </div>
    </footer>