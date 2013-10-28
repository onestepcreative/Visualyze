<?php if (!defined('ABSPATH')) exit; // EXIT IF DIRECTLY ACCESSED



// =========================================================================
// ====== FUNCTION TO DISPLAY PAGE TITLE
// =========================================================================

/*

	This function creates the text that appears
	in the <title> of your page. If you're on the
	homepage, the blog name is displayed, otherwise
	the default wp title output is displayed.
	
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

	This function is pretty stright forward.
	It accepts one parameter ($limit), which is
	the character count you'd like to display
	before you start truncating your title.
	
	Unlike truncating an excerpt, we are
	using mb_strlen() so that titles aren't
	cut off in the middle of words. This
	will find the nearest space and 
	then truncates.
	
	Usage: echo vizTruncateTitle(25);
	
	@return string

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

	Unlike truncating the title, this
	function will begin truncating in the
	middle words, which means the exact
	character count that is passed, is
	when you'll begin truncating.
	
	Usage: echo vizTruncateExcerpt(5)
	
	@return string

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

	This function returns a given amount
	of related posts based on tags that
	are assigned to the post you are
	currently viewing.

	This function is meant to be used on
	the Single post page, and shouldn't
	be used otherwise without alteration. 
	It accepts one parameter, which is 
	the number of related posts you'd 
	like to display. To call 3 posts, 
	just use it like this:
	
	vizRelatedPosts(3);

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

	This function returns minimal info
	about the author for any given post.
	This is typically used on the single
	post page, and will return the authors
	name, gravatar and bio.
	
	Usage: vizSimpleAuthor();

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

	Counting page views is a default function
	provided by the Visualyze Core. Do not remove
	the vizCountViews() function from your files.

	This function queries the database by a meta
	key called "post_view_count", which is attached
	to each post in the database. We then tell the
	database that we want to order the results by 
	the value of "post_view_count", which gives us
	the most viewed posts of all time.
	
	Simply pass the number of posts you want to
	display, to the function and you're done. This
	function is best used in the sidebar or footer.
	
	Usage: vizPopularPosts(10);

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

	In an attempt to clean up, and abstract
	as much logic as possible from the page
	templates on the front end, this code is
	the default you see in most themes to 
	display the proper title on the archive
	pages. Nothing special.
	
	Usage: vizArchiveTitles();

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

	I find it better to wrap this 'no content
	found' fallback into its own so you're able
	to change it one place, and it'll change
	wherever it's used. I also think the end of
	loop can be pain sometimes, this helps
	out a little bit.
	
	Usage: vizContentNotFound();

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

	By using this function you can get rid
	of the default older/newer post navigation
	and replace it with numbered page nav. This
	function can be edited to display markup
	of your choosing.
	
	Usage: vizPaginate();

*/

function vizPaginate($before = '', $after = '') {

	global $wpdb;
	global $wp_query;

	$request 		= $wp_query->request;
	$foundPosts 	= $wp_query->found_posts;
	$maxPages 		= $wp_query->max_num_pages;
	$postsPerPage 	= intval(get_query_var('posts_per_page'));
	$paged 			= intval(get_query_var('paged'));

	// DONT EXECUTE IF POSTS FOUND IS LESS THAN POSTS PER PAGE
	if ($foundPosts <= $postsPerPage) { return; }

	// SET PAGINATION FUNCTIONALITY TO TRUE
	if(empty($paged) || $paged == 0) { $paged = 1; }

	$pageLinksLimit = 7;
	$newLinksLimit 	= $pageLinksLimit - 1;
	$startPage 		= $paged - $halfPageStart;
	$endPage 		= $paged + $halfPageEnd;
	$halfPageStart 	= floor($newLinksLimit / 2);
	$halfPageEnd 	= ceil($newLinksLimit / 2);

	// SETUP START PAGE
	if($startPage <= 0) { $startPage = 1; }

	// SETUP END PAGE
	if(($endPage - $startPage) != $newLinksLimit) { $endPage = $startPage + $newLinksLimit; }

	// CALCULATE NEW END PAGE
	if($endPage > $maxPages) {
		$startPage 	= $maxPages - $newLinksLimit;
		$endPage 	= $maxPages;
	}

	// SETUP STARTING POINT
	if($startPage <= 0) { $startPage = 1; }

	echo $before . '<nav class="page-navigation"><ol class="devlyPageNav clearfix">' . "";

	// SETUP BACK TO FIRST PAGE LINK
	if ($startPage >= 2 && $pageLinksLimit < $maxPages) {

		$firstPageText = "First";
		echo '<li class="devly-first-link"><a href="' . get_pagenum_link() . '" title="' . $firstPageText . '">' . $firstPageText . '</a></li>';

	}

	// SETUP PREVIOUS PAGE LINK
	echo '<li class="prevPage">' . previous_posts_link('<<') . '</li>';

	// SETUP NUMBERED LINKS
	for($i = $startPage; $i <= $endPage; $i++) {

		if($i == $paged) { echo '<li class="current-page">' . $i . '</li>'; } else { echo '<li><a href="' . get_pagenum_link($i) . '">' . $i . '</a></li>'; }

	}

	// SETUP NEXT PAGE LINK
	echo '<li class="nextPage">' . next_posts_link('>>') . '</li>';

	// SETUP GO TO LAST PAGE LINK
	if ($endPage < $maxPages) {

		$lastPageText = "Last";
		echo '<li class="devly-last-link"><a href="' . get_pagenum_link($maxPages) . '" title="' . $lastPageText . '">' . $lastPageText . '</a></li>';

	}

	echo '</ol></nav>' . $after . "";

}


// =========================================================================
// ====== CREATE NUMBERED PAGINATION FOR POSTS
// =========================================================================

/*

	This function can be used by itself to 
	display the default wordpress older/new post 
	markup. The markup is custom and fits into
	visualyze framework styles
	
	Usage: vizPaginateFallback();

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

	The devlyQueries function returns a nice 
	string to the page that lets you know how 
	many queries were ran on page load. To
	get the best results, run this function
	in footer.php
	
	Usage: vizShowQueries();
	
	- Returns: devly ran 14 queries in 0.025 seconds

*/

function vizShowQueries() {
	
	echo 'ran ' . get_num_queries() . ' queries in ' . timer_stop(1) . ' seconds';
	
}









// END OF THE DEVLY HELPER FILE ?>