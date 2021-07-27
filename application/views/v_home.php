<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$this->load->model('M_home');
?>
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

<body>
    <div class="container  margin-top">
        <h2>Bem vindo ao sistema de <?php echo title_global; ?>.<div class="num" ></div></h2>
        <div class="col-xs-6 padded" >
           <div class="panel panel-default">
            <div class="panel-heading">
            <h3 class="panel-title">Resumo dos Departamentos</h3>
             </div>
            <div class="panel-body">
                <table id="resumo" class="table"> 
                    <thead>
                        <tr>
                         <th>Dep.</th>
                         <th>Produtos</th>
                        
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
                       $query5 = $this->db->query("SELECT * FROM produtos WHERE departamento_produto = $resumo->id_departamento;");   
                      $quant = 0; 
					 $quant_geral = 0;
                      foreach($query5->result() as $qt):
                       $quant= $quant+$qt->qt_produto; 
						endforeach;
                       $quant_geral = $quant_geral+$quant;
                       echo $quant_geral;
                       
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
        
        <div class="col-xs-6 padded">
             
            
            <h3 ">Resumo do Estoque</h3>
            
            
                
                <div class="alert alert-success" role="alert">
                Quantidade de Produtos no estoque :    <span class="black"><b>  <?php echo  number_format($quant_geral,0,',','.'); ?></b></span>
                </div>
                
                <div class="alert alert-warning" role="alert">
                    Valor atual do estoque : <span class="black"><b>R$ <?php echo  number_format($valor_geral,2,',','.'); ?></b></span>
                </div>
                
           
            
        
    </div>
     

 <script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery-ui-1.10.1.custom.min.js' ?>"></script>