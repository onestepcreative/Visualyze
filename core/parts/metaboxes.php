<?php if (!defined('ABSPATH')) exit; // EXIT IF DIRECTLY ACCESSED

/*

	This file is to illustrate how to build
	metaboxes using the Visualyze_Metaboxes class
	available with every Visualyze Theme.
	
	This file is included in functions.php

*/


function vizSampleMetaboxes(array $meta_boxes) {

	// Start with underscore to hide from custom-fields list
	$prefix = '_viz_';

	// An array of all metabox types available to you
	/*
$meta_boxes[] = array(
		'id'         => 'test_metabox',
		'title'      => 'Test Metabox',
		'pages'      => array('page'),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true,
		'fields'     => array(
			array(
				'name' => 'Test Text',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_text',
				'type' => 'text',
			),
			array(
				'name' => 'Test Text Small',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_textsmall',
				'type' => 'text_small',
			),
			array(
				'name' => 'Test Text Medium',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_textmedium',
				'type' => 'text_medium',
			),
			array(
				'name' => 'Test Date Picker',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_textdate',
				'type' => 'text_date',
			),
			array(
				'name' => 'Test Date Picker (UNIX timestamp)',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_textdate_timestamp',
				'type' => 'text_date_timestamp',
			),
			array(
				'name' => 'Test Date/Time Picker Combo (UNIX timestamp)',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_datetime_timestamp',
				'type' => 'text_datetime_timestamp',
			),
			array(
	            'name' => 'Test Time',
	            'desc' => 'field description (optional)',
	            'id'   => $prefix . 'test_time',
	            'type' => 'text_time',
	        ),
			array(
				'name' => 'Test Money',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_textmoney',
				'type' => 'text_money',
			),
			array(
	            'name' => 'Test Color Picker',
	            'desc' => 'field description (optional)',
	            'id'   => $prefix . 'test_colorpicker',
	            'type' => 'colorpicker',
	        ),
			array(
				'name' => 'Test Text Area',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_textarea',
				'type' => 'textarea',
			),
			array(
				'name' => 'Test Text Area Small',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_textareasmall',
				'type' => 'textarea_small',
			),
			array(
				'name' => 'Test Text Area Code',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_textarea_code',
				'type' => 'textarea_code',
			),
			array(
				'name' => 'Test Title Weeeee',
				'desc' => 'This is a title description',
				'id'   => $prefix . 'test_title',
				'type' => 'title',
			),
			array(
				'name'    => 'Test Select',
				'desc'    => 'field description (optional)',
				'id'      => $prefix . 'test_select',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Option One', 'value' => 'standard', ),
					array( 'name' => 'Option Two', 'value' => 'custom', ),
					array( 'name' => 'Option Three', 'value' => 'none', ),
				),
			),
			array(
				'name'    => 'Test Radio inline',
				'desc'    => 'field description (optional)',
				'id'      => $prefix . 'test_radio_inline',
				'type'    => 'radio_inline',
				'options' => array(
					array( 'name' => 'Option One', 'value' => 'standard', ),
					array( 'name' => 'Option Two', 'value' => 'custom', ),
					array( 'name' => 'Option Three', 'value' => 'none', ),
				),
			),
			array(
				'name'    => 'Test Radio',
				'desc'    => 'field description (optional)',
				'id'      => $prefix . 'test_radio',
				'type'    => 'radio',
				'options' => array(
					array( 'name' => 'Option One', 'value' => 'standard', ),
					array( 'name' => 'Option Two', 'value' => 'custom', ),
					array( 'name' => 'Option Three', 'value' => 'none', ),
				),
			),
			array(
				'name'     => 'Test Taxonomy Radio',
				'desc'     => 'Description Goes Here',
				'id'       => $prefix . 'text_taxonomy_radio',
				'type'     => 'taxonomy_radio',
				'taxonomy' => '', // Taxonomy Slug
			),
			array(
				'name'     => 'Test Taxonomy Select',
				'desc'     => 'Description Goes Here',
				'id'       => $prefix . 'text_taxonomy_select',
				'type'     => 'taxonomy_select',
				'taxonomy' => '', // Taxonomy Slug
			),
			array(
				'name'		=> 'Test Taxonomy Multi Checkbox',
				'desc'		=> 'field description (optional)',
				'id'		=> $prefix . 'test_multitaxonomy',
				'type'		=> 'taxonomy_multicheck',
				'taxonomy'	=> '', // Taxonomy Slug
			),
			array(
				'name' => 'Test Checkbox',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_checkbox',
				'type' => 'checkbox',
			),
			array(
				'name'    => 'Test Multi Checkbox',
				'desc'    => 'field description (optional)',
				'id'      => $prefix . 'test_multicheckbox',
				'type'    => 'multicheck',
				'options' => array(
					'check1' => 'Check One',
					'check2' => 'Check Two',
					'check3' => 'Check Three',
				),
			),
			array(
				'name'    => 'Test wysiwyg',
				'desc'    => 'field description (optional)',
				'id'      => $prefix . 'test_wysiwyg',
				'type'    => 'wysiwyg',
				'options' => array(	'textarea_rows' => 5, ),
			),
			array(
				'name' => 'Test Image',
				'desc' => 'Upload an image or enter an URL.',
				'id'   => $prefix . 'test_image',
				'type' => 'file',
			),
			array(
				'name' => 'oEmbed',
				'desc' => 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.',
				'id'   => $prefix . 'test_embed',
				'type' => 'oembed',
			),
		),
	);
*/
	
	// This metabox will only show when page_id is 195
	$meta_boxes[] = array(
		'id'         => 'home_topban',
		'title'      => 'Homepage Settings',
		'pages'      => array('page'),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true,
		'show_on'    => array('key' => 'page-template', 'value' => 'template-home.php'),
		'fields' => array(
			array(
				'name' => 'Top Banner',
				'type' => 'title',
			),
			array(
				'name' => 'Image Upload',
				'desc' => 'An image to fill the top box ',
				'id'   => $prefix . 'top_image',
				'type' => 'file',
			),
			array(
				'name' => 'Company Highlights',
				'desc' => 'Three offerings you\'re proud to offer your users',
				'type' => 'title',
			),
			
			array(
				'name' => 'Highlight #1',
				'type' => 'sub',
			),
			array(
				'name' => 'Name',
				'desc' => 'An example might be: Great Customer Server',
				'id'   => $prefix . 'feature_name1',
				'type' => 'text_medium',
			),
			array(
				'name' => 'Summary',
				'desc' => 'The name of the feature ',
				'id'   => $prefix . 'feature_desc1',
				'type' => 'textarea_small',
			),
			array(
				'name' => 'Icon',
				'desc' => 'The name of the feature ',
				'id'   => $prefix . 'feature_icon1',
				'type' => 'file',
			),
			array(
				'name' => 'Highlight #2',
				'type' => 'sub',
			),
			array(
				'name' => 'Name',
				'desc' => 'An example might be: Quick Turnaround',
				'id'   => $prefix . 'feature_name2',
				'type' => 'text_medium',
			),
			array(
				'name' => 'Summary',
				'desc' => 'The name of the feature ',
				'id'   => $prefix . 'feature_desc2',
				'type' => 'textarea_small',
			),
			array(
				'name' => 'Icon',
				'desc' => 'The name of the feature ',
				'id'   => $prefix . 'feature_icon2',
				'type' => 'file',
			),
			array(
				'name' => 'Highlight #3',
				'type' => 'sub',
			),
			array(
				'name' => 'Name',
				'desc' => 'An example might be: Fast & Friendly Support',
				'id'   => $prefix . 'feature_name3',
				'type' => 'text_medium',
			),
			array(
				'name' => 'Summary',
				'desc' => 'The name of the feature ',
				'id'   => $prefix . 'feature_desc3',
				'type' => 'textarea_small',
			),
			array(
				'name' => 'Icon',
				'desc' => 'The name of the feature ',
				'id'   => $prefix . 'feature_icon3',
				'type' => 'file',
			),
			array(
				'name' => 'New Theme Spotlight',
				'type' => 'title',
			),
			array(
				'name' => 'New Theme Name',
				'desc' => 'The name of the new theme ',
				'id'   => $prefix . 'oneup_name',
				'type' => 'text_medium',
			),
			array(
				'name' => 'New Theme Image',
				'desc' => 'The new theme spotlight image',
				'id'   => $prefix . 'oneup_img',
				'type' => 'file',
			),
			array(
				'name' => 'Featured Themes',
				'desc' => 'Featured themes for three column layout',
				'type' => 'title',
			),
			array(
				'name' => 'Theme #1',
				'type' => 'sub',
			),
			array(
				'name' => 'Theme Name',
				'desc' => 'The name of the theme ',
				'id'   => $prefix . 'theme_name1',
				'type' => 'text_medium',
			),
			array(
				'name' => 'Theme Image',
				'desc' => 'The image of the theme ',
				'id'   => $prefix . 'theme_icon1',
				'type' => 'file',
			),
			array(
				'name' => 'Theme #2',
				'type' => 'sub',
			),
			array(
				'name' => 'Theme Name',
				'desc' => 'The name of the theme ',
				'id'   => $prefix . 'theme_name2',
				'type' => 'text_medium',
			),
			array(
				'name' => 'Theme Image',
				'desc' => 'The image of the theme ',
				'id'   => $prefix . 'theme_icon2',
				'type' => 'file',
			),
			array(
				'name' => 'Theme #3',
				'type' => 'sub',
			),
			array(
				'name' => 'Theme Name',
				'desc' => 'The name of the theme ',
				'id'   => $prefix . 'theme_name3',
				'type' => 'text_medium',
			),
			array(
				'name' => 'Theme Image',
				'desc' => 'The image of the theme ',
				'id'   => $prefix . 'theme_icon3',
				'type' => 'file',
			),

		)

	);
	
	/*
$meta_boxes[] = array(
		'id'         => 'home_topban',
		'title'      => 'Homepage Settings',
		'pages'      => array('page'),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true,
		'show_on'    => array('key' => 'id', 'value' => array(195)),
		'fields' => array(
			array(
				'name' => 'Top Image',
				'desc' => 'An image to fill the top box ',
				'id'   => $prefix . 'top_image',
				'type' => 'file',
			),
			array(
				'name' => 'Title',
				'desc' => 'An image to fill the top box ',
				'id'   => $prefix . 'top_image',
				'type' => 'file',
			),
		)
	);
*/
	
	/*
for($i = 1; $i < 4; $i++) {
		
		$meta_boxes[] = array(
			'id'         => 'home_features' . $i,
			'title'      => 'Home Feature ' . $i,
			'pages'      => array('page'),
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true,
			'show_on'    => array('key' => 'page-template', 'value' => 'template-home.php'),
			'fields' => array(
				array(
					'name' => 'Column One Feature',
					'desc' => 'The feature highlight for column one',
					'id'   => $prefix . 'top_title',
					'type' => 'title',
				),
				array(
					'name' => 'Feature Name',
					'desc' => 'The name of the feature ',
					'id'   => $prefix . 'feature_name1',
					'type' => 'text_medium',
				),
				array(
					'name' => 'Feature Icon',
					'desc' => 'The name of the feature ',
					'id'   => $prefix . 'feature_icon1',
					'type' => 'file',
				),
				array(
					'name' => 'Feature Summary',
					'desc' => 'The name of the feature ',
					'id'   => $prefix . 'feature_desc1',
					'type' => 'textarea_small',
				),
			)
		);
		
	}
*/
	
	
	/*
$meta_boxes[] = array(
		'id'         => 'oneup_theme',
		'title'      => 'Oneup Theme',
		'pages'      => array('page'),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true,
		'show_on'    => array('key' => 'page-template', 'value' => 'template-home.php'),
		'fields' => array(
			array(
				'name' => 'Big Theme Name',
				'desc' => 'The name of the theme ',
				'id'   => $prefix . 'oneup_name',
				'type' => 'text_medium',
			),
			array(
				'name' => 'Big Theme Image',
				'desc' => 'The image of the theme ',
				'id'   => $prefix . 'oneup_img',
				'type' => 'file',
			),
		)
	);
		
		
	
	for($i = 1; $i < 4; $i++) {
		
		$meta_boxes[] = array(
			'id'         => 'home_themes' . $i,
			'title'      => 'Featured Theme ' . $i,
			'pages'      => array('page'),
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true,
			'show_on'    => array('key' => 'page-template', 'value' => 'template-home.php'),
			'fields' => array(
				array(
					'name' => 'Theme Name',
					'desc' => 'The name of the theme ',
					'id'   => $prefix . 'theme_name' . $i,
					'type' => 'text_medium',
				),
				array(
					'name' => 'Theme Image',
					'desc' => 'The image of the theme ',
					'id'   => $prefix . 'theme_icon' . $i,
					'type' => 'file',
				),
			)
		);
*/
		
	//}

	// Add other metaboxes as needed

	return $meta_boxes;

}



// END OF META-EXAMPLE.PHP ?>