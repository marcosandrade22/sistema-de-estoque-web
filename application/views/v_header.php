<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
            <base href="<?php echo base_url(); ?>" >
                
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<title><?php echo $title;?></title>
		
		<!-- CSS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/estilo.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
  
		
                
		<!-- JavaScript 
		<script src="<?php echo base_url('assets/js/jquery-1.9.1.js')?>"></script>
                <script>
                $.noConflict();
                jQuery( document ).ready(function( $ ) {
                  // Code that uses jQuery's $ can follow here.
                });
                // Code that uses other library's $ can follow here.
                </script>-->
                
                 <script src="<?php echo base_url() . 'assets/js/jquery-1.12.0.min.js' ?>"></script>
                
		<script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery.dataTables.min.js' ?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery-ui-1.10.1.custom.min.js' ?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery.maskedinput.js' ?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . 'assets/js/bootstrap.js' ?>"></script>
		<script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery.js' ?>"></script>
                <script type="text/javascript" src="<?php echo base_url() . 'assets/js/moeda.js' ?>"></script>
                
                <link href="<?php echo base_url(); ?>assets/css/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<script>
$(function(){
 $('.moeda').bind('keypress',mask.money)
});



</script>
<script type="text/javascript">
$(document).ready(function() {
  $(".js-example-basic-single").select2();
});
</script>
	</head>
	<body>