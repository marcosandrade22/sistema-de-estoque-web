   <div class="head_logo"><img align="left" height="50px" src="<?php echo base_url();?>img/logo.jpg" /></div>
        
            <div class="head_texto"><center><h3><?php echo nome_global; ?> </h3> <?php echo nomepq_global; ?><br>
                    <h2>Relatório de Estoque
         <?php
        foreach ($nome_dep->result() as $nome_dep):
         echo ' - '.$nome_dep->nome_departamento;
        endforeach;
     
        ?>  </h2>
        </center>
        </div>
    <hr>