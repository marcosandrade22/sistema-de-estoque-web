<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$this->load->model('M_usuarios', '', TRUE);
?>
  <script type="text/javascript">
	$(document).ready(function(){
		url_host = <?php echo base_url ; ?>;
		
          $.ajax({
                url: url_host+"requisicoes/gera_alerta_rq",
                cache: false,
                success: function(msg){
                    $("#notificacao").html(msg);
                }
            });
			
			 $.ajax({
                url: url_host+"ativos/gera_alerta_rq_nao_devolvida",
                cache: false,
                success: function(msg){
                    $("#nao_dev").html(msg);
                }
            });
			
			$.ajax({
                url: url_host+"ativos/gera_alerta_rq_ativo",
                cache: false,
                success: function(msg){
                    $("#ativo_aberto").html(msg);
                }
            });
			
          
	});
  
    
        </script> 
  <nav class="navbar navbar-default navbar-fixed-top" id="primary_nav_wrap">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url(); ?>"><?php echo title_global; ?></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right ">
                    <li class="hidden active">
                        <a href=""></a>
                       
                    </li>
                        <?php 
                           $this->load->model('Controleacesso');
                    
                    
                            $CI =& get_instance();
                            $CI->Controleacesso->menus();
                           
                          ?>
                    
                   
                   <!-- <li class="page-scroll">
                       
                        <a href="<?php echo base_url(); ?>login/logout">Sair</a>
                    </li>-->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
            
        </div>  
        <!-- /.container-fluid -->
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
    </nav>


