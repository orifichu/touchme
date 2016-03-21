<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?php echo $language_abbr; ?>"> <!--<![endif]-->
	<head>
	<?php
	//prefix
	$prefix = 'meta_';
	?>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?php echo t($prefix.'title'); ?></title>
		<meta name="description" content="<?php echo t($prefix.'description'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="<?php echo assets_url(); ?>css/bootstrap.min.css">
		<style>
				body {
					padding-top: 50px;
					padding-bottom: 20px;
				}
		</style>
		<link rel="stylesheet" href="<?php echo assets_url(); ?>css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="<?php echo assets_url(); ?>css/main.css">

		<script src="<?php echo assets_url(); ?>js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
	</head>
	<body class="home">
		<!--[if lt IE 8]>
			<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
	
		<!-- Part 1: Wrap all page content here -->
		<div id="wrap">

			<!-- Begin page content -->
			<div class="container">
				<div class="row text-center">
					<div class="col-md-12">
						<h1>Touch Me</h1>
					</div>
				</div>
				<div class="row text-center">
					<div class="col-md-4 col-md-push-4">
						<p class="subtitle">¿Quién está llamando?</p>
						<form action="videoconferencia_save.php" enctype="multipart/form-data" id="data" name="data" method="post">
							<p><input type="text" class="form-control" id="solicitante" name="solicitante" /></p>
							<p><input type="submit" class="btn btn-default btn-lg btn-block" role="button" value="Buscar" /></p>
              			</form>
						
						<hr/>
						<p><a class="btn btn-default btn-lg btn-block" href="agenda.php" role="button">Ver Llamadas</a></p>
					</div>
				</div>
			</div>

			<div id="push"></div>
		</div>

		<?php echo $footer; ?>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="<?php echo assets_url(); ?>js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

		<script src="<?php echo assets_url(); ?>js/vendor/bootstrap.min.js"></script>

		<script src="<?php echo assets_url(); ?>js/plugins.js"></script>
		<script src="<?php echo assets_url(); ?>js/main.js"></script>

		<?php echo $google_analytics_view; ?>
	</body>
</html>
