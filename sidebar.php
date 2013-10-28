
<aside class="sidebar small-12 medium-4 large-4 columns">

	<?php 
	
	if (is_active_sidebar('viz_sidebar')) {

		dynamic_sidebar( 'viz_sidebar' );

	} else {

		echo '<div class="notify warning"><p>Alert! There are no widgets activated.</p></div>';

	} 
	
	?>

</aside>

