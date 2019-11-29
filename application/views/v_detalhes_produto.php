<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    
<body>
 
    <div class="container margin-top">
      
 
        <h3><?php echo $pagina ?> -
        <?php foreach($produto as $produto):?>
            <span class="text-primary"><?php echo $produto->nome_produto; ?></span><br>
             Estoque: <?php  echo $produto->qt_produto; ?>
        </h3>
       
        Código Interno: <b><?php echo $produto->id_produto; ?></b><br>
        Código de barras : <b><?php echo $produto->cod_barras ; ?></b><br>
        <?php endforeach; ?>
        <br>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Recarregar</button>
        <br />
        <br />
        <h4>Extrato</h4>
        <table id="table" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
            <thead>
                <tr>
                     <th>Documento</th>
                     <th>Data</th>
                     <th>Entrada</th>
                     <th>Saída</th>
                    
                     <th>Estoque</th>
                     
                    
                </tr>
            </thead>
            <tbody>
               
                    <?php foreach($lista as $lista):?>
                     <tr>
                    <td><?php if($lista->tipo_movimento == 1){
                        //echo '<a href="nota_fiscal/add_itens/'.$lista->id_nf_estoque.'">'.$this->M_estoqueqt->check_documento($lista->id_estoque).'</a>';
                        echo '<a href="nota_fiscal/add_itens/'.$lista->id_nf_estoque.'">'.$lista->nf_estoque.'</a>';
                        }elseif($lista->tipo_movimento == 2){
                        echo '<a href="requisicoes/add_itens/'.$lista->nf_estoque.'">'.$lista->nf_estoque.'</a>';  
                        }
                        elseif($lista->tipo_movimento == 3){
                        echo '<a href="requisicoes/add_itens/'.$lista->nf_estoque.'">'.$lista->nf_estoque.'</a>';  
                        }
                        ?></td>
                  
                    <td><?php  echo date('d-m-Y ' , strtotime($lista->data_estoque)); ?>  
                        <small><small><?php  echo date('H:i:s' , strtotime($lista->data_estoque)); ?></small></small><br>
                        <small><small><?php echo $this->Getuser->get_nome($lista->usuario_estoque); ?></small></small>
                    </td>
                    <td><?php 
                    if($lista->entrada_estoque == 0){
                        echo '';
                    }else{
                        echo '<span class="blue">'.$lista->entrada_estoque.'</span>'; 
                    }
                    
                    ?></td>
                    <td>
                        <?php 
                        if($lista->saida_estoque == 0){
                           echo ''; 
                        }else{
                            echo '<span class="red">'.$lista->saida_estoque.'</span>';
                            
                        } ?>
                       </td>
                       <td><b><?php echo $lista->quantidade_estoque; ?></b></td>
                    
                    </tr> 
                            <?php endforeach; ?>
               
            </tbody>
 
            <tfoot>
            <tr>
                 <th>Documento</th>
                     <th>Data</th>
                     <th>Entrada</th>
                     <th>Saída</th>
                    
                     <th>Estoque</th>
                
                
            </tr>
            </tfoot>
        </table>
        
        
        <!-- <h4>Saídas</h4>
        <table id="table" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
            <thead>
                <tr>
                     <th>Nota Fiscal</th>
                     <th>Data</th>
                     <th>Qtd</th>
                    <th>Custo</th>
                     <th>Dep.</th>
                     
                    <th style="width:125px;">Açao</th>
                </tr>
            </thead>
            <tbody>
               
                    <?php foreach($saida as $saida):?>
                     <tr>
                    <td>
                        <a href="requisicoes/add_itens/<?php echo $saida->id_req_est; ?>" >
                            <?php  echo $saida->id_req_est; ?>
                        </a>
                    </td>
                    <td><?php  echo $saida->data_rq; ?></td>
                    <td><?php echo $saida->qt_pro_req_est; ?></td>
                    <td><?php echo $saida->preco_estoque; ?></td>
                    <td><?php echo $saida->nome_departamento; ?></td>
                    <td>#</td>
                    </tr> 
                            <?php endforeach; ?>
               
            </tbody>
 
            <tfoot>
            <tr>
                 <th>Nota Fiscal</th>
                     <th>Data</th>
                     <th>Qtd</th>
                    <th>Custo</th>
                     <th>Dep.</th>
                    
                
                <th>Açao</th>
            </tr>
            </tfoot>
        </table>-->
    </div>
 
 
<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>

<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>

<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
 
 
 
 
<script type="text/javascript">
 
var save_method; //for save method string
var table;
 
$(document).ready(function() {
 
    //datatables
    table = $('#').DataTable({
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
    $('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
}
 
function edit_produtos(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('estoque/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="id_produto"]').val(data.id_produto);
            $('[name="nome_produto"]').val(data.nome_produto);
            $('[name="descricao_produto"]').val(data.descricao_produto);
            
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Person'); // Set title to Bootstrap modal title
 
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
        url = "<?php echo site_url('estoque/ajax_add')?>";
    } else {
        url = "<?php echo site_url('estoque/ajax_update')?>";
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
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('estoque/ajax_delete/')?>/"+id,
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
                     
                        
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
</body>
</html>