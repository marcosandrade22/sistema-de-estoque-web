	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
        <div class="container margin-top">
          <div id="page-wrapper" style="margin-top: 20px">

            <div class="container-fluid">
            <div>
		<?php echo $output; ?>
 
            </div>
            </div>
        </div>  
        </div>
        
