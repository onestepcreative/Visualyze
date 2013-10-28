<?php if (!defined('ABSPATH')) exit; // EXIT IF DIRECTLY ACCESSED

/*

	Author:   Josh McDonald
	Twitter:  @onestepcreative
	Website:  http://onestepcreative.com

	This file uses Devly's built-in metabox helper
	to build custom metaboxes in the admin. This file
	shows you all of the custom metabox options you
	have available to you. It is recommended that
	you don't delete this file, so that you can
	use it for reference in the future.
	
	This file is included in functions.php

*/



function samplePanelConfig(array $viz_panels) {
	
	$pre = 'viz_';
	
	$viz_panels[] = array(
		'id'        => $pre . 'test_panel',
		'title'     => 'My First Panel',
		'group'		=> 'general_settings'
		'fields'	=> array(
			
			array(
				'id'	=> $pre . 'test_option',
				'name' 	=> 'Test Option1',
				'desc'	=> 'A sample description',
				'std'	=> 'the default value',
				'type'	=> 'text'
			),
			
			array(
				'id'	=> $pre . 'test_option2',
				'name' 	=> 'Test Option2',
				'desc'	=> 'A sample description',
				'std'	=> 'the default value',
				'type'	=> 'text'
			),
			
			array(
				'id'	=> $pre . 'test_option3',
				'name' 	=> 'Test Option3',
				'desc'	=> 'A sample description',
				'std'	=> 'the default value',
				'type'	=> 'text'
			)
			
		)
		
	);

	// Add other metaboxes as needed

	return $viz_panels;

}


// HOOK INTO OUR CUSTOM METABOX FILTER
add_filter('visualyze_options', 'samplePanelConfig');






function visualyzePanelSetup() {
	
	$settings = get_option('visualyze_options');
	
	if(empty($settings)) {
		
		$settings = array(
			'viz_title' => 'Visualyze Settings',
			'viz_flag'	=> 'Options Created'
		);
		
		add_option('visualyze_options', $settings, 'yes');
		
	}
	
	//add_menu_page('Visualyze', 'Visualyze', 'edit_themes', 'visualyze_settings', 'visualyzeBuildPage');
	
}

function visualyzeCreateMenu() {

	$page = add_menu_page('Visualyze', 'Visualyze', 'edit_themes', 'visualyze_settings', 'visualyzeBuildPage');
	
	add_action("load-{$page}", 'visualyzePageSetup' );

}

function visualyzePageSetup() {

	if ( $_POST["visualyze-submit-settings"] == 'Y' ) {
	
		check_admin_referer( "devly-settings-page" );
		devlySaveThemeSettings();
		$url_parameters = isset($_GET['tab'])? 'updated=true&tab='.$_GET['tab'] : 'updated=true';
		wp_redirect(admin_url('admin.php?page=theme-settings&'.$url_parameters));
		exit;
	
	}

}

function visualyzeBuildPage() {
	
	global $pagenow; ?>
	
	<div class="wrap">
		
		<form id="visualyzeSettings" method="post" name="visualyze_settings" enctype="multipart/form-data" action="">
		
			<div id="visualyzeContainer">
			
				<div class="vizSidebar">
				
					<div class="vizLogo">
						
						<h2 id="vizLogoText">Visualyze</h2>
						<span>Theme Settings</span>
					
					</div>
					
					<nav class="vizTabs">
						
						<a href="#">General</a>
						<a href="#">Appearence</a>
						<a href="#">Homepage</a>
						<a href="#">Blog</a>
					
					</nav>
				
				</div>
				
				<div class="vizPanels">
				
					<div class="panelHead"><h3>General Settings</h3></div>
					
					<div class="vizopts">
					
					
					
					</div>
				
				</div>
			
				<div style="clear:both;"></div>
			
			</div>
		
		</form>
	
	</div>
	
	<?php
	
}



// END OF META-EXAMPLE.PHP ?>