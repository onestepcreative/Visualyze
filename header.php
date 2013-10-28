<!DOCTYPE html>
<!--[if IEMobile 7 ]> <html <?php language_attributes(); ?> class="no-js iem7"> <![endif]-->
<!--[if lt IE 7]> 	  <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    	  <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    	  <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 8)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html class="no-js" dir="ltr" lang="en-US"><!--<![endif]-->

<head>

	<?php global $visualyze, $vizOpts; ?>

	<meta charset="UTF-8">
	
	<title><?php vizPageTitle(); ?></title>
		
	<?php wp_head(); ?>

	<link href="http://fonts.googleapis.com/css?family=Volkhov" rel="stylesheet" type="text/css">

</head>

<body <?php body_class(); ?>>

<div id="page-container">
	
	<header class="header-container">
		<div class="row">

			<hgroup class="logo-wrap small-12 medium-4 large-4 column">
				
				<h3 class="logo"><a href="/" rel="nofollow">Viz Framework</a></h3>
			
			</hgroup>
			
			<nav class="main-nav menu small-12 medium-8 large-8 column">
				
				<?php vizMainMenu(); // Registered at /core/viz-theme.php ?>
			
			</nav>
			
		</div>
	</header>
	
	<!-- <button class="button readMore icon-arrow-right">Send data</button> -->



