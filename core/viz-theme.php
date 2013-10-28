<?php if (!defined('ABSPATH')) exit; // EXIT IF DIRECTLY ACCESSED



function vizStyles() {
	
	if(!is_admin()) {

		// Visualyze reset + foundation 4 styles
		wp_register_style('viz_base', THEME_URI . '/assets/css/visualyze/visualyze.base.css', null, '1.0.1', 'all');
		
		// Visualyze utility styles
		wp_register_style('viz_util', THEME_URI . '/assets/css/visualyze/visualyze.utilities.css', null, '1.0.1', 'all');
		
		// Visualyze media query styles
		wp_register_style('viz_mqs', THEME_URI . '/assets/css/visualyze/visualyze.devices.css', null, '1.0.1', 'all');
		
		// Visualyze default styles
		wp_register_style('viz_main', THEME_URI . '/assets/css/visualyze/visualyze.main.css', null, '1.0.1', 'all');
		
		
		wp_enqueue_style('viz_base');
		wp_enqueue_style('viz_grid');
		wp_enqueue_style('viz_util');
		wp_enqueue_style('viz_mqs');
		wp_enqueue_style('viz_main');
	
	}
	
}

function vizScripts() {
	
	if(!is_admin()) {
		
		$proto = 'http' . ($_SERVER['SERVER_PORT'] == 443 ? 's' : '');
		
		// Remove wordpress jquery
		wp_deregister_script('jquery');
		
		// Google hosted jquery
		wp_register_script('viz_jquery', $proto . '://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', null, '1.10.2', false);

		// Visualyze reset styles
		wp_register_script('modernizr', THEME_URI . '/assets/scripts/visualyze/visualyze.modernizr.js', array('viz_jquery'), '2.6.2', false);
		
		// Global Visualyze script
		wp_register_script('viz_global', THEME_URI . '/assets/scripts/visualyze/visualyze.global.js', array('viz_jquery'), '1.0.1', true);
		
		wp_enqueue_script('modernizr');
		wp_enqueue_script('viz_jquery');
		
		wp_enqueue_script('viz_global');
	
	}
	
}

function vizSidebars() {

    register_sidebar(array(
    	'id' 				=> 'viz_sidebar',
    	'name' 				=> 'Visualyze Sidebar',
    	'description' 		=> 'The default sidebar, registered in viz-theme.php',
    	'before_widget' 	=> '<div id="%1$s" class="widget %2$s">',
    	'after_widget' 		=> '</div>',
    	'before_title' 		=> '<h4 class="widgettitle">',
    	'after_title' 		=> '</h4>'
    ));

}

function vizMenus() {
	
	// Default Menus
	register_nav_menus(
		array(
			'viz_main_menu'	=> 'Main Menu', // devly-theme.php
			'viz_sub_menu'	=> 'Secondary Menu'
		)
	);

	
}

function vizMainMenu() {

	$args = array(
		'theme_location'	=> 'viz_main_menu',
		'container'			=> false,
		'echo'				=> false,
		'item_wrap'			=> '%3$s',
		'depth'				=> 0
	);
	
	$links = strip_tags(wp_nav_menu($args), '<a>');
	
	echo '<nav class="viz-menu menu">'. $links .'</nav>';

}

function vizComments($comment, $args, $depth) {

	// MORE INFO: http://codex.wordpress.org/Function_Reference/wp_list_comments

	$GLOBALS['comment'] = $comment; ?>
	
	<article <?php comment_class('commentContainer clearfix'); ?> id="<?php comment_ID(); ?>" data-id="<?php comment_ID(); ?>">
		
		<div class="commentAuthContainer clearfix">
			
			<div class="commentAuthPhoto"><?php echo get_avatar($comment,$size='48',$default='<path_to_url>' ); ?></div>
			
			<div class="authorMeta">
				<h5 class="commentAuthName clearfix">
					<a href="<?php get_comment_author_link(); ?>"><?php comment_author(); ?></a>
				</h5><div style="clear:both;"></div>
				<span class="datetime">Posted <?php printf(__('%1$s'), get_comment_date(),  get_comment_time()) ?></span>
				<?php comment_reply_link($args, array('depth' => $depth, 'max_depth' => $args['max_depth'])); ?>
			</div>
		
		</div>
		
		<div class="commentInfo">
			
			<div class="commentContent"><?php
				if($comment->comment_approved == '0') {
					echo '<span class=""><p>' . _e('Your comment is awaiting approval!') . '</p></span>';
				}
				
				echo '<p>' . comment_text() . '</p>'; ?>
			</div>
			
			<div class="commentMeta">
				<?php comment_reply_link($args, array('depth' => $depth, 'max_depth' => $args['max_depth'])); ?>
			</div>
		
		</div>
	
	</article><?php

}

function vizShowPagination() {
	
	if(function_exists('vizPaginate')) {
			
		vizPaginate(); // Found in core/viz-helpers.php

	} else {

		vizPaginateFallback(); // Found in core/viz-helpers.php
	
	}
	
}



// END VIZ-THEME.PHP ?>