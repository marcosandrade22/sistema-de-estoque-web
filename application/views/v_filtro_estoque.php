  <script>


  $(function() {
    $( ".datepicker" ).datepicker({
        maxDate: 'now',
        dateFormat: 'yy-mm-dd',
     dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']

        });
  });

    $(function() {
    $( ".datepicker2" ).datepicker({
        maxDate: 'now',
        dateFormat: 'yy-mm-dd',
     dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']

        });
  });
  </script>
  <div class="content">
  		<div class="container-fluid">
  				<div class="row">
  					<div class="col-md-12">
  					<div class="card row">

              <div class="header">
                  <button class="button-back btn btn-info btn-fill btn-wd" onclick="goBack()"> <i class="ti-angle-left"></i>Voltar</button>
        <h3><?php echo $pagina ?></h3>
      </div>
      <div class="content">

       <form action="<?php echo base_url()?>estoque/gera_pdf" method="post">
           <div class="col-md-6" >
               <div class="row">
           <!--<div class="form-group">
               <h3>Período</h3>
               <div class="col-xs-4">
                   <label> Data Inicial</label> <input class="form-control datepicker" type="text" name="data_in" />
               </div>
               <div class="col-xs-4">
                   <label>Data Final</label> <input class="form-control datepicker2" type="text" name="data_fim" />

               </div>
           </div>-->
               </div>

               <div class="row">
            <div class="form-group">
                   <h3>Departamento</h3>
                    <select class="form-control" name="departamento">
                        <?php
                         $this->load->model('Controleacesso');
                         if($this->Controleacesso->acesso_dep() == true){
                             echo '<option value="0" selected >Todos os Departamentos</option>';
                         }else{
                         //$this->db->where('id_departamento',$this->session->userdata('Departamento'));
                        }
                             ?>

                             <?php
                            foreach($dep->result() as $dep):
                            echo ('<option value="'.$dep->id_departamento.'">'.$dep->nome_departamento.'</option>');
                            endforeach;
                            ?>
                    </select>
            </div>
               </div>

          <input class="btn btn-primary" type="submit" value="Gerar" onclick="this.form.target='_blank';return true">
           </div><!-- xs-6-- >
        </form>

      </div>
      </div>
    </div>
    </div>
    </div>
    </div>


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
