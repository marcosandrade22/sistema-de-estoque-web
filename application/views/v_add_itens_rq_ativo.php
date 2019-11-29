<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->load->model('M_ativos', '', TRUE);
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

<script type="text/javascript">
$(document).ready(function() {
  $(".js-example-basic-single").select2();
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
       
        <?php       foreach ($nf as $nf):
            $cod_nota = $nf->id_rq_ativo;
            $status = $nf->status_rq_ativo;
            $devolvido = $nf->devolvido;
            $data_retorno = $nf->data_retorno;
            $data = date('Y-m-d');
            ?>
       
       
       <div class="col-xs-12">
           <div class="row">
               
           <?php
            
      if($devolvido == 0 AND $data_retorno >= $data){
         echo '<div class="alert alert-warning" role="alert">
                <i class="fa fa-exclamation" aria-hidden="true"></i>
                Os materiais desta Requisição ainda não foi devolvidos.
              </div>
              ' ;
        }
        elseif($devolvido == 0 ){
         echo '<div class="alert alert-danger" role="alert">
                <i class="fa fa-exclamation" aria-hidden="true"></i>
                Os materiais desta Requisição ainda não foi devolvidos e já passaram da data prevista para devolução ('.date('d-m-Y' , strtotime($data_retorno)).').
              </div>
              ' ;
        }
        
        
        
       if($status == 0){
            echo anchor('ativos/fechar/'.$cod_nota, form_button('finalizar', 'Fechar Requisicao', 'class="btn btn-primary"'));
            echo ' <p>Atenção, ao clicar em fechar requisição não serão possíveis alterações na mesma e os produtos serão subtraidos do estoque.</p>';
       }
       elseif($devolvido == 1)
       {
           
       }  
         
      else{
          
          echo '
              
                <div class="alert alert-info" role="alert">
                <i class="fa fa-exclamation" aria-hidden="true"></i>
                Requisição Fechada.
              </div>
              ';
        $CI =& get_instance(); if($CI->Controleacesso->acesso_funcao(22) == true){
          echo anchor('ativos/abrir/'.$cod_nota, form_button('finalizar', 'Abrir Requisicao', 'class="btn btn-primary"'));
          }
           else{
           echo  '<button name="finalizar" type="button" class="btn btn-primary disabled">Abrir Requisicao</button> ';
          }
      }
        ?>
               <a href="<?php echo base_url()?>ativos/gera_pdf/<?php echo $cod_nota; ?>" class="btn btn-success" target="_blank" ><i class="fa fa-print" aria-hidden="true"></i> Imprimir</a>
           </div><hr>
           </div>
       
       <form action="<?php echo base_url()?>ativos/cadastra_item" method="post">
           <input type="hidden" value="<?php echo $nf->id_rq_ativo; ?>" name="id_rq_ativo" />
           <!--<input type="hidden" value="<?php echo $nf->dep_cedente; ?>" name="id_ced_est" />-->
           <input type="hidden" value="<?php echo $nf->dep_rq_ativo; ?>" name="dep_rq_ativo" />
           <input type="hidden" value="<?php echo $nf->data_saida; ?>" name="data_saida" />
           
           
            <div class="col-xs-3">  
                
                <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Cabeçalho da Requisicao</h3>
                </div>
                <div class="panel-body">
                        <div class="form-group">
                   <div class="col-xs-12">
                       <?php $dep_cedente = $nf->dep_rq_ativo; ?>
                       Número : <b><?php echo $nf->id_rq_ativo; ?> </b><br>
                       Data Saída: <b> <?php echo date('d-m-Y' , strtotime($nf->data_saida)); ?> </b><br>
                       Data Retorno: <b> <?php echo date('d-m-Y' , strtotime($nf->data_retorno)); ?> </b><br>
                       Solicitante : <b> <?php echo $nf->nome_rq_ativo; ?> </b> - <?php echo $this->M_ativos->get_dep($nf->dep_rq_ativo);  ?> <br>
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
                         
                       
                     <label>Produto</label>
                     
                     <select class="form-control js-example-basic-single" name="id_produto_rq_ativo">
                     <?php
                     $produtos = $this->M_ativos->listProduto();
                     foreach($produtos->result() as $produto):
                        // echo ('<option value="'.$produto->id_produto.'">'.$produto->nome_produto.' - (Disp. '.$produto->quantidade_qt.' )</option>');
                        echo ('<option value="'.$produto->id_ativo.'">'.$produto->nome_ativo.' - '.$produto->quantidade_ativo.' Un. disp ('.$produto->nome_departamento.')</option>');
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
                       <input type="number" name="qt_rq_ativo"  class="form-control" required/>
                    </div>
               
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
                          
                     </tr> </thead>
                 <tbody> 
                     
                     <?php  foreach($itens as $itens): ?>
                     <tr>
                         <th scope="row">
                            <?php if($status == 1){ ?>
                           
                        <?php }
                        else{?>
                              <a href="#" class="confirma_exclusao" data-nota="<?php echo $cod_nota; ?>"  data-id="<?= $itens->id_est_ativo ?>" data-nome="<?= $itens->nome_ativo ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        <?php }
                            ?>
                        
                                     </th> 
                         <td><?php echo $itens->nome_ativo; ?></td> 
                         <td><?php echo $itens->nome_departamento; ?></td> 
                         <td><?php echo $itens->qt_rq_ativo; ?></td>
                         
                         <td><?php echo number_format($itens->vl_rq_ativo,2,',','.'); ?></td> 
                          <td><?php echo number_format($itens->vl_rq_ativo*$itens->qt_rq_ativo, 2, ',', '.') ; ?></td> 
                          
                     </tr> 
                     <?php endforeach; ?>
                    
                 </tbody>
                </table>
                </div>
               
               
            
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
        <p>Deseja realmente excluir o registro <strong><span id="nome_exclusao"></span></strong> da Requisição <strong><span id="nota_exclusao"></span></strong>?</p>
      </div>
        <form method="post" action="<?php echo base_url()?>ativos/delete_item">
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
        
 