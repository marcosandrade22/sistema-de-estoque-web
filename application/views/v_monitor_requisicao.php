<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatables/css/buttons.dataTables.css')?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatables/css/shCore.css?>')?>">

<style type="text/css" class="init"></style>
  
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/datatables/js/jquery-1.12.3.min.js')?>">	</script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/datatables/js/jquery.dataTables.js')?>">	</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/datatables/js/shCore.js')?>">	</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/datatables/js/demo.js')?>">	</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/datatables/js/dataTables.buttons.js')?>">	</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/datatables/js/buttons.flash.js')?>"> </script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/datatables/js/buttons.html5.js')?>">	</script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/datatables/js/buttons.print.js')?>">	</script>
	
	
<script type="text/javascript" language="javascript" class="init">
 $(document).ready(function() {           
         table = $('#requisicoes').DataTable({
        dom: 'Blfrtip',
        buttons: [
             { extend: 'copy', text: 'Copiar' }, 'csv', 'excel',  'print'
        ],
        
        "oLanguage": {
    "sProcessing": "Aguarde enquanto os dados são carregados ...",
    "sLengthMenu": "Mostrar _MENU_ registros por pagina",
    "sZeroRecords": "Nenhum registro correspondente ao criterio encontrado",
    "sInfoEmtpy": "Exibindo 0 a 0 de 0 registros",
    "sInfo": "Exibindo de _START_ a _END_ de _TOTAL_ registros",
    "sInfoFiltered": "",
    "sSearch": "Procurar",
    "oPaginate": {
       "sFirst":    "Primeiro",
       "sPrevious": "Anterior",
       "sNext":     "Próximo",
       "sLast":     "Último"
    }
 } 
  });
} );
</script>
    <script>
     
   
  $(function() {
    $( ".datepicker" ).datepicker({
        dateFormat: 'yy-mm-dd',
     dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']

        });
  });
  
    $(function() {
    $( "#datepicker2" ).datepicker({
        dateFormat: 'yy-mm-dd',
     dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']

        });
  });
  </script>
<body>
    
 
    <div class="container margin-top" >
      
 
        <h3><?php echo $pagina ?></h3>
        <br />
        <!--<a href="requisicoes/add_rq"><button class="btn btn-success" ><i class="glyphicon glyphicon-plus"></i>Nova Requisição</button></a>-->
      
        
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Recarregar</button>
        <br />
        <br />
        <table id="requisicoes" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Solicitante</th>
                    <th>Data</th>
                    <th>Dep. Solicitante</th>
                   <th>Tipo</th>
                    <th>Itens</th>
                   
                </tr>
            </thead>
            <tbody>
                <?php foreach($lista as $lista): ?>
                <tr>
                    <td><?php echo $lista->id_requisicao; ?></td>
                     <td><?php echo $lista->nome_requisicao; ?></td>
                      <td><?php echo date('d-m-Y' , strtotime($lista->data_requisicao)); ?></td>
                       <td><?php echo $this->M_requisicao->get_dep($lista->dep_requisicao);  ?></td>
                        <td><?php
                        if($lista->tipo_requisicao == 1){
                            echo 'Doação';
                        }
                        elseif($lista->tipo_requisicao == 2){
                            echo 'Venda';
                        }
                        ?></td>
                    
                       <td>
                           <?php if($lista->fechado == 0){ 
                               
                               $CI =& get_instance(); if($CI->Controleacesso->acesso_funcao(19) == true){
                                echo '<a href="requisicoes/add_itens/'.$lista->id_requisicao.'" class="btn btn btn-sm btn-primary" ><i class="glyphicon glyphicon-plus"></i> Itens </a>';
                                }else{};
                                
                                }
                                else{ ?>
                             
                           <a class="btn btn-sm disabled btn-danger" >Requisição fechada</a>
                                <?php$CI =& get_instance(); if($CI->Controleacesso->acesso_funcao(20) == true){
                                echo '<a href="requisicoes/add_itens/'.$lista->id_requisicao.'" class="btn btn btn-sm btn-success" ><i class="glyphicon glyphicon-search"></i> Visualizar </a> ';
                                    }
                                    else{};
                                    ?>
                        <?php } ?>
                       </td>
                       
                </tr>
                
                <?php endforeach; ?>
            </tbody>
 
            <tfoot>
            <tr>
                 <th>Número</th>
                    <th>Solicitante</th>
                    <th>Data</th>
                    <th>Dep. Solicitante</th>
                    <th>Tipo</th>
                    <th>Itens</th>
             </tr>
            </tfoot>
        </table>
    </div>
 
 

 
<script type="text/javascript">
 
var save_method; //for save method string
var table;
 
$(document).ready(function() {
 $.fn.dataTable.ext.errMode = 'throw';
    //datatables
    table = $('#tble').DataTable({
        dom: 'Blfrtip',
        buttons: [
             { extend: 'copy', text: 'Copiar' }, 'csv', 'excel',  'print'
        ],
        
        "oLanguage": {
    "sProcessing": "Aguarde enquanto os dados são carregados ...",
    "sLengthMenu": "Mostrar _MENU_ registros por pagina",
    "sZeroRecords": "Nenhum registro correspondente ao criterio encontrado",
    "sInfoEmtpy": "Exibindo 0 a 0 de 0 registros",
    "sInfo": "Exibindo de _START_ a _END_ de _TOTAL_ registros",
    "sInfoFiltered": "",
    "sSearch": "Procurar",
    "oPaginate": {
       "sFirst":    "Primeiro",
       "sPrevious": "Anterior",
       "sNext":     "Próximo",
       "sLast":     "Último"
    }
 } ,
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('requisicoes/ajax_list')?>",
            "type": "POST"
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],
 
    });
 
 
    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });
 
    //set input/textarea/select event when change value, remove class error and remove text help block
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
 
});
 
 
 
function add_produtos()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Requisição'); // Set Title to Bootstrap modal title
}
 
function edit_produtos(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('requisicoes/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="id_requisicao"]').val(data.id_requisicao);
            $('[name="nome_requisicao"]').val(data.nome_requisicao);
             $('[name="dep_requisicao"]').val(data.dep_requisicao);
            $('[name="tipo_requisicao"]').val(data.tipo_requisicao);
            $('[name="data_requisicao"]').val(data.data_requisicao);
           
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Editar Requisicao'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Erro ao obter dados');
        }
    });
}
 
function reload_table()
{
    //table.ajax.reload(null,false); //reload datatable ajax
    location.reload();
}
 function save_add(){
     document.getElementById("form").submit();
     
    }
function save()
{
    $('#btnSave').text('Salvando...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
    var url;
 
    if(save_method == 'add') {
        //url = "<?php // echo site_url('requisicoes/ajax_add')?>";
        document.getElementById("form").submit();
    } else {
        url = "<?php echo site_url('requisicoes/ajax_update')?>";
          // ajax adding data to database
   $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
 
            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
           //window.location="requisicoes/add_itens";     
            reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++)
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('Salvar'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Erro ao adicionar/atualizar dados');
            $('#btnSave').text('Salvar'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
 
        }
    });
        
        
        
    }
    
  
 
  
}
 
function delete_produtos(id)
{
    if(confirm('Realmente gostaria de deletar esta requisição?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('requisicoes/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Erro ao excluir dados');
            }
        });
 
    }
}
 
</script>
 
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Requisição</h3>
            </div>
            
           
            <div class="modal-body form">
                <form action="requisicoes/create" method="post" id="form" class="form-horizontal">
                    <input name="id_requisicao" value="" class="form-control" type="hidden">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Solicitante</label>
                            <div class="col-md-9">
                                <input name="nome_requisicao" placeholder="Solicitante" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                                           
                        <div class="form-group">
                            <label class="control-label col-md-3">Departamento Solicitante</label>
                            <div class="col-md-9">
                              <select class="form-control" name="dep_requisicao">
                             
                                  
                            <?php
                             
                            foreach($dep->result() as $dep):
                            echo ('<option value="'.$dep->id_departamento.'">'.$dep->nome_departamento.'</option>');
                            endforeach;
                            ?>  
                             </select>
                            </div>
                        </div>
                        
                        
                        <!--<div class="form-group">
                            <label class="control-label col-md-3">Departamento Cedente</label>
                            <div class="col-md-9">
                              <select class="form-control" name="departamento_ced">
                             <?php
                            foreach($dep_ced->result() as $dep_ced):
                            echo ('<option value="'.$dep_ced->id_departamento.'">'.$dep_ced->nome_departamento.'</option>');
                            endforeach;
                            ?>  
                             </select>
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="control-label col-md-3">Tipo</label>
                            <div class="col-md-9">
                                 <select class="form-control" name="tipo_requisicao">
                                     <option value="1">Doação</option>
                                     <option value="2">Venda</option>
                                   <?php
                                    //foreach($tipo->result() as $tipo):
                                    //echo ('<option value="'.$tipo->id_tipo_requisicao.'">'.$tipo->nome_tipo_requisicao.'</option>');
                                   // endforeach;
                                    ?>
                             </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Data</label>
                            <div class="col-md-9">
                                <input class="datepicker" name="data_requisicao" placeholder="Data Emissão" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                     
                        
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
 <script type="text/javascript">
            $(function () {
               $('.datepicker-input').datepicker({ dateFormat: 'yy-mm-dd' })
            });
        </script>
        
      

 <script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery-ui-1.10.1.custom.min.js' ?>"></script>
		
 
  <script>
  $(function() {
    $( ".datepicker" ).datepicker();
  });
  </script>

</body>
</html>