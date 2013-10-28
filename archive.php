
<?php get_header(); ?>

<div id="content-container" class="row">

	<div class="columns">

		<div id="main-content" class="small-12 medium-8 large-8 column">
	
			<?php vizArchiveTitles(); // Found at /core/viz-helpers.php ?>
			
			<?php require('core/parts/loop-main.php'); // Visualyze default loop markip ?>
					
			</div>
			
		<?php get_sidebar(); ?>
	
	</div>

</div>

<?php get_footer(); ?>