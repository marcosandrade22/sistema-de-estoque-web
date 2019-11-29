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
<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/datatables/js/JsBarcode.all.min.js.js')?>">	</script>
<link href="<?php echo base_url(); ?>assets/css/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js' ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-ui.js' ?>"></script>
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
 </script>
<body>
    
 
    <div class="container margin-top" >
      
 
        <h3><?php echo $pagina ?></h3>
        <br />
        
        <div class="row">
            <form action="<?php echo base_url()?>etiquetas/gera_pdf" method="post">
            <h4>Selecione os padrões de etiqueta</h4>
            <div class="col-xs-6">
                
                <div class="form-group">
                    <label>Etiquetas mistas ?</label>
                    <select class="form-control" id="mista" name="mista">
                        <option selected="">Escolha uma opção</option>
                        <option value="1">Um produto por folha</option>
                        <option value="2">Mais de um produto por folha</option>
                    </select>
                </div> 
                
                
                <script>
                      window.onload = function(){

            var select = document.getElementById('mista');
   
            select.onchange = function(){
                 if(this.value == 1)
                 document.getElementById('produto').style.display = "block",
                document.getElementById('produtos').style.display = "none";
                 else if( this.value == 2 )
                 document.getElementById('produtos').style.display = "block",
                 document.getElementById('produto').style.display = "none";
                };
                    };
                    </script>
                    
                    
                   <div id="produto" class="form-group" style="display:none" >
                       <div class="form-group"  >
                       <label>Escolha o Produto</label>
                        <select name="produto" class="form-control js-example-basic-single" style="width: 100%;">
                        <?php
                        $this->load->model('M_nota');
                        $produtos = $this->M_nota->listProduto();
                        foreach($produtos->result() as $produto):
                        echo ('<option value="'.$produto->id_produto.'">'.$produto->nome_produto.'</option>');
                        endforeach;
                        ?> 
                       </select>
                       </div>
                        <div class="form-group">
                        <label>Quantidade</label>
                        <input class="form-control" placeholder="Selecione a quantidade a exibir na etiqueta" type="number" name="quantidade" />
                        Caso não deseje que mostre quantidade deixe em branco.
                        </div>
                        
                   </div>
                   
                    
                <input class="btn btn-primary" type="submit" value="Impressão" onclick="this.form.target='_blank';return true">
                    </div>
            
               
            
            <div class="col-xs-6">
               <div id="produtos" class="form-group" style="display:none" >
                         <label>Escolha os Produto</label>
                         
                         <div class="form-group">
                       <select name="produtos1" class="form-control js-example-basic-single" style="width: 100%;">
                            <?php
                        $this->load->model('M_nota');
                        $produtos = $this->M_nota->listProduto();
                        foreach($produtos->result() as $produto):
                        echo ('<option value="'.$produto->id_produto.'">'.$produto->nome_produto.'</option>');
                        endforeach;
                        ?>
                        </select>
                             <label>Quantidade</label>
                            <input class="form-control" placeholder="Selecione a quantidade a exibir na etiqueta" type="number" name="quantidade1" /> 
                         </div>
                         
                         <div class="form-group">
                         
                           <select name="produtos2" class="form-control js-example-basic-single" style="width: 100%;">
                            <?php
                        $this->load->model('M_nota');
                        $produtos = $this->M_nota->listProduto();
                        foreach($produtos->result() as $produto):
                        echo ('<option value="'.$produto->id_produto.'">'.$produto->nome_produto.'</option>');
                        endforeach;
                        ?>
                        </select>
                             <label>Quantidade</label>
                            <input class="form-control" placeholder="Selecione a quantidade a exibir na etiqueta" type="number" name="quantidade2" /> 
                        
                         </div>
                         
                         <div class="form-group">
                           <select name="produtos3" class="form-control js-example-basic-single" style="width: 100%;">
                           <?php
                        $this->load->model('M_nota');
                        $produtos = $this->M_nota->listProduto();
                        foreach($produtos->result() as $produto):
                        echo ('<option value="'.$produto->id_produto.'">'.$produto->nome_produto.'</option>');
                        endforeach;
                        ?>
                        </select>
                             <label>Quantidade</label>
                            <input class="form-control" placeholder="Selecione a quantidade a exibir na etiqueta" type="number" name="quantidade3" /> 
                        
                         </div>
                         
                         <div class="form-group">
                           <select name="produtos4" class="form-control js-example-basic-single" style="width: 100%;">
                            <?php
                        $this->load->model('M_nota');
                        $produtos = $this->M_nota->listProduto();
                        foreach($produtos->result() as $produto):
                        echo ('<option value="'.$produto->id_produto.'">'.$produto->nome_produto.'</option>');
                        endforeach;
                        ?>
                        </select>
                             <label>Quantidade</label>
                            <input class="form-control" placeholder="Selecione a quantidade a exibir na etiqueta" type="number" name="quantidade4" /> 
                        
                         </div>
                         
                         
                         <div class="form-group">
                           <select name="produtos5" class="form-control js-example-basic-single" style="width: 100%;">
                            <?php
                        $this->load->model('M_nota');
                        $produtos = $this->M_nota->listProduto();
                        foreach($produtos->result() as $produto):
                        echo ('<option value="'.$produto->id_produto.'">'.$produto->nome_produto.'</option>');
                        endforeach;
                        ?>
                        </select>
                             <label>Quantidade</label>
                            <input class="form-control" placeholder="Selecione a quantidade a exibir na etiqueta" type="number" name="quantidade5" /> 
                        
                         </div>    
                             
                         
                         
                         <div class="form-group box">
                        <select name="produtos6" class="form-control js-example-basic-single" style="width: 100%;">
                        <?php
                        $this->load->model('M_nota');
                        $produtos = $this->M_nota->listProduto();
                        foreach($produtos->result() as $produto):
                        echo ('<option value="'.$produto->id_produto.'">'.$produto->nome_produto.'</option>');
                        endforeach;
                        ?>
                        </select>
                             <label>Quantidade</label>
                            <input class="form-control" placeholder="Selecione a quantidade a exibir na etiqueta" type="number" name="quantidade6" /> 
                        
                         </div>
                     </div>
                    
            </div> 
            
                </form>
        </div>