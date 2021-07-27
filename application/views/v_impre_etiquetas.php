 <base href="<?php echo base_url(); ?>" >
 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/js/JsBarcode.all.min.js')?>">	</script>
<script>
    window.onload = function(){
JsBarcode("#barcode", "Hi world!");
</script>

  
        <?php
         $this->load->model('M_produto');
        foreach ($produto as $produto): ?>
    <div class="etiquetas">
         <div class="head-etiqueta">
             <div class="img-etiqueta">
             <img src="<?php echo base_url(); ?>img/logo.jpg" max-height="30px" align="left" />
             </div>
             <div class="text-head-etiqueta">
             <?php echo nome_global; ?><br><?php echo nomepq_global; ?>
             </div>
            </div>
         <div class="corpo-etiqueta">
       <span class="title-pro-etiqueta">
            <?php echo $this->M_produto->nome_produto($produto->id_produto); ?>
       </span>
            <div class="corpo-esq">
                <h2>Dep : <?php echo $this->M_produto->nome_departamento($produto->id_produto); ?></h2>
                <barcode code=" <?php echo (int)$produto->id_produto; ?>" type="C128A" class="barcode" />
                <br>
                 Cód:   <?php echo (int)$produto->id_produto; ?>
            </div>
            <div class="corpo-dir">
                <?php 
                
                if(!empty($quantidade)){
                    echo '<span class="tit-qtd">Qtd.</span><br>';
                    echo '<span class="qtd-etiq">'.$quantidade.'</span>';
                }
                else{
                  
                }
                
              
                ?>
               
        </div>
        
        
    </div>     
        
         
            
  
</div> 
        
        <?php endforeach; ?>
 

