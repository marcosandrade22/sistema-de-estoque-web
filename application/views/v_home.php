<script type="text/javascript" language="javascript" class="init">
    jQuery.fn.dataTableExt.oSort['brazilian-asc'] = function(a,b) {
var x = (a == "-") ? 0 : a.replace( /\./g, "" ).replace( /,/, "." );
var y = (b == "-") ? 0 : b.replace( /\./g, "" ).replace( /,/, "." );
x = parseFloat( x );
y = parseFloat( y );
return ((x < y) ? -1 : ((x > y) ? 1 : 0));
};

jQuery.fn.dataTableExt.oSort['brazilian-desc'] = function(a,b) {
var x = (a == "-") ? 0 : a.replace( /\./g, "" ).replace( /,/, "." );
var y = (b == "-") ? 0 : b.replace( /\./g, "" ).replace( /,/, "." );
x = parseFloat( x );
y = parseFloat( y );
return ((x < y) ? 1 : ((x > y) ? -1 : 0));
};


 $(document).ready(function() {
         table = $('#resumo').DataTable({
          "aoColumns": [
			null,
			null,

			{ "sType": "brazilian" },

		] ,

         //"bSortable": true, "sType": "brazilian",
         "order": [[ 1, 'desc' ]],

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

<div class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-warning text-center">
                                            <i class="ti-server"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Produtos</p>
                                          <?php echo  number_format($quant_geral,0,',','.'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                      Quantidade de produtos no estoque
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-success text-center">
                                            <i class="ti-wallet"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Valor</p>
                                            R$ <?php echo  number_format($valor_geral,2,',','.'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        Valor atual do estoque
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-danger text-center">
                                            <i class="ti-pulse"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Errors</p>
                                            23
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        <i class="ti-timer"></i> In the last hour
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="icon-big icon-info text-center">
                                            <i class="ti-twitter-alt"></i>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="numbers">
                                            <p>Followers</p>
                                            +45
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <hr />
                                    <div class="stats">
                                        <i class="ti-reload"></i> Updated now
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                  -->
                </div>
                <div class="row">
              <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Resumo dos Departamentos</h4>

                            </div>
                            <div class="content">
                              <table id="resumo" class="table">
                                  <thead>
                                      <tr>
                                       <th>Dep.</th>
                                       <th>Produtos</th>
                                       <th>Valor</th>
                                      </tr>
                                  </thead>
                          <?php foreach($resumo as $resumo):
                              //$quant_geral = '';

                              ?>
                                  <tr>
                                  <td>
                                      <?php echo $resumo->nome_departamento; ?>
                                  </td>
                                   <td class="right">
                                    <?php
                                     $query5 = $this->db->query("SELECT * FROM estoque WHERE departamento_estoque = $resumo->id_departamento;");
                                    $quant = "0";
                                    foreach($query5->result() as $qt):
                                     $quant= $quant+$qt->quantidade_estoque;


                                     endforeach;
                                     $quant_geral = $quant_geral+$quant;
                                     echo $quant;

                                      ?>
                                  </td>
                                  <td class="right">
                                      <?php

                                      $valor_final = '';
                                     $query4 = $this->db->query("SELECT * FROM estoque WHERE departamento_estoque = $resumo->id_departamento;");
                                     foreach($query4->result() as $qt):
                                     $valor = str_replace(",",".",$qt->preco_estoque);
                                     $valor_linha= $valor*$qt->quantidade_estoque;
                                     $valor_final = $valor_final+$valor_linha;

                                     endforeach;
                                     $valor_geral = $valor_geral+$valor_final;

                                     if(empty($valor_final)){
                                         echo '0';
                                     }
                                     else{
                                      echo  number_format($valor_final,2,',','.');
                                     }


                                     ?>

                                  </td>
                                  </tr>

                          <?php
                          //$quant_geral = $quant_geral+$quant;
                          endforeach;?>
                              </table>
                            </div>
                        </div>
                    </div>
                  </div>






</div>
</div>

 <script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery-ui-1.10.1.custom.min.js' ?>"></script>
