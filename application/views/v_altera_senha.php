<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo $id;
?>
<div class="container margin-top">
    <h3>Alteração de Senha</h3>
     <div class="modal-body form">
                <form action="#" id="form2" class="form-horizontal">
                    <input name="id_funcionario" value="<?php echo $id; ?>" class="form-control" type="hidden">
                    <div class="form-body">
                       
                        <div class="form-group">
                            <label class="control-label col-md-3">Nova Senha</label>
                            <div class="col-md-9">
                                <input name="senha"  class="form-control" type="password">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSavePass" onclick="save_pass()" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
    
</div>
<script>
    function save_pass()
{
    $('#btnSavePass').text('Salvando...'); //change button text
    $('#btnSavePass').attr('disabled',true); //set button disable
    var url;

        url = "<?php echo site_url('adm_usuarios/ajax_update_pass')?>";
    
 
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form2').serialize(),
        dataType: "JSON",
        success: function(data)
        {
 
            if(data.status) //if success close modal and reload ajax table
            {
                 window.history.go(-1);
               // $('#modal_pass').modal('hide');
               // reload_table();
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
            $('#btnSavePass').text('Salvar'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable
 
        }
    });
}
</script>