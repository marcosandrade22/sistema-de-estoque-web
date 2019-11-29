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
               <?php echo date('d-m-Y' , strtotime($data_in)) ; ?> - <?php echo date('d-m-Y' , strtotime($data_fim)); ?> <br>
              
               
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
                                            <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"style="//width: 20px;">Qt. ini</th>
                                              <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"style="//width: 20px;">Vr. ini</th>
                                              
                                              <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"style="//width: 20px;">Qt. Entrada</th>
                                              <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"style="//width: 20px;">Vr. Entrada</th>
                                              
                                              <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"style="//width: 20px;">Qt. saida</th>
                                              <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"style="//width: 20px;">Vr. saida</th>
                                              
                                              <!--<th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"style="//width: 20px;">Qt. Dev</th>
                                              <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"style="//width: 20px;">Vr. Dev</th>
                                              -->
                                           <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"  style="//width: 201px;">Saldo Atual</th>
                                           <th class="sorting table_header" tabindex="0"  rowspan="1" colspan="1"  style="//width: 201px;">Valor Atual</th>
                                          
                                      </thead>
                                    <tbody>
                                        <?php
                                         $total = ''; 
                                        foreach ($relatorio->result() as $relatorio):
                                        ?>  
                                       
                               <tr class="gradeA even" role="row">
                                    <td style="text-align: left"><?php echo $relatorio->id_produto; ?>
                                    </td>       
                                    <td style="text-align: left"><?php echo $relatorio->nome_produto; ?>
                                    </td>
                                    <td><?php echo $relatorio->nome_departamento?></td>
                                    
                                    <td style="text-align: left">
                                       <?php //quantidade inicial
                                       //echo $data_in.'-';
                                       $query5 = $this->db->query("SELECT * FROM estoque WHERE data_estoque < '$data_in' AND produto_estoque=$relatorio->produto_estoque AND departamento_estoque=$relatorio->departamento_estoque ");   
                                      // $query5 = $this->db->query("SELECT SUM(quantidade_estoque) AS quantidade_estoque FROM estoque WHERE data_estoque < '$data_in' AND produto_estoque=$relatorio->produto_estoque AND departamento_estoque=$relatorio->departamento_estoque ");   
                                       
                                       $quant = "0"; 
                                       foreach($query5->result() as $qt):
                                       //$query8 = $this->db->query("SELECT * FROM estoque_rq WHERE data_rq < '$data_in' AND id_pro_req_est=$qt->produto_estoque AND departamento_rq=$qt->departamento_estoque ");   
                                       $query8 = $this->db->query("SELECT SUM(qt_pro_req_est) AS qt_pro_req_est FROM estoque_rq WHERE data_rq < '$data_in' AND id_pro_req_est=$qt->produto_estoque AND departamento_rq=$qt->departamento_estoque ");   
                                       
                                       if ($query8->num_rows() < 1){
                                           $req_periodo = 0;
                                         //  echo '-'.$req_periodo;
                                       }
                                       else{
                                          foreach($query8->result() as $req):
                                        $req_periodo = $req->qt_pro_req_est;
                                          //echo '-'.$req_periodo;
                                        endforeach;
                                       }
                                      // echo $qt->quantidade_estoque.' - '.$req_periodo;
                                       
                                       $quant= $quant+$qt->quantidade_estoque; 
                                       $preco_in = $qt->preco_estoque;
                                       endforeach;
                                       
                                       //$quant= $quant-$qt->quantidade_estoque-$req_periodo; 
                                       $quant= $quant-$req_periodo;
                                        echo $quant;
                                       // echo $req_periodo;
                                       
                                       
                                       ?>
                                   </td>
                                    <td style="text-align: left">
                                       <?php echo number_format($quant*$preco_in,2,',','.'); ?>
                                   </td>
                                   
                                   <td>
                                        <?php // qantidade entrada periodo
                                       $query6 = $this->db->query("SELECT * FROM estoque WHERE data_estoque >= '$data_in' AND data_estoque <= '$data_fim' AND produto_estoque=$relatorio->produto_estoque AND departamento_estoque=$relatorio->departamento_estoque ");   
                                       $quant_ent = "0"; 
                                       foreach($query6->result() as $qt_ent):
                                       $quant_ent= $quant_ent+$qt_ent->quantidade_estoque; 
                                       $preco_ent = $qt_ent->preco_estoque;
                                       endforeach;
                                       echo $quant_ent;
                                       ?>
                                   </td>
                                   <td style="text-align: left">
                                       <?php //echo 
                                       //$preco_ent*;
                                       $valor = str_replace(",",".",$preco_ent);//echo $valor;
                                      echo  number_format($quant_ent*$valor,2,',','.'); ?>
                                   </td>
                                   
                                   
                                    <td>
                                        <?php 
                                        // qantidade saida periodo
                                        
                                       $query7 = $this->db->query("SELECT * FROM estoque_rq WHERE data_rq >= '$data_in' AND data_rq <= '$data_fim' AND id_pro_req_est=$relatorio->produto_estoque AND departamento_rq=$relatorio->departamento_estoque ");   
                                       $quant_sai = "0"; 
                                       foreach($query7->result() as $qt_sai):
                                           $query1 = $this->db->query("SELECT * FROM requisicao WHERE id_requisicao=$qt_sai->id_req_est");
                                           foreach($query1->result() as $status):
                                               $status_rq = $status->fechado;
                                           endforeach;
                                           if($status_rq == 1){
                                       $quant_sai= $quant_sai+$qt_sai->qt_pro_req_est; 
                                       $preco_sai = $qt_sai->valor_rq;
                                           }
                                           else{
                                               
                                           }
                                       endforeach;
                                       echo $quant_sai;
                                       ?>
                                   </td>
                                   <td style="text-align: left">
                                       <?php 
                                       $preco_sai = str_replace(",",".",$preco_sai);
                                       echo number_format($quant_sai*$preco_sai,2,',','.'); ?>
                                   </td>
                                   
                                   
                                   <!-- devolução -->
                                  <!-- <td>
                                       <?php // qantidade saida periodo
                                       $query8 = $this->db->query("SELECT * FROM estoque_rq_dev WHERE data_rq >= '$data_in' AND data_rq <= '$data_fim' AND id_pro_req_est=$relatorio->produto_estoque AND departamento_rq=$relatorio->departamento_estoque ");   
                                       $quant_dev = "0"; 
                                       foreach($query8->result() as $qt_dev):
                                       $quant_dev= $quant_dev+$qt_dev->qt_pro_req_est; 
                                       $preco_dev = $qt_dev->valor_rq;
                                       endforeach;
                                       echo $quant_dev;
                                       ?>
                                   </td>
                                   <td>
                                       <?php 
                                      // $preco_dev = str_replace(",",".",$preco_dev);
                                       echo number_format($quant_dev*$preco_dev,2,',','.'); ?>
                                   </td>-->
                                   
                                            
                                    <td style="text-align: center">
                                          <?php 
                                    // qantidade atual periodo
                                     $query9 = $this->db->query("SELECT * FROM estoque_qt WHERE id_produto_qt=$relatorio->produto_estoque ");   
                                      $quant_atual = "0"; 
                                     foreach($query9->result() as $qt_atual):
                                      $quant_atual= $quant_atual+$qt_atual->quantidade_qt; 
                                      $preco_atual = $qt_atual->custo_medio;
                                       endforeach;
                                         
                                      ///////// $quant_atual = ($quant+$quant_ent)-$quant_sai;
                                     //  echo $quant_atual;
                                      // echo '-'.$relatorio->quantidade_qt;
                                       echo $this->M_estoqueqt->check_estoque($relatorio->produto_estoque);
                                       ?>
                                    </td>
                                              
                                     <td class="center">
                                        <?php 
                                        $preco_estoque = str_replace(",",".",$relatorio->preco_estoque);
                                      //  $valor_final = $quant_atual*$preco_estoque;
                                        $valor_final = $quant_atual*$preco_atual;
                                        echo number_format($valor_final,2,',','.');
                                        ?>
                                     </td>
                                              
                                           
                                        </tr>
                                        
                                        <?php
                                       // }
                                        //else{
                                            
                                       // }
                                        $total = $total+$valor_final;
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