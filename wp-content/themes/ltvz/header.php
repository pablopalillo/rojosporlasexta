<!doctype html>  
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title><?php bloginfo('name') . wp_title( ' -', true, 'left' ); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!--[if lt IE 9]>
			<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>			
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
  		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
  		<link rel="shortcut icon" href="/favicon.ico" />
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<header>
			<div class="container">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/images/banner-dim.png" alt="Rojos por la sexta" class="img-responsive" />
			</div>
	    </header>
		<div id="content" class="container">