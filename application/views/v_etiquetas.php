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
 <div class="content">
     <div class="container-fluid">
         <div class="row">
           <div class="col-md-12">
           <div class="card row">

             <div class="header">
               <button class="btn btn-info btn-fill btn-wd" onclick="goBack()"> <i class="ti-angle-left"></i>Voltar</button>
       <h3><?php echo $pagina ?></h3>
     </div>
     <div class="content">
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
              </div>
        </div>
        </div>
        </div>
        </div>
