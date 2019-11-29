<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->load->database();
?>

<div id="page-wrapper" style="min-height: 529px;">
           
            <!-- /.row -->
            <div class="row ">
                <label>Data Impressão :</label>
               <?php echo date('d-m-Y' ) ; ?> <br>
              
               
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
                                            <th class="sorting table_header" tabindex="0" rowspan="1" colspan="1" style="//width: 10px;">Cód.</th>
                                          
                                            <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"  style="//width: 201px;">Descrição</th>
                                            <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"  style="//width: 201px;">Departamento</th> 
                                    
                                              
                                           
                                              <!--<th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"style="//width: 20px;">Qt. Dev</th>
                                              <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"style="//width: 20px;">Vr. Dev</th>
                                              -->
                                           <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"  style="//width: 201px;">Saldo Atual</th>
                                           <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"  style="//width: 201px;">Custo Unit.</th>
                                           
                                           
                                           <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"  style="//width: 201px;">Valor Atual</th>
                                          
                                      </thead>
                                    <tbody>
                                        <?php
                                         $total = ''; 
                                        foreach ($relatorio->result() as $relatorio):
                                        if($this->M_estoqueqt->check_estoque($relatorio->produto_estoque) >0){
                                         ?>  
                                       
                                    <tr class="gradeA even" role="row">
                                    <td style="text-align: left"><?php echo $relatorio->id_produto; ?></td>       
                                    <td style="text-align: left"><?php echo $relatorio->nome_produto; ?></td>
                                    <td><?php echo $relatorio->nome_departamento?></td>
                                    <td style="text-align: center">
                                          <?php $estoque=  $this->M_estoqueqt->check_estoque($relatorio->produto_estoque); 
                                          echo $estoque;?>
                                    </td>
                                            
                                    <td>
                                       <?php  
                                        $custo_medio = $this->M_estoqueqt->check_estoque_valor($relatorio->produto_estoque);
                                       echo number_format($custo_medio,2,',','.'); ?> 
                                    </td>
                                     <td class="center">
                                         <?php 
                                         
                                         //$custo_medio = $this->M_estoqueqt->check_estoque_valor($relatorio->produto_estoque);
                                         //echo $custo_medio;
                                         $valor_final = $custo_medio*$estoque;
                                       
                                        //echo str_replace(",",".",$custo_medio);
                                          echo number_format($valor_final,2,',','.');
                                          //echo $valor_final;
                                          $total = $total+$valor_final;
                                         // echo ' - '.$total;
                                         ?>
                                        <?php 
                                       // $preco_estoque = str_replace(",",".",$relatorio->preco_estoque);
                                      
                                        //$valor_final = $quant_atual*$preco_atual;
                                     
                                        ?>
                                     </td>
                                              
                                           
                                        </tr>
                                        
                                        <?php
                                       }
                                        //else{
                                            
                                       // }
                                        //$total = $total+$valor_final;
                                        endforeach;?>
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