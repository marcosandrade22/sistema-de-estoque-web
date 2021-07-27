 <base href="<?php echo base_url(); ?>" >
 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
<script type="text/javascript" language="javascript" src="<?php echo base_url('assets/js/JsBarcode.all.min.js')?>">	</script>
<script>
    window.onload = function(){
JsBarcode("#barcode", "Hi world!");
</script>

  
        <?php
         $this->load->model('M_produto');
        ?>

<div class="row2">
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
        <h1>
            <?php echo $this->M_produto->nome_produto($produto1); ?>
        </h1>
            <div class="corpo-esq">
                <h2>Dep : <?php echo $this->M_produto->nome_departamento($produto1); ?></h2>
                <barcode code=" <?php echo (int)$produto1; ?>" type="C128A" class="barcode" />
                <br>
                 Cód:   <?php echo (int)$produto1; ?>
            </div>
            <div class="corpo-dir">
                <?php 
                
                if(!empty($quantidade1)){
                    echo '<span class="tit-qtd">Qtd.</span><br>';
                    echo '<span class="qtd-etiq">'.$quantidade1.'</span>';
                }
                else{
                  
                }
                
              
                ?>
               
        </div>
        
        
    </div>     
        
         
            
  
</div> 
        
 

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
        <h1>
            <?php echo $this->M_produto->nome_produto($produto2); ?>
        </h1>
            <div class="corpo-esq">
                <h2>Dep : <?php echo $this->M_produto->nome_departamento($produto2); ?></h2>
                <barcode code=" <?php echo (int)$produto2; ?>" type="C128A" class="barcode" />
                <br>
                 Cód:   <?php echo (int)$produto2; ?>
            </div>
            <div class="corpo-dir">
                <?php 
                
                if(!empty($quantidade2)){
                    echo '<span class="tit-qtd">Qtd.</span><br>';
                    echo '<span class="qtd-etiq">'.$quantidade2.'</span>';
                }
                else{
                  
                }
                
              
                ?>
               
        </div>
        
        
    </div>     
        
         
            
  
</div> 

</div>

<div class="row2">
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
        <h1>
            <?php echo $this->M_produto->nome_produto($produto3); ?>
        </h1>
            <div class="corpo-esq">
                <h2>Dep : <?php echo $this->M_produto->nome_departamento($produto3); ?></h2>
                <barcode code=" <?php echo (int)$produto3; ?>" type="C128A" class="barcode" />
                <br>
                 Cód:   <?php echo (int)$produto3; ?>
            </div>
            <div class="corpo-dir">
                <?php 
                
                if(!empty($quantidade3)){
                    echo '<span class="tit-qtd">Qtd.</span><br>';
                    echo '<span class="qtd-etiq">'.$quantidade3.'</span>';
                }
                else{
                  
                }
                
              
                ?>
               
        </div>
        
        
    </div>     
        
         
            
  
</div> 


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
        <h1>
            <?php echo $this->M_produto->nome_produto($produto4); ?>
        </h1>
            <div class="corpo-esq">
                <h2>Dep : <?php echo $this->M_produto->nome_departamento($produto4); ?></h2>
                <barcode code=" <?php echo (int)$produto4; ?>" type="C128A" class="barcode" />
                <br>
                 Cód:   <?php echo (int)$produto4; ?>
            </div>
            <div class="corpo-dir">
                <?php 
                
                if(!empty($quantidade4)){
                    echo '<span class="tit-qtd">Qtd.</span><br>';
                    echo '<span class="qtd-etiq">'.$quantidade4.'</span>';
                }
                else{
                  
                }
                
              
                ?>
               
        </div>
        
        
    </div>     
        
         
            
  
</div> 
</div>

<div class="row2">
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
        <h1>
            <?php echo $this->M_produto->nome_produto($produto5); ?>
        </h1>
            <div class="corpo-esq">
                <h2>Dep : <?php echo $this->M_produto->nome_departamento($produto5); ?></h2>
                <barcode code=" <?php echo (int)$produto5; ?>" type="C128A" class="barcode" />
                <br>
                 Cód:   <?php echo (int)$produto5; ?>
            </div>
            <div class="corpo-dir">
                <?php 
                
                if(!empty($quantidade5)){
                    echo '<span class="tit-qtd">Qtd.</span><br>';
                    echo '<span class="qtd-etiq">'.$quantidade5.'</span>';
                }
                else{
                  
                }
                
              
                ?>
               
        </div>
        
        
    </div>     
        
         
            
  
</div>  


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
        <h1>
            <?php echo $this->M_produto->nome_produto($produto6); ?>
        </h1>
            <div class="corpo-esq">
                <h2>Dep : <?php echo $this->M_produto->nome_departamento($produto6); ?></h2>
                <barcode code=" <?php echo (int)$produto6; ?>" type="C128A" class="barcode" />
                <br>
                 Cód:   <?php echo (int)$produto6; ?>
            </div>
            <div class="corpo-dir">
                <?php 
                
                if(!empty($quantidade6)){
                    echo '<span class="tit-qtd">Qtd.</span><br>';
                    echo '<span class="qtd-etiq">'.$quantidade6.'</span>';
                }
                else{
                  
                }
                
              
                ?>
               
        </div>
        
        
    </div>     
        
         
            
  
</div> 
 
</div>
