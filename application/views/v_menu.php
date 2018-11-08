<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$this->load->model('M_usuarios', '', TRUE);
?>
  <script type="text/javascript">
        function atualizarTarefas() {
           // aqui voce passa o id do usuario
           var url="requisicoes/gera_alerta_rq";
            jQuery("#notificacao").load(url);
        }
        setInterval("atualizarTarefas()", 1000);

         function RequisicaoNaoDevolvidas() {
           // aqui voce passa o id do usuario
           var url="ativos/gera_alerta_rq_nao_devolvida";
            jQuery("#nao_dev").load(url);
        }
        setInterval("RequisicaoNaoDevolvidas()", 1000);

         function RequisicaoAtAberta() {
           // aqui voce passa o id do usuario
           var url="ativos/gera_alerta_rq_ativo";
            jQuery("#ativo_aberto").load(url);
        }
        setInterval("RequisicaoAtAberta()", 1000);



        </script>

            <div class="sidebar" data-background-color="white" data-active-color="danger">

            <!--
        		Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
        		Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
        	-->

            	<div class="sidebar-wrapper">
                    <div class="logo">
                        <a href="<?php echo base_url(); ?>" class="simple-text">
                            sistema de Estoque
                        </a>
                    </div>
                    <div class="user-info">
                        <h5 class="user-name">Olá <?php echo $this->session->userdata('Usuario'); ?></h5>
                      <small>(<?php
                      $funcao = $this->session->userdata('Funcao');
                      $query = $this->db->query("SELECT * FROM funcoes WHERE id_funcao=$funcao ");
                      foreach ($query->result() as $row):
                        $nome_funcao = $row->nome_funcao;
                      endforeach;
                       echo $nome_funcao; ?>)
                     </small>
                    </div>

                    <ul class="nav">

                        <!--<li class="active">
                            <a href="<?php echo base_url(); ?>">
                                <i class="ti-panel"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>-->
                        <?php
                           $this->load->model('Controleacesso');
                           $CI =& get_instance();
						                $CI->Controleacesso->menu_lateral();
                          ?>

        				              <li class="active-pro">
                            <a href="<?php echo base_url(); ?>login/logout">

                                <p>Sair</p>
                            </a>
                        </li>
                    </ul>
            	</div>
            </div>
<div class="main-panel">
        <nav class="navbar navbar-default " id="primary_nav_wrap">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand" href="#"><?php echo $headline; ?></a>
                </div>

                  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                      <?php
                        //Exibição do menu na barra superior
                        //$this->load->model('controleacesso');
                        //  Controleacesso::menus();
                        ?>

                        <?php
                        if( $this->session->userdata('Funcao') == 1 OR $this->session->userdata('Funcao') == 2 OR $this->session->userdata('Funcao') == 3 OR $this->session->userdata('Funcao') == 5){
                        ?>

                            <li>
                              <a title="Requisições não devolvidas" href="ativos/nova_requisicao">
                              <div class="icones-bar">
                                <i class="ico-notify fa fa-calendar" aria-hidden="true"></i>
                                <div id="nao_dev" class="bg-notify" >
                                </div>
                              </div>
                            </a>
                          </li>
                          <li>
                            <a title="Requisições de ativo abertas" href="ativos/nova_requisicao">
                              <div class="icones-bar"> <i class="ico-notify fa fa-archive" aria-hidden="true"></i></i>
                                <div id="ativo_aberto" class="bg-notify">
                                </div>
                              </div>
                            </a>
                          </li>
                          <li>
                            <a title="Requisições Abertas" href="requisicoes/monitor_requisicao"><div class="icones-bar"> <i class="ico-notify fa fa-file-word-o" aria-hidden="true"></i><div id="notificacao" class="bg-notify" ></div></div></a>
                          </li>
                      <?php
                        }
                            else{

                            }
                      ?>


                    </ul>

                </div>
            </div>
        </nav>

        <!--
  <nav class="navbar navbar-default navbar-fixed-top" id="primary_nav_wrap">
        <div class="container">

            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url(); ?>">Sistema de Estoque</a>
            </div>


            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right ">
                    <li class="hidden active">
                        <a href=""></a>

                    </li>
                        <?php
                          $this->load->model('controleacesso');
                      //    Controleacesso::menus();
                          ?>

                </ul>
            </div>


        </div>

        <div class="row bar">
        <div class="container">

           <div class="user">
                <?php
                if( $this->session->userdata('Funcao') == 1 OR $this->session->userdata('Funcao') == 2 OR $this->session->userdata('Funcao') == 3 OR $this->session->userdata('Funcao') == 5){
                ?>

                    <a title="Requisições não devolvidas" href="ativos/nova_requisicao"><div class="icones-bar"> <i class="ico-notify fa fa-calendar" aria-hidden="true"></i><div id="nao_dev" class="bg-notify" >   </div></div></a>
                    <a title="Requisições de ativo abertas" href="ativos/nova_requisicao"><div class="icones-bar"> <i class="ico-notify fa fa-archive" aria-hidden="true"></i></i><div id="ativo_aberto" class="bg-notify"></div></div></a>
                    <a title="Requisições Abertas" href="requisicoes/monitor_requisicao"><div class="icones-bar"> <i class="ico-notify fa fa-file-word-o" aria-hidden="true"></i><div id="notificacao" class="bg-notify" ></div></div></a>
              <?php
                }
                    else{

                    }
              ?>
                <span class="nome_user"><?php echo $this->session->userdata('Usuario'); ?> (<?php
                $funcao = $this->session->userdata('Funcao');
                $query = $this->db->query("SELECT * FROM funcoes WHERE id_funcao=$funcao ");
                foreach ($query->result() as $row):
                  $nome_funcao = $row->nome_funcao;
                endforeach;
                 echo $nome_funcao; ?>)</span>
                <span class="user-logout"> <a class=""href="<?php echo base_url(); ?>login/logout">Sair</a></span>
            </div>
        </div>
        </div>
    </nav>-->
