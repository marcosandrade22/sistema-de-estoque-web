<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row" style="padding-top: 50px">
    <div class="container">
        <h1>Lista de menus</h1>	
    </div>
	 <div class="row">
             <div class="container" >
                                        <div class="col-sm-12">
                                            <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" role="grid" aria-describedby="dataTables-example_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 172px;">Título</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 201px;">Data</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 184px;">Status</th>
                                            
                                            <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 151px;">Ações</th>
                                           
                                    </thead>
                                    <tbody>
                                        <?php foreach ($menus as $menus):?>          
                               <tr class="gradeA even" role="row">
                                            <td class="sorting_1"><?php echo $menus->nome_menu; ?></td>
                                            <td><?php echo $menus->link_menu; ?></td>
                                            <td><?php echo $menus->funcao_id;?></td>
                                            
                                            <td class="center">
                                                <a href="adm_menu/edit/<?php echo $menus->id_menu; ?>" class="btn btn-success" style="padding: 6px 5px">Editar</a>
                                                <a href="#" class='btn btn-danger confirma_exclusao' data-id="<?= $menus->id_menu ?>" data-nome="<?= $menus->nome_menu ?>" />Excluir</a>
                                            </td>
                                           
                                        </tr>
                                        
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                                        </div>
                                    </div>
         </div>
			<div id="push"></div>	
    
    
</div>
 <div class="modal fade" id="modal_confirmation">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Confirmação de Exclusão</h4>
      </div>
      <div class="modal-body" >
        <p>Deseja realmente excluir o registro <strong><span id="nome_exclusao"></span></strong>?</p>
      </div>
        <form method="post" action="adm_artigos/delete/">
            <div id="id_exclusao"></div>
            
            Senha para exclusão:
            
            <input type="password" class="form-group" name="senha">
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Agora não</button>
        <!--<button type="button" class="btn btn-danger" id="btn_excluir">Sim. Excluir</button>-->
        <input type="submit" class="btn btn-danger" id="btn_excluir" value="Sim. Excluir">
      </div> 
        </form>
        
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
 <script src="<?= base_url('assets/js/jquery.js') ?>"></script>	
<script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>

	<script>
	
		var base_url = "<?= base_url(); ?>";
	
		$(function(){
			$('.confirma_exclusao').on('click', function(e) {
			    e.preventDefault();
			    
			    var nome = $(this).data('nome');
			    var id = $(this).data('id');
			    
			    $('#modal_confirmation').data('nome', nome);
			    $('#modal_confirmation').data('id', id);
			    $('#modal_confirmation').modal('show');
			});
			
			$('#modal_confirmation').on('show.bs.modal', function () {
			  var nome = $(this).data('nome');
                          var id = $(this).data('id');
			  $('#nome_exclusao').text(nome);
                          $('#id_exclusao').html('<input type="hidden" name="id" id="id_exclusao" value="'+id+'"/>');
			});	
			
			$('#btn_excluir').click(function(){
				var id = $('#modal_confirmation').data('id');
				document.location.href = base_url + "adm_artigos/delete/"+id;
			});					
		});
	</script>
 <script src="admin/bower_components/jquery/dist/jquery-1.11.1.min.js"></script>