<?php

/* 
 * Sistema  IASD belclima.
 * Desenvolvido por Marcos Andrade suportetuxinfo@gmail.com
 * Todos os direitos reservados
 */

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <base href="<?php echo base_url() ;?>">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo title_global; ?> - Área administrativa</title>
<base href="<?php echo base_url(); ?>" >
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url() ;?>assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url() ;?>assets/css/modern-business.css" rel="stylesheet">
      <link href="<?php echo base_url() ;?>assets/css/style-login.css" rel="stylesheet">
      <link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
      <link href='https://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
      <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
      <link href='https://fonts.googleapis.com/css?family=Quicksand:400,700' rel='stylesheet' type='text/css'>

    <!-- Custom Fonts -->
    <link href="<?php echo base_url() ;?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
   
    <div class="container login" style="margin-top:40px">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong> <?php echo title_global; ?></strong>
					</div>
					<div class="panel-body">
						<form role="form" action="<?php echo base_url('/login/logar') ?>" method="post">
							<fieldset>
								<div class="row">
									<div class="center-block">
										<center><img class="profile-img"
                                                                                             src="assets/images/gestao-de-estoque.png" alt="" class="img-responsive"></center>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 col-md-10  col-md-offset-1 ">
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-user"></i>
												</span> 
												<input class="form-control" placeholder="Email" name="email" type="text" autofocus>
											</div>
										</div>
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-lock"></i>
												</span>
												<input class="form-control" placeholder="Senha" name="senha" type="password" value="">
											</div>
										</div>
										<div class="form-group">
											<input type="submit" class="btn btn-lg btn-primary btn-block" value="Acessar">
										</div>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
					<div class="panel-footer ">
						Não é permitido a criação de contas neste painel
					</div>
                </div>
			</div>
		</div>
	</div>
</body>