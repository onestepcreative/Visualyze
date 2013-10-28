<?php if (!defined('ABSPATH')) exit; // EXIT IF DIRECTLY ACCESSED



	if(have_posts()) {
		
		while(have_posts()) {
			
			the_post();
			
			$permalink = get_permalink();
			
			?>
			
			<article id="post-<?php the_ID(); ?>" class="article-container" data-id="<?php the_ID(); ?>" role="article">
	
				<hgroup class="post-heading">
					
					<h2 class="post-title">
						<a href="<?php echo $permalink; ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
					</h2>
					
					<h5 class="post-meta">
						<?php the_time('j M, Y'); ?> by <?php the_author_posts_link(); ?>
					</h5>
				
				</hgroup>
			
				<div class="post-excerpt">
					
					<?php echo vizTruncateExcerpt(330); // Found in core/viz-helpers.php ?>
					
				</div>
				
				<a href="<?php echo $permalink; ?>" class="read-more">Read More &rarr;</a>
				
				<!-- // UNCOMMENT TO SHOW TAGS IN POST LISTS // -->
				<!-- <div class="postFooter"><p class="tags"><?php //the_tags('<span class="tagsTitle">Tags:</span> ', ', ', ''); ?></p></div> -->
			
			</article>
			
			<?php
			
		}
		
		vizShowPagination(); // Found in core/viz-theme.php
		
	} else {
		
		vizContentNotFound(); // Found at /core/viz-helpers.php
		
	}



?>


