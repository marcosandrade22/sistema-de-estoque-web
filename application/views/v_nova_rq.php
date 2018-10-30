<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
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
        <h3>Nova Requisição</h3>
        <form action="requisicoes/create" id="form" class="form-horizontal" method="post">
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
                            <label class="control-label col-md-3">Data</label>
                            <div class="col-md-9">
                                <input class="datepicker" name="data_requisicao" placeholder="Data Emissão" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                     
                        
                        
                    </div>
                    <input type="submit" name="" value="Cadastrar" class="btn btn-primary" data-original-title="" title="">
        </form>
    </div>
    
</body>
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