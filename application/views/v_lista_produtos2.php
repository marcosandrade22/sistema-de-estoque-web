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
	
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>	
<script type="text/javascript" language="javascript" class="init">
 $(document).ready(function() {           
         table = $('#requisicoes').DataTable({
        dom: 'Blfrtip',
        buttons: [
             { extend: 'copy', text: 'Copiar' }, 'csv', 'excel',  'print'
        ], 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        stateSave: true,
         // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('estoque/ajax_list_produtos')?>",
            "type": "POST"
        },
        //stateSave: true,
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
         <?php
            $CI =& get_instance(); if($CI->Controleacesso->acesso_funcao(10) == true){
                echo '<button class="btn btn-success" onclick="add_produtos()"><i class="glyphicon glyphicon-plus"></i>Novo Produto</button>';
             }
             else{
                echo '<button class="btn btn-success" disabled><i class="glyphicon glyphicon-plus"></i>Novo Produto</button>';  
             }
             ?>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Recarregar</button>
       
         <a href="estoque/relatorio"><button class="btn btn-primary" ><i class="glyphicon glyphicon-list-alt"></i> Relatório</button></a>
        <br />
        <br />
        <table id="requisicoes" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Cód. Interno</th>
                    <th>Cód. Barras</th>
                    <th>Nome Produto</th>
                    <th>Imagem</th>
                    <th>Departamento</th>
                    <th>Qt.</th>
                    <th>Preço</th>
                    <th>Det.</th>
                    <th style="width:25px;">Edit</th>
                     <th style="width:25px;">Del</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
 
            <tfoot>
            <tr>
                    <th>Cód. Interno</th>
                    <th>Cód. Barras</th>
                    <th>Nome Produto</th>
                    <th>Imagem</th>
                    <th>Departamento</th>
                    <th>Qt.</th>
                    <th>Preço</th>
                    <th>Det.</th>
                    <th style="width:25px;">Edit</th>
                    <th style="width:25px;">Del</th>
            </tr>
            </tfoot>
        </table>
    </div>
 
 

 
<script type="text/javascript">
 
var save_method; //for save method string
var table;
 
$(document).ready(function() {
 $(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
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
    $('.modal-title').text('Novo Produto'); // Set Title to Bootstrap modal title
}
 
function edit_produtos(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('estoque/produto_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
             var estoque;
             if(data.qt_produto == undefined){
             estoque = 0;
            }
            else{
             estoque = data.qt_produto;
            }
             
             if (estoque > 0) {
                 $("#ver-disabled").addClass('hidden', true);
                 $("#ver-delete").addClass('disabled', true);
                  document.getElementById('mensagem-disabled').style.display = "block";
            } 
            else { 
              $("#ver-disabled").removeClass('hidden', true);  
              document.getElementById('mensagem-disabled').style.display = "none";
             }
              $( '.estoque' ).html( '' );
            $( ".estoque" ).append( "<b>Estoque </b>" +data.qt_produto);
             
            //$('[name="estoque"]').val(data.quantidade_qt);
            
            $('[name="id_produto"]').val(data.id_produto);
            $('[name="nome_produto"]').val(data.nome_produto);
            $('[name="cod_barras"]').val(data.cod_barras);
            $('[name="descricao_produto"]').val(data.descricao_produto);
            $('[name="departamento"]').val(data.departamento_produto);
            
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Editar Produto'); // Set title to Bootstrap modal title
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}
function reload_table()
{
    location.reload();
}
 
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url('estoque/produto_add')?>";
    } else {
        url = "<?php echo site_url('estoque/produto_update')?>";
    }
 
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
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
 
        }
    });
}
 
function delete_produtos(id)
{
    if(confirm('Deseja realmente deletar este produto?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('estoque/produto_delete/')?>/"+id,
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
                alert('Error deleting data');
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
                <h3 class="modal-title">Produto</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id_produto"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nome Produto</label>
                            <div class="col-md-9">
                                <input name="nome_produto" placeholder="Nome Produto" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Cód. de Barras</label>
                            <div class="col-md-9">
                                <input name="cod_barras" placeholder="cód. de barras" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Descriçao</label>
                            <div class="col-md-9">
                                <input name="descricao_produto" placeholder="Descriçao" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Preço de Venda</label>
                            <div class="col-md-9">
                                <input name="preco_venda" placeholder="Preço" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                         
                       
                        
                        <div class="form-group ">
                            <label class="control-label col-md-3">Departamento</label>
                            <div class="col-md-9">
                             <select class="form-control" name="departamento" id="ver-disabled" >
                             <?php
                            foreach($departamento->result() as $departamento):
                            echo ('<option value="'.$departamento->id_departamento.'">'.$departamento->nome_departamento.'</option>');
                            endforeach;
                            ?>  
                             </select>
                                <div id="mensagem-disabled" style="display:none">
                                Este produto possui estoque e não poderá ter o departamento alterado.
                                </div>
                                 <p class="estoque" placeholder="Estoque"  ></p>
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