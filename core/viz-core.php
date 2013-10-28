<?php if (!defined('ABSPATH')) exit; // EXIT IF DIRECTLY ACCESSED



function vizCleanHeader() {

	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	remove_filter('wp_head', 'wp_widget_recent_comments_style');
	remove_action('wp_head', 'wp_generator');

}

function vizHead() {
	
	global $post;
	
	$html = '';
	
	// Create meta description from excerpt or bloginfo
	$desc = is_single() ? strip_tags(substr($post->post_content, 0, 200)) : get_bloginfo('description');
	
	// Set favicon url from theme settings or default backup
	$vfav = isset($visualyze['viz_favicon']) ? $visualyze['viz_favicon'] : THEME_URI . '/assets/img/ui/favicon.ico';
	
	// Build the html markup for the <head>
	$html .= '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">';
	$html .= '<meta name="HandheldFriendly" content="True">';
	$html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
	$html .= '<meta name="description" content="'. $desc .'" />';
	$html .= '<link href="'. $vfav .'" rel="shortcut icon">';
	
	echo $html;
	
}

function vizRemoveVersion() { 

	return ''; 
	
}

function vizThemeSupport() {

	// Featured images
	add_theme_support('post-thumbnails');
	
	// Woocommerce support
	add_theme_support('woocommerce');

	// Feed Awesomeness
	add_theme_support('automatic-feed-links');

	// Post formats
	add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

	// Wordpress menus
	add_theme_support('menus');

	// Define thumbnail size
	set_post_thumbnail_size(125, 125, true);

}

function vizMetaboxSetup() {

	if (!class_exists('Visualyze_Metaboxes')) {
	
		require_once(TEMPLATEPATH . '/core/classes/visualyze-metaboxes.php');

	}

}

function vizShowTimeAgo() {
 
	global $post;
 
	$date = get_post_time('G', true, $post);

	$chunks = array(
		array( 60 * 60 * 24 * 365, __('year', 'devlytheme'), __('years', 'devlytheme')),
		array( 60 * 60 * 24 * 30 , __('month', 'devlytheme'), __('months', 'devlytheme')),
		array( 60 * 60 * 24 * 7, __('week', 'devlytheme'), __('weeks', 'devlytheme')),
		array( 60 * 60 * 24 , __('day', 'devlytheme'), __('days', 'devlytheme')),
		array( 60 * 60 , __('hour', 'devlytheme'), __('hours', 'devlytheme')),
		array( 60 , __('minute', 'devlytheme'), __('minutes', 'devlytheme')),
		array( 1, __('second', 'devlytheme'), __('seconds', 'devlytheme'))
	);
 
	if (!is_numeric($date)) {
		
		$timeChunks 	= explode( ':', str_replace( ' ', ':', $date ) );
		$dateChunks 	= explode( '-', str_replace( ' ', '-', $date ) );
		$date 			= gmmktime((int)$timeChunks[1], (int)$timeChunks[2], (int)$timeChunks[3], (int)$dateChunks[1], (int)$dateChunks[2], (int)$dateChunks[0]);
	
	}
 
	$current_time 	= current_time('mysql', $gmt = 0);
	$newer_date 	= strtotime($current_time);
	$since 			= $newer_date - $date;

	if (0 > $since) { return 'sometime'; }

	for ( $i = 0, $j = count($chunks); $i < $j; $i++) {
		
		$seconds = $chunks[$i][0];

		if (($count = floor($since / $seconds)) != 0) { break; }

	}

	$output = (1 == $count) ? '1 '. $chunks[$i][1] : $count . ' ' . $chunks[$i][2];
 
 
	if (!(int)trim($output) ){
		
		$output = '0 ' . __( 'seconds', 'devlytheme' );
	
	}
 
	$output .= __(' ago', 'devlytheme');
 
	return $output;

}

function vizSearchForm($form) {

    $form = 
    	'<div class="row">
	    	<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	    		<span class="small-8 column"><input type="text" name="search" class="text search-input" placeholder="Search the Site..." /></span>
				<span class="small-4 column"><button type="submit" id="search-submit" class="small-12 radius">Search</button></span>
			</form>
		</div>';
    
    return $form;
}

function vizCountViews($post_ID) {

	$count_key 	= 'post_view_count';
    $count 		= get_post_meta($post_ID, $count_key, true);

    if($count == '') {

        $count = 0;

        delete_post_meta($post_ID, $count_key);
        add_post_meta($post_ID, $count_key, $count);

        return $count . ' View';

    } else {

        $count++;

        if($count == '1') { return $count . ' View'; } else { return $count . ' Views'; }

        update_post_meta($post_ID, $count_key, $count);

    }

}

function vizFixExcerpt($more) {

	global $post;
	
	return '...  <a href="'. get_permalink($post->ID) . '" title="Read '.get_the_title($post->ID).'">Read more &raquo;</a>';

}

function vizFixPostImage($content){

	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);

}

function vizCommentCount($count) {

	if (!is_admin()) {

		global $id;
		
		$comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
		
		return count($comments_by_type['comment']);

	} else {

		return $count;

	}

}

function vizRemoveInjection() {
	
	global $wp_widget_factory;
	
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));

}



// END OF THE DEVLY CORE FILE ?>