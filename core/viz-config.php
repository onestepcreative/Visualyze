<?php if (!defined('ABSPATH')) exit; // EXIT IF DIRECTLY ACCESSED



add_action('after_setup_theme','vizBlastOff', 15);

add_action('after_setup_theme','vizCoreConfig', 10);



function vizBlastOff() {


	// =========================================================================
	// ===== Hookup functions from core/viz-core.php
	// =========================================================================

	// Remove messy bits from html head
	add_action('init', 'vizCleanHeader');

	// Add visualyze tags to html head
	add_action('wp_head', 'vizHead', 0);

	// Remove wordpress version from RSS
	add_filter('the_generator', 'vizRemoveVersion');
	
	// Add various default theme support
	add_action('after_setup_theme', 'vizThemeSupport');

	// Remove recentcomments style injection
	add_action('widgets_init', 'vizRemoveInjection');
	
	// Make metabox helper available to theme
	add_action('init', 'vizMetaboxSetup', 9999);
	
	// Create Foundation ready search markup
	add_filter('get_search_form', 'vizSearchForm' );
	
	// Create 'time ago' time display
	add_filter('the_time', 'vizShowTimeAgo');
	
	// Store view count to database
	add_action('wp_head', 'vizCountViews');
	
	// Fix excerpts read more link
	add_filter('excerpt_more', 'vizFixExcerpt');
	
	// Remove p tags from post images
	add_filter('the_content', 'vizFixPostImage');
	
	// Remove trackbacks from comment count
	add_filter('get_comments_number', 'vizCommentCount', 0);



	// =========================================================================
	// ===== Hookup functions from core/viz-theme.php
	// =========================================================================
	
	// Enqueue default visualyze styles
	add_action('wp_enqueue_scripts', 'vizStyles', 20);
	
	// Enqueue default visualyze scripts
	add_action('wp_enqueue_scripts', 'vizScripts', 25);
	
	// Register Visualyze sidebars
	add_action('widgets_init', 'vizSidebars');
	
	// Register default theme menus
	add_action('admin_init', 'vizMenus');



	// =========================================================================
	// ===== Hookup functions from core/viz-admin.php
	// =========================================================================
	
	// Load custom CSS in the admin
	add_action('admin_init', 'vizAdminStyles');
	
	// Load custom scripts in the admin
	add_action('admin_enqueue_scripts', 'vizAdminScripts', 10);
	
	// Disable a few default dashboard widgets
	add_action('admin_menu', 'vizDisableWidgets');
	
	// Add Visualyze dashboard widgets
	add_action('wp_dashboard_setup', 'vizDashboard');
	
	// Force the 'insert into post' button
	add_filter('get_media_item_args', 'vizForceSend');
	
	// Force the input value when using force send
	add_action('admin_print_footer_scripts', 'vizForceLabel', 99);
	
	// Provide ajax support for oembeds in metaboxes
	add_action('wp_ajax_devly_oembed_handler', 'vizOembedSupport');
	
	// Build views column in admin
	add_filter('manage_posts_columns', 'vizViewColumn');
	
	// Display view count in view column
	add_action('manage_posts_custom_column', 'vizViewShow', 10, 2);



	// =========================================================================
	// ===== Hookup functions from core/devly-login.php
	// =========================================================================
	
	// Add login styles to login page
	add_action('login_enqueue_scripts', 'vizLoginCSS', 10);
	
	// Enable email or username login
	add_action('wp_authenticate','vizEmailLogin');
	
	// Remove errors from login page
	add_filter('login_errors', create_function('$a', "return null;"));

	
}

function vizCoreConfig() {
	
	
	// =========================================================================
	// ====== Setup different types of error reporting
	// =========================================================================
	
	if(defined('WP_DEBUG') && WP_DEBUG) {
		
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		
	} else {
		
		error_reporting(E_ERROR);
		
	}
	
	
	
	// =========================================================================
	// ====== Define global variables for use in theme
	// =========================================================================
	
	global $wpdb, $pagenow, $visualyze, $data, $theme, $version, $notify, $vizOpts;

	
	
	// =========================================================================
	// ====== Assign values to the variables defined above
	// =========================================================================

	$visualyze	= '';
	$version	= '1.0.1';
	$theme		= wp_get_theme();
	
	$data		= '';
	$notify		= '';
	$vizOpts 	= get_option('visualyze_options', $vizOpts);
	
	

	// =========================================================================
	// ====== Define Visualyze Core constants
	// =========================================================================
	
	define('THEME_DIR', get_template_directory());
	define('THEME_URI', get_template_directory_uri());

	define('VISUALYZE_VERSION', $version);
	define('VIZ_DIR', THEME_DIR . '/core');
	define('VIZ_URI', THEME_URI . '/core');
	
	
}



// END OF VIZ-CONFIG.PHP ?>