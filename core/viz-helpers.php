<?php if (!defined('ABSPATH')) exit; // EXIT IF DIRECTLY ACCESSED



// =========================================================================
// ====== FUNCTION TO DISPLAY PAGE TITLE
// =========================================================================

/*

	This function creates the text that appears in the 
	<title> of your page. If you're on the homepage, the 
	blog name is displayed, otherwise the default wp 
	title output is displayed.
	
	@echo string    html page title
	
*/


function vizPageTitle() {
	
	if (is_home() || is_front_page()) { 
	
		echo bloginfo('name'); 
		
	} else { 
	
		echo wp_title(''); 
		
	}
	
}


// =========================================================================
// ====== FUNCTION TO TRUNCATE POST TITLES 
// =========================================================================

/*

    Using mb_strlen, this function truncates the
    post title to the nearest space, based on number
    of characters. This allows you to truncate your
    title without cutting off words.
    
    @param int      $limit number of characters
    
    @return string  the truncated title

*/

function vizTruncateTitle($limit) {

	global $post;

	$title = get_the_title($post->ID);
	
	if (mb_strlen($title, 'utf8') > $limit) {
	
		$truncHere 	= strrpos(substr($title, 0, $limit), ' ');	   
		$title 		= substr($title, 0, $truncHere) . '';	
		
	}
	
	return $title;

}


// =========================================================================
// ====== FUNCTION TO TRUNCATE POST EXCERPTS 
// =========================================================================

/*

    Using a simple substr, this function provides
    an easy way to truncate excerpt text. It should
    also be noted that strip_tags is run on the
    truncated text.
    
    @param int      $limit number of character
    
    @return string  truncated excerpt text

*/

function vizTruncateExcerpt($limit) {

	global $post;

	$excerpt	 	= strip_tags(get_the_excerpt($post->ID));

	$devlyExcerpt 	= substr($excerpt, 0, $limit);
	$truncExcerpt 	= substr($excerpt, 0, $limit) . '...';

	if($excerpt > $devlyExcerpt) {

		return $truncExcerpt;

	} else {

		return $devlyExcerpt;

	}


}


// =========================================================================
// ====== FUNCTION TO GET RELATED POSTS FOR CURRENT DISPLAYED POST
// =========================================================================

/*

    Based off of Wordpress' built in tagging system, this 
    function allows you to easily pull down related posts. This 
    function is intended to be used on a single post page, and 
    hasn't been tested otherwise.
    
    @param int      $number amount of posts to pull down
    
    @echo string    unordered list of posts

*/


function vizRelatedPosts($number) {

	global $post;

	$tags = wp_get_post_tags($post->ID);

	echo '<ul id="devlyRelatedPosts">';

	if($tags) {

		// LOOP THRU TAGS & GET SLUGS
		foreach($tags as $tag) { $tag_arr .= $tag->slug . ','; }

		// SETUP QUERY PARAMETERS
        $args = array('tag' => $tag_arr, 'numberposts' => $number, 'post__not_in' => array($post->ID));

     	// QUERY THE POSTS
        $related_posts = get_posts($args);

        // LOOP THRU AND DISPLAY RELATED POSTS
        if($related_posts) {

        	foreach ($related_posts as $post) { 
        	
        		setup_postdata($post); ?>
	           	
	           	<li class="relatedPost">
	           		<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
	           			<?php the_post_thumbnail('related-thumb'); ?>
	           		</a>
	           	</li><?php
		    
		    }

		} else {

			// FALLBACK MESSAGE IF NO RELATED POSTS
        	echo '<li class="relatedEmpty">There are no related posts to display!</li>';

        }

	}

	wp_reset_query();

	echo '</ul>';

}


// =========================================================================
// ====== DISPLAY SIMPLE AUTHOR INFORMATION INSIDE LOOP
// =========================================================================

/*

    This function echo's out a clean and simple
    post author 'box'. When used, it spits out an
    author image, name and desc, based on the
    built in user meta.
    
    @echo string    html author box

*/


function vizSimpleAuthor() { 

	$authID = get_the_author_meta('ID'); 
	$size	= '78';
	
	?>

	<div id="authorBioContainer">
		
		<div class="gravatar"><?php echo get_avatar($authID, $size); ?></div>
		
		<div class="aboutAuthor">
			<h3 class="authorName"><?php the_author(); ?></h3>
			<p><?php echo get_the_author_meta('description') ?></p>
		</div>
		
	</div>
	
	<?php

}


// =========================================================================
// ====== DISPLAY THE MOST VIEWED POSTS WITH A CUSTOM QUERY
// =========================================================================

/*

    This function allows you to query for the most
    popular posts on your site. Using a custom post counter
    built into Visualyze, this pulls down 'N' number of
    posts, and orders them by the 'post_view_count'
    table in the database. This gives posts that
    have the highest view count.
    
    @param int     $number amount of posts to pull
    
    @echo string    unordered list of popular posts

*/

function vizPopularPosts($number) {

	$trending = array(
		'posts_per_page' => $number,
		'meta_key' 		 => 'post_view_count',
		'orderby' 		 => 'meta_value_num'
	);

	$trendingPosts = new WP_Query($trending); ?>

	<h2 class="sideHeading">Trending Posts</h2>

	<ul id="trendingPosts" class="sideList">

		<?php while($trendingPosts->have_posts()) : $trendingPosts->the_post(); ?>

			<li class="sideListItem clearfix">
				<a href="<?php the_permalink(); ?>">

					<span class="listItemPhoto"><?php the_post_thumbnail('devly-thumb'); ?></span>

					<div class="listItemInfo">
						<p class="listItemDate"><?php the_time('j M, Y'); ?></p>
						<h4 class="listItemTitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
					</div>

				</a>
			</li>

		<?php endwhile; ?>

	</ul><?php 
	
	// DO NOT REMOVE THIS
	wp_reset_postdata();

}


// =========================================================================
// ====== DEFAULT ARCHIVE TEMPLATE TITLING LOGIC 
// =========================================================================

/*

    This function is an attempt to do a bit of 
    cleanup for the built in "archive titles" within
    Wordpress. The function takes care of page 
    titles for Categories, Tags, etc.
    
    @echo string    html archive title

*/


function vizArchiveTitles() {
	
	if (is_category()) { ?>
	
		<h3 class="archive-title"><span>Posts Categorized:</span> <?php single_cat_title() ?></h3>
		
	<?php } elseif (is_tag()) { ?>
	
		<h3 class="archive-title"><span>Posts Tagged:</span> <?php single_tag_title() ?></h3>
		
	<?php } elseif (is_author()) { ?>
	
		<h3 class="archive-title"><span>Posts By:</span> <?php echo get_query_var('author_name') ?></h3>
	
	<?php } elseif (is_day()) { ?>
	
		<h3 class="archive-title"><span>Daily Archives:</span> <?php echo get_the_time('l, F j, Y') ?></h3>
		
	<?php } elseif (is_month()) { ?>
	
		<h3 class="archive-title"><span>Monthly Archives:</span> <?php echo get_the_time('F Y') ?></h3>
		
	<?php } elseif (is_year()) { ?>
	
		<h3 class="archive-title"><span>Yearly Archives:</span> <?php echo get_the_time('Y') ?></h3>
		
	<?php }
	
}


// =========================================================================
// ====== MAIN LOOP "CONTENT NOT FOUND" FALLBACK 
// =========================================================================

/*

    This function takes care of the default 404
    'no content found' content that is built into
    Wordpress. Another attempt for cleanup.
    
    @echo string    html no content found

*/

function vizContentNotFound() {
	
	?>
	
	<article class=" articleContainer clearfix">
		<hgroup class="contentNotFound">
			<h3>You appear to be lost...</h3>
			<h5>It's probably on us, so you can bet we're working on it.</h5>
		</hgroup>
	</article>
	
	<?php
	
}


// =========================================================================
// ====== CREATE NUMBERED PAGINATION FOR POSTS
// =========================================================================

/*

    Using this function in place of Wordpress'
    built in page navigations (older/newer), you
    can output true numbered page navigation.
    
    @param string   $before html markup before nav
    @param string   $after html markup after nav
    
    @echo string    html numbered page navigation

*/

function vizPaginate($before = '', $after = '') {

	global $wpdb;
	global $wp_query;

	$request 		= $wp_query->request;
	$foundPosts 	= $wp_query->found_posts;
	$maxPages 		= $wp_query->max_num_pages;
	$postsPerPage 	= intval(get_query_var('posts_per_page'));
	$paged 			= intval(get_query_var('paged'));

	// Don't execute if posts found is less than posts per page
	if ($foundPosts <= $postsPerPage) { return; }

	// Set pagination functionality to 'true'
	if(empty($paged) || $paged == 0) { $paged = 1; }

	$pageLinksLimit = 7;
	$newLinksLimit 	= $pageLinksLimit - 1;
	$startPage 		= $paged - $halfPageStart;
	$endPage 		= $paged + $halfPageEnd;
	$halfPageStart 	= floor($newLinksLimit / 2);
	$halfPageEnd 	= ceil($newLinksLimit / 2);

	// Setup the start page
	if($startPage <= 0) { $startPage = 1; }

	// Setup the end page
	if(($endPage - $startPage) != $newLinksLimit) { 
	
	    $endPage = $startPage + $newLinksLimit; 
	    
    }

	// Calculate the new end page
	if($endPage > $maxPages) {
	
		$startPage 	= $maxPages - $newLinksLimit;
		$endPage 	= $maxPages;
	
	}

	// Setup the start point
	if($startPage <= 0) { $startPage = 1; }

	echo $before . '<nav class="page-navigation"><ol class="viz-pagenav clearfix">' . "";

	// Create back to first page link
	if ($startPage >= 2 && $pageLinksLimit < $maxPages) {

		$firstPageText = "First";
		
		echo '<li class="viz-first-link"><a href="' . get_pagenum_link() . '" title="' . $firstPageText . '">' . $firstPageText . '</a></li>';

	}

	// Create previous page link
	echo '<li class="prev-page">'; 
	    
	    previous_posts_link('&laquo;');
	
	echo '</li>';

	// Setup numbered links
	for($i = $startPage; $i <= $endPage; $i++) {

		if($i == $paged) { 
		
		    echo '<li class="current-page">' . $i . '</li>'; 
		    
		  } else { 
		  
		    echo '<li><a href="' . get_pagenum_link($i) . '">' . $i . '</a></li>'; 
		    
		  }

	}

	// Create the next page link
	echo '<li class="next-page">'; 
	    
	    next_posts_link('&raquo;');
	
	echo '</li>';

	// Create go to last page link
	if ($endPage < $maxPages) {

		$lastPageText = "Last";
		echo '<li class="viz-last-link"><a href="' . get_pagenum_link($maxPages) . '" title="' . $lastPageText . '">' . $lastPageText . '</a></li>';

	}

	echo '</ol></nav>' . $after . "";

}


// =========================================================================
// ====== CREATE NUMBERED PAGINATION FOR POSTS
// =========================================================================

/*

    This function simply gives you default page
    navigation to fallback on. This is very similar
    if not the same markup that is provided by the
    built Wordpress page navigation.
    
    @echo string    html default page navigation

*/

function vizPaginateFallback() {
	
	?>
	
	<nav class="defaultPageNav">
		
		<ul class="clearfix">
			<li class="nextSingle"><?php next_posts_link(__('&laquo; Older Entries', 'visualyze')) ?></li>
			<li class="prevSingle"><?php previous_posts_link(__('Newer Entries &raquo;', 'visualyze')) ?></li>
		</ul>
	
	</nav>

	<?php
	
}



// =========================================================================
// ====== A SIMPLE QUERY TESTER FOR DEVELOPMENT
// =========================================================================

/*

	This function is to help during the dev
	stage of your build. It simply uses Wordpress'
	query counter to display a nice little message
	of how many queries are running on the given
	page. It is recommended that this is run
	in the footer of your site, for the 
	most accurate results.
	
	@echo string    html number of queries alert

*/

function vizShowQueries() {
	
	echo 'ran ' . get_num_queries() . ' queries in ' . timer_stop(1) . ' seconds';
	
}









// END OF THE DEVLY HELPER FILE ?>