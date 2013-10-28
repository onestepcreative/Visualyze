<?php if (!defined('ABSPATH')) exit; // EXIT IF DIRECTLY ACCESSED


/* 

	Template Name: Full Width
	
	Using the Foundation 4 markup and styles,
	this template will create a full width page
	layout that will scale for all devices

*/


get_header(); ?>

<div id="content-container" class="row">

	<div id="main-content" class="small-12 column">

		<?php require('core/parts/loop-main.php'); // Visualyze default loop markup ?>
				
	</div>

</div>

<?php get_footer(); ?>