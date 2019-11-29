<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<link href="<?php echo base_url(); ?>assets/css/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js' ?>"></script>
    <script>
$(function(){
 $('.moeda').bind('keypress',mask.money)
});
$(document).ready(function() {
  $(".js-example-basic-single").select2();
});
</script>
<body>
 
    <div class="container margin-top" >
       <h3><?php echo $pagina ?></h3>
        <?php       foreach ($nf as $nf):
            $cod_nota = $nf->cod_nota;
            $status = $nf->fechado;
            ?>
       
           
       <?php
      
       if($status == 0){
            echo anchor('nota_fiscal/fechar/'.$cod_nota, form_button('finalizar', 'Fechar Nota', 'class="btn btn-primary"'));
            echo ' <p>Atenção, ao clicar em fechar nota não serão possíveis alterações na mesma e os produtos serão adicionados ao estoque.</p>';
       }
      else{
          echo '<div class="row">
              <div class="col-xs-3" >
              
              <div class="alert alert-danger" role="alert">
                <i class="fa fa-exclamation" aria-hidden="true"></i>
                Nota Fechada.
              </div>
              </div>';
         
         $CI =& get_instance(); if($CI->Controleacesso->acesso_funcao(21) == true){
          echo anchor('nota_fiscal/abrir/'.$cod_nota, form_button('finalizar', 'Abrir Nota', 'class="btn btn-primary"'));
          }
          else{
           echo  '<button name="finalizar" type="button" class="btn btn-primary disabled">Abrir Nota</button> ';
          }
          echo '<a href="nota_fiscal/gera_pdf/'.$nf->cod_nota.'" target="_blank" class="btn btn-success" >Imprimir Espelho</a>';
           echo '</div>';
      }
        ?>
       <form action="<?php echo base_url()?>nota_fiscal/cadastra_item" method="post">
           <input type="hidden" value="<?php echo $nf->cod_nota; ?>" name="cod_nota" />
           <input type="hidden" value="<?php echo $nf->numero_nota; ?>" name="numero_nota" />
            <input type="hidden" value="<?php echo $nf->data_nota; ?>" name="data_nota" />
            <div class="col-xs-4">  
                
                <div class="panel panel-default">
                <div class="panel-heading">
                  <h3 class="panel-title">Cabeçalho da Nota Fiscal</h3>
                </div>
                <div class="panel-body">
                        <div class="form-group">
                   <div class="col-xs-12">
                       Número da nota : <b><?php echo $nf->numero_nota; ?> - <?php echo $nf->serie_nota; ?></b><br>
                       Data : <b> <?php echo $nf->data_nota; ?> </b><br>
                     <!--  Departamento : <b> <?php echo $nf->nome_departamento; ?> </b>-->
                  
                   </div>
               
                <div class="col-xs-12">
                   <label>Fornecedor</label>
                   <select name="fornecedor" disabled class="form-control">
                       <option value="<?php echo $nf->id_fornecedor; ?>"><?php echo $nf->razao_social; ?></option>
                   </select>
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
                      <h3 class="panel-title">Item da nota Fiscal</h3>
                    </div>
                <div class="panel-body">
                 <div class="row">
                     <div class="col-xs-12">
                     <label>Produto</label>
                     <select class="form-control js-example-basic-single" name="produto">
                     <?php
                     $this->load->model('M_nota');
                     $produtos = $this->M_nota->listProduto();
                        foreach($produtos->result() as $produto):
                        echo ('<option value="'.$produto->id_produto.'">'.$produto->nome_produto.'</option>');
                        endforeach;
                     ?>  
                    </select>
                     </div>
                 </div>
                    <br>
                <div class="row">
                    <div class="col-xs-6">
                       <label>Qtd.</label>
                       <input type="number" name="quantidade"  class="form-control" required/>
                    </div>
               
                    <div class="col-xs-6">
                    <label>Custo R$</label>
                    <input type="text"  name="preco"  class="form-control moeda" required/>
                    </div>
                    <!--<script>
                      function validate() {
                            if (document.getElementById('atualiza').checked) {
                           document.getElementById('preco_venda').style.display = "block";
                            } else {
                            document.getElementById('preco_venda').style.display = "none"; 
                            }
                        }
                    </script>
                    <div class="col-xs-12">
                        <br>
                       <label>Atualizar Preco de venda</label>
                       <input id="atualiza" type="checkbox"  name="atualiza_venda"  onclick="validate()"><br>
                       
                       <div id="preco_venda" style="display: none">
                        <label>Pr. venda R$</label>
                           <input type="text"  name="preco_venda"  class="form-control moeda" />
                       </div>
                    </div>-->
               
                    
                   
                    
                </div>
                <br>
                <div class="row">
                      
                <div class="col-xs-12">
                   
                    <!--<input type="hidden" name="departamento" value="<?php echo $nf->departamento_nota ;?>" />
                    <select class="form-control" name="departamento">
                    <?php
                        foreach($departamentos->result() as $departamentos):
                        echo ('<option value="'.$departamentos->id_departamento.'">'.$departamentos->nome_departamento.'</option>');
                        endforeach;
                    ?>  
                   </select>-->
                </div>
                </div>
                
                <div class="row">
                        <div class="col-xs-6">
                          <br>
                          <?php if($status == 1)
                              {
                              echo '<input disabled class="btn btn-primary" type="submit" value="Nota Fechada" />';
                          }
                          else{
                              echo '<input class="btn btn-primary" type="submit" value="Cadastrar item na nota" />';
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
           <div class="col-xs-8">
               <div class="panel panel-default">
                <!-- Default panel contents -->
                 <div class="panel-heading">
                     <h3 class="panel-title">Itens desta nota </h3>
                 </div>

                <!-- Table -->
                <table class="table" >
                 <thead> 
                     <tr> 
                         <th>#</th> 
                         <th>Produto</th> 
                         
                         <th>Quantidade</th> 
                         <th>Departamento</th>
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
                              <a href="#" class="confirma_exclusao" data-nota="<?php echo $cod_nota; ?>"  data-id="<?= $itens->id_estoque ?>" data-nome="<?= $itens->nome_produto ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        <?php }
                            ?>
                        
                                     </th> 
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
                </table>
                 
                </div>
               
               Total da Nota : R$ <?php echo number_format($total, 2, ',', '.') ; ?>
               
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
        <form method="post" action="<?php echo base_url()?>nota_fiscal/delete">
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
			
			$('#modal_confirmation').on('show.bs.modal', function () {
			  var nome = $(this).data('nome');
                          var id = $(this).data('id');
                          var nota = $(this).data('nota');
			  $('#nome_exclusao').text(nome);
                          $('#nota_exclusao').text(nota);
                          $('#id_exclusao').html('<input type="hidden" name="id" id="id_exclusao" value="'+id+'"/>');
                          $('#id_nota').html('<input type="hidden" name="nota" id="id_nota" value="'+nota+'"/>');
			});	
			
			$('#btn_excluir').click(function(){
				var id = $('#modal_confirmation').data('id');
				document.location.href = base_url + "nota_fiscal/delete/"+id;
			});					
		});
                
                jQuery(function($){
   $("#date").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
   $("#moeda").mask("999.999,99");
   $("#tin").mask("99-9999999");
   $("#ssn").mask("999-99-9999");
});
	</script>
        
 