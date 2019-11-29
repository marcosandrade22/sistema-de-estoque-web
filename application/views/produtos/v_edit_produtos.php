  <div class="container margin-top" >
      
 
        <h3><?php echo $pagina ?></h3>
        <br />
<div class="right_col" role="main">
        <div class="container">
            
          
            <div class="row">
                <div class="col-md-12">
                  
                   
                  <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                         
                        </div>
                        <div class="panel-body">
                            <div class="row"> 
                                <form enctype="multipart/form-data" action="estoque/salvar_produto" method="POST">
                                <?php// echo form_open('estoque/salvar_produto'); ?> 
                                <input type='hidden' name="id_produto" value="<?= set_value('id_produto') ? : (isset($id_produto) ? $id_produto : ''); ?>">
                                <div class="container">
                                   <button type="submit" class="btn btn-success">Salvar</button>
                                </div>
                                <div class="row padded">
                                <div class="col-md-6 form-group">
                                        <label>Título</label>
                                        <input class="form-control" name="nome_produto" value="<?php echo set_value('nome_produto') ? : (isset($nome_produto) ? $nome_produto : '') ?>">
                                           
                                </div>
                                    
                                <div class="col-md-6 form-group">
                                        <label>Cód. de Barras</label>
                                        <input class="form-control" name="cod_barras" value="<?php echo set_value('cod_barras') ? : (isset($cod_barras) ? $cod_barras : '') ?>">
                                           
                                </div>
                                    
                                </div>
                                
                                <div class="row padded">
                                  <div class="col-md-6 form-group">
                                        <label>Preço</label>
                                        <input  class="form-control moeda" name="preco_venda" value="<?php echo set_value('preco_venda') ? : (isset($preco_venda) ? $preco_venda : '') ?>">
                                           
                                </div>
                                 
                                    <div class="form-group col-md-6">
                                    
                                    <label>Imagem do Produto</label>
                                   
                                         <!--
                                        <input id="field-nascimento_usuario" onclick="openKCFinder(this)" value="<?php echo set_value('imagem_produto') ? : (isset($imagem_produto) ? $imagem_produto : '') ?>" name="imagem_produto" type="text"  class="form-control">
                                         -->
                                          <input class="form-control" type="file" name="imagem_produto" value="uploads/<?php echo set_value('imagem_produto') ? : (isset($imagem_produto) ? $imagem_produto : '') ?>" size="20" />
                                         <span class="help-block">Somente JPG e JPEG</span>
                                    
                                    </div>     
                                  
                                 
                                     <div class="form-group col-md-6">
                                     
                                        <label class="control-label col-md-3">Departamento</label>
                                        <select class="form-control" name="departamento" id="ver-disabled" >
                                        <?php
                                        
                                        foreach($departamento->result() as $departamento):
                                            if($departamento_produto == $departamento->id_departamento){
                                                echo ('<option selected value="'.$departamento->id_departamento.'">'.$departamento->nome_departamento.'</option>');
                                         
                                            }else{
                                            echo ('<option value="'.$departamento->id_departamento.'">'.$departamento->nome_departamento.'</option>');
                                            }
                                            endforeach;
                                         ?>  
                                        </select>
                                        <?php 
                                        
                                        
                                        /* bloqueio de alteração de produto com estoque
                                        if(($this->cadastro->check_estoque2($id_produto) == 0 ) ){
                                            ?>
                                       
                                        <select class="form-control" name="departamento" id="ver-disabled" >
                                        <?php
                                        foreach($departamento->result() as $departamento):
                                        echo ('<option value="'.$departamento->id_departamento.'">'.$departamento->nome_departamento.'</option>');
                                        endforeach;
                                         ?>  
                                        </select>
                                        <?php }
                                        else{
                                        ?>
                                        <select class="form-control" name="departamento" id="ver-disabled" >
                                            <option value="<?php echo $this->cadastro->check_cat($id_produto); ?>"><?php echo $this->cadastro->nome_cat($id_produto); ?></option>
                                        </select>
                                        <div id="mensagem-disabled" >
                                        Este produto possui estoque e não poderá ter o departamento alterado.
                                        </div>
                                        <?php 
                                        }*/
                                        ?>
                                        <p class="estoque" placeholder="Estoque"  ></p>
                                        <span class="help-block"></span>
                                 
                            
                                       
                                     </div>
                                    
                                </div>    
                                  
                               
                                
                                <div class="col-lg-12">
                                   
                                        
                                    
                                  <div class="form-group">
                                          <label>Descrição</label> 
                                          <input class="form-control" name="descricao_produto"  value="<?php echo set_value('descricao_produto') ? : (isset($descricao_produto) ? $descricao_produto : '') ?>" >
                                          
                                        </div>
                                        
                                    <row>
                                        <div class="container">
                                        <button type="submit" class="btn btn-success">Salvar</button>
                                        </div>
                                    </row>      
                                </div>
                                  
                                
                                 
                                </form>
                                <?php// echo form_close(); ?> <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
          
        </div>
</div>