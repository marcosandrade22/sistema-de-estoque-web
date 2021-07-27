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
        stateSave: true,
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
       $CI =& get_instance(); if($CI->Controleacesso->acesso_funcao(1) == true){
        echo '<button class="btn btn-success" onclick="add_produtos()"><i class="glyphicon glyphicon-plus"></i>Nova Nota</button>';
        }
        else{
        echo '<button class="btn btn-success"  disabled><i class="glyphicon glyphicon-plus"></i>Nova Nota</button>';
        } ?>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Recarregar</button>
        <br />
        <br />
        <table id="requisicoes" class="table table-striped table-bordered" cellspacing="0" width="100%">
           <thead>
                <tr>
                    <th>Número</th>
                    <th>Série</th>
                    <th>Fornecedor</th>
                    <th>Data</th>
                    <th>Itens</th>
                    <th style="width:125px;">Ação</th>
                </tr>
            </thead>
            <tbody>
                 <?php foreach($fornecedor as $fornecedor): ?>
                <tr>
                    <td><?php echo $fornecedor->numero_nota; ?></td>
                    <td><?php echo $fornecedor->serie_nota; ?></td>
                    <td><?php echo $fornecedor->razao_social; ?></td>
                    <td><?php echo date('d-m-Y' , strtotime($fornecedor->data_nota)); ?></td>
                 <?php 
           if($fornecedor->fechado == 0){
                $CI =& get_instance(); if($CI->Controleacesso->acesso_funcao(5) == true){      
                    echo '<td><a href="nota_fiscal/add_itens/'.$fornecedor->cod_nota.'" class="btn btn btn-sm btn-primary" ><i class="glyphicon glyphicon-plus"></i> Itens </a> </td>' ;
                 }
                    else{
                      echo '<td></td>';
                    }
             
                 }
            else{
                
                   $CI =& get_instance(); if($CI->Controleacesso->acesso_funcao(2) == true){
                    echo '<td><a class="btn btn-sm   btn-danger disabled" >Nota fechada</a> '
                            . '<a href="nota_fiscal/add_itens/'.$fornecedor->cod_nota.'" class="btn btn btn-sm btn-success" ><i class="glyphicon glyphicon-search"></i> Visualizar </a> </td> ';
                    }
                    else{
                      echo '<td></td>';
                    }
            
             }
             
            //add html for action
             // verificação se a nota esta fechada para exibição dos botões
             if($fornecedor->fechado == 0){
                 echo '<td>';
                $CI =& get_instance(); if($CI->Controleacesso->acesso_funcao(3) == true){
                    echo'<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_produtos('."'".$fornecedor->cod_nota."'".')"><i class="glyphicon glyphicon-pencil"></i> Editar</a>'; 
                 }
                 else{
                     
                 }
                 $CI =& get_instance(); if($CI->Controleacesso->acesso_funcao(4) == true){
                   echo  ' <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_produtos('."'".$fornecedor->cod_nota."'".')"><i class="glyphicon glyphicon-trash"></i> Del</a>';
                    }
                    else{
                        
                }
                 
                echo '</td>';
                }
                
             else{
                  echo '<td>';
                $CI =& get_instance(); if($CI->Controleacesso->acesso_funcao(3) == true){
                    echo '<a class="btn btn-sm btn-primary disabled" href="javascript:void(0)" title="Edit" ><i class="glyphicon glyphicon-pencil"></i> Editar</a>';
                    }
                 else{
                     
                 }
                $CI =& get_instance(); if($CI->Controleacesso->acesso_funcao(4) == true){
                    echo ' <a class="btn btn-sm btn-danger disabled" href="javascript:void(0)" title="Hapus" ><i class="glyphicon glyphicon-trash"></i> Del</a>';
                     }
                    else{
                        
                }
                 
                echo '</td>';
             }   
             // fim da verificação de nota aberta
             ?>    
                </tr>
                
                <?php endforeach; ?>
            </tbody>
 
           <tfoot>
            <tr>
               <th>Número</th>
               <th>Série</th>
                    <th>Fornecedor</th>
                    <th>Data</th>
                    <th>Itens</th>
                
                <th>Ação</th>
            </tr>
            </tfoot>
        </table>
    </div>
 
 

 
<script type="text/javascript">
 
var save_method; //for save method string
var table;
 
$(document).ready(function() {
 
    //datatables
    table = $('#tble').DataTable({
        
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
            "url": "<?php echo site_url('estoque/ajax_list')?>",
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
    $('.modal-title').text('Adicionar Nota'); // Set Title to Bootstrap modal title
}
 
function edit_produtos(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('nota_fiscal/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="numero"]').val(data.visao_nota);
            $('[name="serie_nota"]').val(data.serie_visao);
            $('[name="numero_nota"]').val(data.numero_visao);
            $('[name="data_nota"]').val(data.data_visao);
            $('[name="fornecedor"]').val(data.fornecedor_visao);
            //$('[name="departamento"]').val(data.departamento_nota);
            
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Editar Nota'); // Set title to Bootstrap modal title
 
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
    $('#btnSave').text('Salvando...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
    var url;
 
    if(save_method == 'add') {
        url = "<?php echo site_url('nota_fiscal/ajax_add')?>";
    } else {
        url = "<?php echo site_url('nota_fiscal/ajax_update')?>";
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
            $('#btnSave').text('Salvar'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('Salvar'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
 
        }
    });
}
 
function delete_produtos(id)
{
    if(confirm('Realmente gostaria de deletar esta nota?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('nota_fiscal/ajax_delete')?>/"+id,
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
                <h3 class="modal-title">Nota Fiscal</h3>
            </div>
            
           
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input name="numero" value="" class="form-control" type="hidden">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Número</label>
                            <div class="col-md-9">
                                <input name="numero_nota" placeholder="Número da nota fiscal" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Série</label>
                            <div class="col-md-9">
                                <input name="serie_nota" placeholder="Série da nota fiscal" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Data Emissão</label>
                            <div class="col-md-9">
                                <input class="datepicker" name="data_nota" placeholder="Data Emissão" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Fornecedor</label>
                            <div class="col-md-9">
                              <select class="form-control" name="fornecedor">
                             <?php
                            foreach($fornecedor2->result() as $fornecedor2):
                            echo ('<option value="'.$fornecedor2->id_fornecedor.'">'.$fornecedor2->razao_social.'</option>');
                            endforeach;
                            ?>  
                             </select>
                            </div>
                        </div>
                        
                         <!--<div class="form-group">
                            <label class="control-label col-md-3">Departamento</label>
                            <div class="col-md-9">
                              <select class="form-control" name="departamento">
                             <?php
                            foreach($departamento->result() as $departamento):
                            echo ('<option value="'.$departamento->id_departamento.'">'.$departamento->nome_departamento.'</option>');
                            endforeach;
                            ?>  
                             </select>
                            </div>
                        </div>-->
                     
                        
                        
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