<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->load->model('M_requisicao', '', TRUE);
?>
<link href="<?php echo base_url(); ?>assets/css/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-ui.js' ?>"></script>
    <script>
$(function(){
 $('.moeda').bind('keypress',mask.money)
});

$(function(){
  $("#produto").autocomplete({
    source: "requisicoes/get_itens" // path to the get_birds method
  });
});

</script>




<body>
 
    <div class="container margin-top" >
        
       <h3><?php echo $pagina ?></h3>
       
       <?php  
            //echo form_input('nome_produto','','id="id"', 'value="id_produto"');  
        ?>  
        
       <!--<input type="text" id="id" />
        <ul>  
            <div class="well" id="result"></div>  
        </ul>  -->
       
            <?php 
            //echo $this->M_requisicao->check_requisicao_fechada($id).'-';
            foreach ($nf as $nf):
            $cod_nota = $nf->id_requisicao;
            $status = $nf->fechado;
            $data_requisicao = date("Y-m-d", strtotime($nf->data_requisicao));
            ?>
       
       
       <div class="col-xs-12">
           <div class="row">
           <?php
      
       if($status == 0){
            echo anchor('requisicoes/fechar/'.$cod_nota, form_button('finalizar', 'Fechar Requisicao', 'class="btn btn-primary"'));
            echo ' <p>Atenção, ao clicar em fechar requisição não serão possíveis alterações na mesma e os produtos serão subtraidos do estoque.</p>';
            }
        else{
          
          echo '<div class="alert alert-danger" role="alert">
                <i class="fa fa-exclamation" aria-hidden="true"></i>
                Requisição Fechada.
              </div>
              ';
          $data_atual = date('Y-m-d');
          
          if($data_requisicao == $data_atual){
         //     echo 'hoje';
          }
           $CI =& get_instance(); if($CI->Controleacesso->acesso_funcao(22) == true && $data_requisicao == $data_atual){
            echo anchor('requisicoes/abrir/'.$cod_nota, form_button('finalizar', 'Abrir Requisicao', 'class="btn btn-primary"'));
            }
            elseif(1 == 1){
              
           echo  '<button name="finalizar" type="button" class="btn btn-primary disabled">Abrir Requisicao</button> ';
            }
           else{
            echo  '<button name="finalizar" type="button" class="btn btn-primary disabled">Abrir Requisicao</button> ';
            }
          echo '<a href="'.base_url().'requisicoes/gera_pdf/'.$cod_nota.'" class="btn btn-success" target="_blank" ><i class="fa fa-print" aria-hidden="true"></i> Imprimir</a>';
      }
        ?>
                     </div><hr>
           </div>
       
       <form action="<?php echo base_url()?>requisicoes/cadastra_item" method="post">
           <input type="hidden" value="<?php echo $nf->id_requisicao; ?>" name="id_req_est" />
           <!--<input type="hidden" value="<?php echo $nf->dep_cedente; ?>" name="id_ced_est" />-->
           <input type="hidden" value="<?php echo $nf->dep_requisicao; ?>" name="departamento_rq" />
           <input type="hidden" value="<?php echo $nf->data_requisicao; ?>" name="data_rq" />
            <input type="hidden" value="<?php echo $nf->tipo_requisicao; ?>" name="tipo_requisicao" />
           
            <div class="col-xs-3">  
                
                <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Cabeçalho da Requisicao</h3>
                </div>
                <div class="panel-body">
                        <div class="form-group">
                   <div class="col-xs-12">
                       <?php $dep_cedente = $nf->dep_cedente; ?>
                       Número da Requisição : <b><?php echo $nf->id_requisicao; ?> </b><br>
                       Data : <b> <?php echo $nf->data_requisicao; ?> </b><br>
                       Solicitante : <b> <?php echo $nf->nome_requisicao; ?> </b> -  <?php echo $this->M_requisicao->get_dep($nf->dep_requisicao);  ?> <br>
                   Tipo : <?php
                   if ($nf->tipo_requisicao == 1){
                       echo '<b>Doação</b>';
                   }
                   elseif($nf->tipo_requisicao == 2){
                       echo '<b>Repasse</b>';
                   }
                   ?>
                   </div>
                            
                            
               
                  
               
               
               </div>
                </div>
                </div>
               <?php if($status == 1){
                   
               }
                else{
                    ?>
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title">Item da Requisicao</h3>
                    </div>
                <div class="panel-body">
                 <div class="row">
                     <div class="col-xs-12">
                         <script type="text/javascript">

                         $(document).ready(function() {
                         $('select[name="id_pro_req_est"]').on('change', function() {
                        var stateID = $(this).val();
                         if(stateID) {
                        $.ajax({
                        url: '/estoque/requisicoes/myformAjax/'+stateID,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            console.log('ok');
                            console.log(data);
                             $( ".estoque" ).html( "<b>Disponível </b>"+data.qt_produto );
                             //$('[name="qt_pro_req_est"]').val(data.quantidade_qt);
                             $(".qt_pro_req_est").attr({
                                "max" : data.qt_produto,       // substitute your own
                                "min" : 1          // values (or variables) here
                                });
    
                        }
                        });
                        }else{
                            console.log('erro');
                       // $('select[name="city"]').empty();
                        }
                        });
                        });
                        </script>
                       
                     <label>Produto</label>
                     
                     <select class="form-control js-example-basic-single" name="id_pro_req_est" required>
                         <option selected></option>
                     <?php
                     $produtos = $this->M_requisicao->listProduto_semzero();
                     foreach($produtos->result() as $produto):
                        // echo ('<option value="'.$produto->id_produto.'">'.$produto->nome_produto.' - (Disp. '.$produto->quantidade_qt.' )</option>');
                        echo ('<option value="'.$produto->id_produto.'">'.$produto->nome_produto.' - '.$produto->qt_produto.' Un. disp ('.$produto->nome_departamento.')</option>');
                     endforeach;
                     ?>  
                    </select>
                     <?php //echo $produto->custo_medio ?>
                     <!--<input type="hidden" value="<?php echo $produto->custo_medio ?>" name="valor_rq" />-->
                     </div>
                 </div>
                    <br>
                <div class="row">
                    <div class="col-xs-6">
                       <label>Qtd.</label>
                       <input type="number" name="qt_pro_req_est"  class="form-control qt_pro_req_est" required/>
                    </div>
               <div class="estoque"></div>
                   <!-- <div class="col-xs-6">
                    <label>Custo R$</label>
                    <input type="text"  name="preco"  class="form-control moeda" required/>
                    </div>-->
                </div>
                <br>
               
                
                <div class="row">
                        <div class="col-xs-6">
                          <br>
                          <?php if($status == 1)
                              {
                              echo '<input disabled class="btn btn-primary" type="submit" value="Requisicção" />';
                          }
                          else{
                              echo '<input class="btn btn-primary" type="submit" value="Cadastrar item na Requisição" />';
                          }
                           ?>
                        </div>
                </div> 
                </div><!-- end panel body -->
                </div><!-- end panel -->
             <?php 
                }
                ?>
              
           
               
            </div>
           <div class="col-xs-9">
               <div class="panel panel-default">
                <!-- Default panel contents -->
                 <div class="panel-heading">
                     <h3 class="panel-title">Itens desta requisicao </h3>
                 </div>

                <!-- Table -->
                <table class="table" >
                 <thead> 
                     <tr> 
                         <th>#</th> 
                         <th>Produto</th> 
                         <th>Dep.</th>
                         <th>Quantidade</th> 
                         
                         <th>Valor Unit.</th>
                         <th>valor Total</th>
                        
                        
                     </tr> 
                 
                 </thead>
                 <tbody> 
                     
                     <?php  foreach($itens as $itens): ?>
                     <tr>
                         <th scope="row">
                            <?php if($status == 1){ ?>
                           
                        <?php }
                        else{?>
                              <a href="#" class="confirma_exclusao" data-nota="<?php echo $cod_nota; ?>"  data-id="<?= $itens->id_est_rq ?>" data-nome="<?= $itens->nome_produto ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        <?php }
                            ?>
                        
                                     </th> 
                         <td><?php echo $itens->nome_produto; ?></td> 
                         <td><?php echo $itens->nome_departamento; ?></td> 
                         <td><?php echo $itens->qt_pro_req_est; ?></td>
                         
                         <td><?php echo number_format($itens->valor_rq,2,',','.'); ?></td> 
                          <td><?php echo number_format($itens->valor_rq*$itens->qt_pro_req_est, 2, ',', '.') ; ?></td> 
                          
                           <?php
                          $CI =& get_instance(); if($CI->Controleacesso->acesso_funcao(33) == true){
                              if($status == 1){ ?>
                         <td>
                            <?php }
                            else{?>
                            <?php }
                           }
                            ?>
                           
                         
                     </tr> 
                     <?php endforeach; ?>
                    
                 </tbody>
                </table>
                </div>
               
               
               
               <div class="panel panel-default">
                
                 <div class="panel-heading">
                     <h3 class="panel-title">Itens Devolvidos</h3> 
                 </div>

               
                <table class="table" >
                 <thead> 
                     <tr> 
                         <th>#</th> 
                         <th>Produto</th> 
                         <th>Dep.</th>
                         <th>Quantidade</th> 
                         <th>Data Dev.</th>
                        
                          <?php if($status == 1){ ?>
                         <!--<th>Cancelar Devolução</th>-->
                        <?php }
                        else{?>
                                <?php }
                            ?>
                         
                     </tr>
                 
                    </thead>
                 <tbody> 
                     
                     <?php  foreach($dev as $dev): ?>
                     <tr>
                         <th scope="row">
                           </th> 
                         <td><?php echo $dev->nome_produto; ?></td> 
                         <td><?php echo $dev->nome_departamento; ?></td> 
                         <td><?php echo $dev->entrada_estoque; ?></td>
                         <td><?php echo $dev->data_estoque; ?></td>
                        <!-- <td><?php echo number_format($dev->valor_rq,2,',','.'); ?></td> 
                          <td><?php echo number_format($dev->valor_rq*$dev->qt_pro_req_est, 2, ',', '.') ; ?></td> -->
                          
                          <!--    <?php if($status == 1){ ?>
                         <td><a href="#" class="cancela_dev btn btn-primary" data-nota="<?php echo $cod_nota; ?>"  data-id="<?= $dev->id_est_rq ?>" data-produto="<?php echo $dev->id_produto; ?>" data-valor="<?php echo $dev->valor_rq; ?>" data-nome="<?= $dev->nome_produto ?>" data-departamento="<?= $dev->departamento_rq ?>"><i class="fa fa-level-up" aria-hidden="true"></i> Canc. Devolução</a></td></td>
                            <?php }
                            else{?>
                            <?php }
                            ?>-->
                         
                         
                     </tr> 
                     <?php endforeach; ?>
                    
                 </tbody>
                </table>
                
                </div>
               <?php if($dev != null) {?>
               <a href="<?php echo base_url()?>requisicoes/gera_pdf_dev/<?php echo $cod_nota; ?>" class="btn btn-success" target="_blank" ><i class="fa fa-print" aria-hidden="true"></i> Imprimir Devolução</a>
               <?php 
               }
               else{
               }?>
             
           </div>
           
         
          
           
       </form>
       
      
      
       
       <?php endforeach; ?>
       
    </div>
</body>

 <div class="modal fade" id="modal_confirmation">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Confirmação de Exclusão</h4>
      </div>
      <div class="modal-body" >
        <p>Deseja realmente excluir o registro <strong><span id="nome_exclusao"></span></strong> da nota fiscal <strong><span id="nota_exclusao"></span></strong>?</p>
      </div>
        <form method="post" action="<?php echo base_url()?>requisicoes/delete">
            <div id="id_exclusao"></div>
            <div id="id_nota"></div>
               
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Agora não</button>
        <!--<button type="button" class="btn btn-danger" id="btn_excluir">Sim. Excluir</button>-->
        <input type="submit" class="btn btn-danger" id="btn_excluir" value="Sim. Excluir">
      </div> 
        </form>
        
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


 <div class="modal fade" id="modal_dev">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Confirmação de devolução</h4>
      </div>
      <div class="modal-body" >
        
       
      </div>
        <form method="post" action="<?php echo base_url()?>requisicoes/dev_item">
            <div class="padded" style="padding: 10px">
                 Produto a ser devolvido :  
                 <b><div id="nome_dev"></div></b>
            <hr>
            <div id="qt_dev"></div>
            <div id="id_dev"></div>
            <div id="id_nota_dev"></div>
            <div id="id_produto"></div>
            <div id="departamento"></div>
             <div id="valor"></div>
            </div>  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Agora não</button>
        <!--<button type="button" class="btn btn-danger" id="btn_excluir">Sim. Excluir</button>-->
        <input type="submit" class="btn btn-danger" id="btn_excluir" value="Sim. Devolver">
      </div> 
        </form>
        
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="cancela_dev">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cancelamento de devolução</h4>
      </div>
      <div class="modal-body" >
        
       
      </div>
        <form method="post" action="<?php echo base_url()?>requisicoes/canc_dev">
            <div class="padded" style="padding: 10px">
                Produto a voltar para a requisição : 
                <b> <div id="nome_canc"></div></b>
            <hr>
            <div id="qt_canc"></div>
            <div id="id_canc"></div>
            <div id="id_nota_canc"></div>
            <div id="id_produto_canc"></div>
            <div id="departamento_canc"></div>
             <div id="valor_canc"></div>
            </div>  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Agora não</button>
        <!--<button type="button" class="btn btn-danger" id="btn_excluir">Sim. Excluir</button>-->
        <input type="submit" class="btn btn-danger" id="btn_excluir" value="Sim. Voltar a requisição">
      </div> 
        </form>
        
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
	
		var base_url = "<?php base_url(); ?>";
	
		$(function(){
			$('.confirma_exclusao').on('click', function(e) {
			    e.preventDefault();
			    
			    var nome = $(this).data('nome');
			    var id = $(this).data('id');
                            var nota = $(this).data('nota');
			    
			    $('#modal_confirmation').data('nome', nome);
			    $('#modal_confirmation').data('id', id);
                            $('#modal_confirmation').data('nota', nota);
			    $('#modal_confirmation').modal('show');
			});
                        
                        $('.confirma_dev').on('click', function(e) {
			    e.preventDefault();
			    
			    var nome = $(this).data('nome');
			    var id = $(this).data('id');
                            var nota = $(this).data('nota');
                            var produto = $(this).data('produto');
                            var departamento = $(this).data('departamento');
                            var valor = $(this).data('valor');
			    
			    $('#modal_dev').data('nome', nome);
			    $('#modal_dev').data('id', id);
                            $('#modal_dev').data('nota', nota);
                            $('#modal_dev').data('produto', produto);
                            $('#modal_dev').data('departamento', departamento);
                            $('#modal_dev').data('valor', valor);
			    $('#modal_dev').modal('show');
			});
                        
                         $('.cancela_dev').on('click', function(e) {
			    e.preventDefault();
			    
			    var nome = $(this).data('nome');
			    var id = $(this).data('id');
                            var nota = $(this).data('nota');
                            var produto = $(this).data('produto');
                            var departamento = $(this).data('departamento');
                            var valor = $(this).data('valor');
			    
			    $('#cancela_dev').data('nome', nome);
			    $('#cancela_dev').data('id', id);
                            $('#cancela_dev').data('nota', nota);
                            $('#cancela_dev').data('produto', produto);
                            $('#cancela_dev').data('departamento', departamento);
                            $('#cancela_dev').data('valor', valor);
			    $('#cancela_dev').modal('show');
			});
			
			$('#modal_confirmation').on('show.bs.modal', function () {
			  var nome = $(this).data('nome');
                          var id = $(this).data('id');
                          var nota = $(this).data('nota');
			  $('#nome_exclusao').text(nome);
                          $('#nota_exclusao').text(nota);
                          $('#id_exclusao').html('<input type="hidden" name="id" id="id_exclusao" value="'+id+'"/>');
                          $('#id_nota').html('<input type="hidden" name="nota" id="id_nota" value="'+nota+'"/>');
			});
                        
                        $('#modal_dev').on('show.bs.modal', function () {
			  var nome = $(this).data('nome');
                          var id = $(this).data('id');
                          var nota = $(this).data('nota');
                          var produto = $(this).data('produto');
                          var departamento = $(this).data('departamento');
                          var valor = $(this).data('valor');
			  $('#nome_dev').text(nome);
                          $('#nota_dev').text(nota);
                          $('#qt_dev').html('<input type="number" name="qt_dev" id="qt_dev" class="form-control" placeholder="Quantidade"/>');
                          $('#id_dev').html('<input type="hidden" name="id_dev" id="id_dev" value="'+id+'"/>');
                          $('#id_nota_dev').html('<input type="hidden" name="id_rq" id="id_rq" value="'+nota+'"/>');
                          $('#id_produto').html('<input type="hidden" name="id_produto" id="id_produto" value="'+produto+'"/>');
                          $('#valor').html('<input type="hidden" name="valor" id="valor" value="'+valor+'"/>');
                          $('#departamento').html('<input type="hidden" name="departamento" id="departamento" value="'+departamento+'"/>');
			});
                        
                        
                         $('#cancela_dev').on('show.bs.modal', function () {
			  var nome = $(this).data('nome');
                          var id = $(this).data('id');
                          var nota = $(this).data('nota');
                          var produto = $(this).data('produto');
                          var departamento = $(this).data('departamento');
                          var valor = $(this).data('valor');
			  $('#nome_canc').text(nome);
                          $('#nota_canc').text(nota);
                          $('#qt_canc').html('<input type="number" name="qt_dev" id="qt_dev" class="form-control" placeholder="Quantidade"/>');
                          $('#id_canc').html('<input type="hidden" name="id_dev" id="id_dev" value="'+id+'"/>');
                          $('#id_nota_canc').html('<input type="hidden" name="id_rq" id="id_rq" value="'+nota+'"/>');
                          $('#id_produto_canc').html('<input type="hidden" name="id_produto" id="id_produto" value="'+produto+'"/>');
                          $('#valor_canc').html('<input type="hidden" name="valor" id="valor" value="'+valor+'"/>');
                          $('#departamento_canc').html('<input type="hidden" name="departamento" id="departamento" value="'+departamento+'"/>');
			});
			
			$('#btn_excluir').click(function(){
				var id = $('#modal_confirmation').data('id');
				document.location.href = base_url + "requisicoes/delete/"+id;
			});					
		});
                
                jQuery(function($){
   $("#date").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
   $("#moeda").mask("999.999,99");
   $("#tin").mask("99-9999999");
   $("#ssn").mask("999-99-9999");
});
	</script>
        
 