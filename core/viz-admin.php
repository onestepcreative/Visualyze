<?php if (!defined('ABSPATH')) exit; // EXIT IF DIRECTLY ACCESSED



function vizAdminStyles() {

	if(is_admin()) {
		
		wp_register_style('viz_admin', VIZ_URI . '/assets/css/admin.css', array(), '1.0', 'all');
		
		wp_register_style('viz_meta', VIZ_URI . '/assets/css/meta.css', array('thickbox', 'farbtastic'));
		
		wp_enqueue_style('viz_admin');
		wp_enqueue_style('viz_meta');
		
	}
	
}

function vizAdminScripts($hook) { 

	$reqs = array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'media-upload', 'thickbox', 'farbtastic');
  	
  	wp_register_script('viz_picker', VIZ_URI . '/assets/scripts/picker.js');
	wp_register_script('viz_meta', VIZ_URI . '/assets/scripts/meta.js', $reqs, '0.9.1');
  	
  	
  	// ONLY LOAD UP OUR SCRIPTS WHERE WE NEED THEM
  	if ($hook == 'post.php' || $hook == 'post-new.php' || $hook == 'page-new.php' || $hook == 'page.php') {
		
		wp_localize_script('viz_meta', 'devly_ajax_data', array('ajax_nonce' => wp_create_nonce('ajax_nonce'), 'post_id' => get_the_ID()));
		
		wp_enqueue_script('viz_picker');
		wp_enqueue_script('viz_meta');
  	
  	}

}

function vizDisableWidgets() {

	// RECENT COMMENTS, INCOMING LINKS & PLUGINS WIDGETS
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');

	// RECENT DRAFTS, PRIMARY & SECONDARY WIDGETS
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
	remove_meta_box('dashboard_primary', 'dashboard', 'core');
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');

	// YOASTS SEO PLUGIN WIDGET
	remove_meta_box('yoast_db_widget', 'dashboard', 'normal');

	// OTHERS YOU MAY WANT TO REMOVE
	// remove_meta_box('dashboard_right_now', 'dashboard', 'core');
	// remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
	
}

function vizDashboard() {

	wp_add_dashboard_widget('vizDashboardFeed', 'Recently on onenstepcreative', 'vizDashboardFeed');
	
	//wp_add_dashboard_widget('vizTwitterFeed', 'Latest Tweets From @onestepcreative', 'vizTwitterFeed');
	
	// ANY OTHER WIDGETS SHOULD BE ADDED HERE

}

function vizDashboardFeed() {

	if(function_exists('fetch_feed')) {
		
		// MUST INCLUDE THIS FILE FOR SUCCESS
		include_once(ABSPATH . WPINC . '/feed.php');
		
		// DEFINE WHICH FEED YOU WANT TO GET
		$feed 	= fetch_feed('http://blog.onestepcreative.com/feed/rss/');
		
		// SETUP SOME VARIABLES TO WORK WITH
		$limit 	= $feed->get_item_quantity(7);
		$items 	= $feed->get_items(0, $limit);

	} if ($limit == 0) {
		
		// JUST A FRIENDLY FALLBACK MESSAGE
		echo '<div>The requested feed is empty or unavailable.</div>';

	} else { 
		
		// LOOP THRU RESULTS
		foreach ($items as $item) { 
			
			$postLink	= $item->get_permalink();
			$postTitle	= $item->get_title();
			
			echo '<h4 class="devlyFeedTitle"><a href="'.$postLink.'" target="_blank">'.$postTitle.'</a></h4>';
			echo '<p class="devlyFeedDesc">'.substr($item->get_description(), 0, 200).'</p>';
			
		} 

	}

}

function vizTwitterFeed() {
	
	// This widget no longer works due to Twitters new API AUTH rules
	
	// USER TO GET TWEETS FROM
	$user	= 'onestepcreative';
	$count 	= 10;
	$string	= file_get_contents('http://api.twitter.com/1/statuses/user_timeline/'.$user.'.json?count=' . $count);
	$tweets	= json_decode($string); 
	
	// LOOP THRU RESULTS
	foreach ($tweets as $tweet) {
		
		$name		= $tweet->user->name;
		$handle		= $tweet->user->screen_name;
		$image		= $tweet->user->profile_image_url;
		$text 		= $tweet->text;
		$tweetID	= $tweet->id;

		?>
		
		<div class="tweetContainer clearfix">
		
			<div class="tweetone">
				<div class="tweetThumb">
					<img src="<?php echo $image; ?>" alt="twitter img" height="48" width="48" />
				</div>
			</div>
			
			<div class="tweettwo">
				<h3 class="tweetName clearfix">
					<a href="http://twitter.com/<?php echo $handle; ?>" class="twitterDirect" target="_blank">
						<?php echo $name; ?><span class="tweetHandle">@<?php echo $handle; ?></span>
					</a>
				</h3>
				
				<div style="clear:both;"></div>
				
				<div class="tweetText clearfix"><p><?php echo $text; ?></p></div>
			
				<div class="tweetConnect clearfix">
					<a href="" target="_blank">
						<span class="tweetReply">
							<img src="<?php THEME_URI . '/assets/img/admin/tweet-reply.png'; ?>" height="10" width="13" alt="Twitter Reply" /> Reply
						</span>
					</a>
				</div>
			</div>
			
		</div>
	    
	    <?php
		
	}

}

function vizForceSend($args) {


	// If gallery tab is open from metaboxes, add insert to post button
	if (isset($_GET['vizForceSend']) && 'true' == $_GET['vizForceSend']) {
		
		$args['send'] = true;
		
	}
		
	// If from computer tab is open, add insert to post button
	if ( isset( $_POST['attachment_id'] ) && '' != $_POST["attachment_id"] ) {

		$args['send'] = true;

	}

	// Change the value of the upload button
	if (isset($_POST['attachment_id']) && '' != $_POST["attachment_id"]) {

		echo '
			<script type="text/javascript">
				
				function vizParameterInlineName(name) {
				
					name 		= name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
					var regexS 	= "[\\?&]" + name + "=([^&#]*)";
					var regex 	= new RegExp(regexS);
					var results = regex.exec(window.location.href);
					
					if(results == null) {
					
						return "";
					
					} else {
						return decodeURIComponent(results[1].replace(/\+/g, " "));
						
					}
				
				}

				jQuery(function($) {
					if (vizParameterInlineName("vizForceSend")=="true") {
						var vizSendLabel = vizParameterInlineName("vizSendLabel");
						$("td.savesend input").val(vizSendLabel);
					}
				});
				
			</script>';
	}

    return $args;

}

function vizForceLabel() {

	if (isset($_GET['vizForceSend']) && 'true' == $_GET['vizForceSend']) {
		
		$label = $_GET['vizSendLabel'];
		
		if (empty($label)) { $label = "Select File"; } ?>
		
			<script type="text/javascript">
				jQuery(function($) {
					$('td.savesend input').val('<?php echo $label; ?>');
				});
			</script> <?php
			
	}

}

function vizOembedSupport() {

	// VERIFY NONCE
	if (!(isset($_REQUEST['vizAjaxNonce'], $_REQUEST['oembed_url']) && wp_verify_nonce($_REQUEST['vizAjaxNonce'], 'ajax_nonce' ))) { die(); }

	// SANITIZE THE SEARCH QUERY STRING
	$oembed_string = sanitize_text_field($_REQUEST['oembed_url']);

	if (empty($oembed_string)) {
	
		$return = '<p class="ui-state-error-text">Please Try Again</p>';
		$found 	= 'not found';
	
	} else {
		
		// ESCAPE QUERY STRING
		$oembed_url = esc_url($oembed_string);
		
		// GET POST ID TO CHECK FOR EMBEDS
		if (isset($_REQUEST['post_id'])) {
		
			$GLOBALS['post'] = get_post( $_REQUEST['post_id'] );
		
		}
		
		// PING WORDPRESS FOR AN EMBED
		$checkEmbed = $GLOBALS['wp_embed']->run_shortcode( '[embed]'. $oembed_url .'[/embed]' );
		
		// FALLBACK FOR WHEN NO oEMBED WAS FOUND
		$fallback = '<a href="' . $oembed_url . '">' . esc_html($oembed_url) . '</a>';
		
		// CHECK OUR AJAX RESPONSE
		if ($checkEmbed && $checkEmbed != $fallback) {
			
			// IF SUCCESSFUL, EMBED DATA
			$return = '<div class="embedStatus">'. $checkEmbed .'<a href="#" class="devlyRemoveFileButton" rel="'. $_REQUEST['field_id'] .'">Remove Embed</a></div>';
			
			// SET RESPONSE ID
			$found = 'found';

		} else {
			
			// IF FAILED, SHOW ERROR MESSAGE
			$return = '<p class="ui-state-error-text">'.sprintf( __( 'No oEmbed Results Found for %s. View more info at', 'devly' ), $fallback ) .' <a href="http://codex.wordpress.org/Embeds" target="_blank">codex.wordpress.org/Embeds</a>.</p>';
			
			// SET RESPONSE ID
			$found = 'not found';
		
		}
	
	}

	// SEND BACK THE ENCODED DATA
	echo json_encode(array('result' => $return, 'id' => $found));
	
	die();

}

function vizGetViewData($post_ID) {

    $count_key 	= 'post_view_count';
    $count 		= get_post_meta($post_ID, $count_key, true);

    if(!$count) { return '0'; } else { return $count; }

}

function vizViewColumn($newcolumn){
	
    $newcolumn['post_views'] = __('Views');

    return $newcolumn;

}

function vizViewShow($column_name, $id){

	if($column_name === 'post_views'){ 
		
		echo vizGetViewData(get_the_ID()); 
		
	}

}



// END OF VIZ-ADMIN.PHP FILE ?>