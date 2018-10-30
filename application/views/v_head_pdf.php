   <div class="head_logo"><img align="left" height="50px" src="img/iasd_logo.png" /></div>
        
            <div class="head_texto"><center><h3>Associação Rio Sul </h3> Da Igreja Adventista do Sétimo Dia<br>
                    <h2>Relatório de Estoque
         <?php
        foreach ($nome_dep->result() as $nome_dep):
         echo ' - '.$nome_dep->nome_departamento;
        endforeach;
     
        ?>  </h2>
        </center>
        </div>
    <hr>