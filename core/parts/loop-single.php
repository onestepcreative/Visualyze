<?php if (!defined('ABSPATH')) exit; // EXIT IF DIRECTLY ACCESSED



	if(have_posts()) {
		
		while(have_posts()) {
			
			the_post();
			
			$permalink = get_permalink();
			
			?>
			
			<article id="post-<?php the_ID(); ?>" class="article-container" data-id="<?php the_ID(); ?>" role="article">
	
				<hgroup class="post-heading">
					
					<h2 class="post-title"><?php the_title(); ?></h2>
					
					<h5 class="post-meta">
						<?php the_time('j M, Y'); ?> by <?php the_author_posts_link(); ?>
					</h5>
				
				</hgroup>
			
				<div class="post-content"><?php the_content(); ?></div>
				
				<div class="post-footer">
					<p class="tags">
						<?php the_tags('<span class="tags-title">Tags:</span> ', ', ', ''); ?>
					</p>
				</div>
			
			</article>
			
			<?php
			
		}
		
	} else {
		
		vizContentNotFound(); // Found at /core/viz-helpers.php
		
	}



?>


