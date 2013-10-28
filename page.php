

<?php get_header(); ?>

<?php vizCountViews(get_the_ID()); // Found at /core/viz-core.php ?>

<div id="content-container" class="row">

	<div class="columns">

		<div id="main-content" class="small-12 medium-8 large-8 column">

			<?php require('core/parts/loop-single.php'); // Visualyze default single page markup ?>
				
		</div>
		
		<?php get_sidebar(); ?>
		
	</div>

</div>

<?php get_footer(); ?>