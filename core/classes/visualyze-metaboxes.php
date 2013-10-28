<?php if (!defined('ABSPATH')) exit; // EXIT IF DIRECTLY ACCESSED



class Visualyze_Metaboxes {

	protected $_meta_box;

	function __construct($meta_box) {
		
		if (!is_admin()) return;

		$this->_meta_box = $meta_box;

		$upload = false;
		
		foreach ($meta_box['fields'] as $field) {
			
			if ($field['type'] == 'file' || $field['type'] == 'file_list') {
				
				$upload = true;
				break;
			
			}
		
		}

		global $pagenow;
		
		if ($upload && in_array($pagenow, array( 'page.php', 'page-new.php', 'post.php', 'post-new.php' ))) {
			
			add_action( 'admin_head', array( &$this, 'addPostEnctype' ) );
		
		}

		add_action('admin_menu', array(&$this, 'add'));
		add_action('save_post', array(&$this, 'save'));

		add_filter('visualyze_metabox_show', array(&$this, 'restrictForID'), 10, 2);
		add_filter('visualyze_metabox_show', array(&$this, 'restrictForTemplate'), 10, 2);
	
	}

	function add() {
		
		$this->_meta_box['context'] 	= empty($this->_meta_box['context']) ? 'normal' : $this->_meta_box['context'];
		$this->_meta_box['priority'] 	= empty($this->_meta_box['priority']) ? 'high' : $this->_meta_box['priority'];
		$this->_meta_box['show_on'] 	= empty( $this->_meta_box['show_on'] ) ? array('key' => false, 'value' => false) : $this->_meta_box['show_on'];

		foreach ( $this->_meta_box['pages'] as $page ) {
		
			if(apply_filters('visualyze_metabox_show', true, $this->_meta_box )) {
			
				add_meta_box( $this->_meta_box['id'], $this->_meta_box['title'], array(&$this, 'show'), $page, $this->_meta_box['context'], $this->_meta_box['priority']);
			
			}
		
		}
	
	}

	function show() {

		global $post;

		// USE THE NONCE FOR VERIFICATION
		echo '<input type="hidden" name="wp_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
		echo '<table class="form-table devlyMetabox">';

		foreach ($this->_meta_box['fields'] as $field) {
		
			// SETUP DEFAULT OR BLANK VALUES FOR EMPTY ONES
			if (!isset($field['name'])) { $field['name'] = ''; }
			if (!isset($field['desc'])) { $field['desc'] = ''; }
			if (!isset( $field['std'])) { $field['std'] = ''; }
			
			if ('file' == $field['type'] && !isset($field['allow'])) { $field['allow'] = array('url', 'attachment'); }
			if ('file' == $field['type'] && !isset($field['save_id'])) { $field['save_id']  = false; }
			if ('multicheck' == $field['type']) { $field['multiple'] = true; }
			
			// MULTIPLE VALUES ARE ALLOWED IF "MULTICHECK" IS SET
			$meta = get_post_meta($post->ID, $field['id'], 'multicheck' != $field['type']);
			
			// BEGIN OUR TABLE ROW FOR METABOX
			echo '<tr>';

			if ($field['type'] == "title") {
				
				echo '<td colspan="2">';
				
			} elseif ($field['type'] == "title" || $field['type'] == 'sub') {
			
				echo '<td class="subtitle" colspan="2">';
			
			} else {
			
				if($this->_meta_box['show_names'] == true) {
			
					echo '<th style="width:18%"><label for="', $field['id'], '">', $field['name'], '</label></th>';
			
				}
			
			
				echo '<td>';
			
			}
			
			// DISPLAY LOGIN DEPENDING ON WHAT "TYPE" IS SET
			switch ($field['type']) {
				
				// FULL WIDTH TEXT FIELD
				case 'text':
					echo '<input type="text" class="text" id="'.$field['id'].'" name="'.$field['id'].'" value="', '' !== $meta ? $meta : $field['std'],'" />';
					echo '<p class="devlyMetaboxDescription">', $field['desc'], '</p>';
				break;
				
				// SMALL TEXT FIELD
				case 'text_small':
					echo '<input class="text devlySmallText" type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="', '' !== $meta ? $meta : $field['std'], '" />';
					echo '<span class="devlyMetaboxDescription">', $field['desc'], '</span>';
				break;
				
				// MEDIUM TEXT FIELD
				case 'text_medium':
					echo '<input class="text devlyMediumText" type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="', '' !== $meta ? $meta : $field['std'], '" />';
					echo '<span class="devlyMetaboxDescription">', $field['desc'], '</span>';
				break;
				
				// REGULAR DATE PICKER
				case 'text_date':
					echo '<input class="text devlySmallText devlyDatePicker" type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="', '' !== $meta ? $meta : $field['std'], '" />';
					echo '<span class="devlyMetaboxDescription">', $field['desc'], '</span>';
				break;
				
				// DATE PICKER WITH TIMESTAMP
				case 'text_date_timestamp':
					echo '<input class="text devlySmallText devlyDatePicker" type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="', '' !== $meta ? date( 'm\/d\/Y', $meta ) : $field['std'], '" />';
					echo '<span class="devlyMetaboxDescription">', $field['desc'], '</span>';
				break;
				
				// DATE & TIME WITH TIMESTAMP
				case 'text_datetime_timestamp':
					echo '<input class="text devlySmallText devlyDatePicker" type="text" name="'.$field['id'].'[date]" id="', $field['id'], '_date" value="', '' !== $meta ? date( 'm\/d\/Y', $meta ) : $field['std'], '" />';
					echo '<input class="devlyTimePicker text_time" type="text" name="'.$field['id'].'[time]" id="', $field['id'], '_time" value="', '' !== $meta ? date( 'h:i A', $meta ) : $field['std'], '" />';
					echo '<span class="devlyMetaboxDescription" >', $field['desc'], '</span>';
				break;
				
				// REGULAR TIME SELECTOR
				case 'text_time':
					echo '<input class="devlyTimePicker text_time" type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="', '' !== $meta ? $meta : $field['std'], '" />';
					echo '<span class="devlyMetaboxDescription">', $field['desc'], '</span>';
				break;
				
				// MONEY TEXT FIELD
				case 'text_money':
					echo '$ <input class="devlyMoneyText" type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="', '' !== $meta ? $meta : $field['std'], '" />';
					echo '<span class="devlyMetaboxDescription">', $field['desc'], '</span>';
				break;
				
				// COLOR PICKER
				case 'colorpicker':
					
					$meta 		= '' !== $meta ? $meta : $field['std'];
					$hexValue 	= '(([a-fA-F0-9]){3}){1,2}$';
					
					// IF VALUE DOESN'T HAVE "#", PREPEND IT
					if (preg_match( '/^' . $hexValue . '/i', $meta)) {
					
						$meta = '#' . $meta;

					} elseif (!preg_match('/^#' . $hexValue . '/i', $meta)) {
						
						$meta = "#";
						
					}

					echo '<input class="devlyColorPicker devlySmallText" type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="', $meta, '" />';
					echo '<span class="devlyMetaboxDescription">', $field['desc'], '</span>';
				break;
				
				// REGULAR TEXTAREA
				case 'textarea':
					echo '<textarea class="textarea" name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="10">', '' !== $meta ? $meta : $field['std'], '</textarea>' . '<p class="devlyMetaboxDescription">', $field['desc'], '</p>';
				break;
				
				// SMALL TEXTAREA
				case 'textarea_small':
					echo '<textarea class="textarea" name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">', '' !== $meta ? $meta : $field['std'], '</textarea>' . '<p class="devlyMetaboxDescription">', $field['desc'], '</p>';
				break;
				
				// TEXTAREA FOR CODE
				case 'textarea_code':
					echo '<textarea class="textarea devlyCodeTextarea" name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="10">', '' !== $meta ? $meta : $field['std'], '</textarea>' . '<p class="devlyMetaboxDescription">', $field['desc'], '</p>';
				break;
				
				// SELECT MENU
				case 'select':
					if(empty($meta) && !empty($field['std'])) { $meta = $field['std']; }
					
					echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
					
					foreach ($field['options'] as $option) {
					
						echo '<option value="', $option['value'], '"', $meta == $option['value'] ? ' selected="selected"' : '', '>', $option['name'], '</option>';
					
					}
					
					echo '</select>';
					echo '<p class="devlyMetaboxDescription">', $field['desc'], '</p>';
				break;
				
				// INLINE RADIO BUTTON
				case 'radio_inline':
					
					if(empty($meta) && !empty($field['std'])) { $meta = $field['std']; }
					
					echo '<div class="devlyInlineRadio">';
					
					$i = 1;
					foreach ($field['options'] as $option) {
					
						echo '<div class="devlyInlineRadioOption"><input type="radio" name="'.$field['id'].'" id="', $field['id'], $i, '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' /><label for="', $field['id'], $i, '">', $option['name'], '</label></div>';
						$i++;
					
					}
					
					echo '</div>';
					echo '<p class="devlyMetaboxDescription">', $field['desc'], '</p>';
				break;
				
				// REGULAR RADIO BUTTON
				case 'radio':
				
					if(empty($meta) && !empty($field['std'])) { $meta = $field['std']; }
				
					echo '<ul>';
				
					$i = 1;
					foreach ($field['options'] as $option) {
				
						echo '<li><input type="radio" name="'.$field['id'].'" id="', $field['id'], $i,'" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' /><label for="', $field['id'], $i, '">', $option['name'].'</label></li>';
						$i++;
				
					}
				
					echo '</ul>';
					echo '<p class="devlyMetaboxDescription">', $field['desc'], '</p>';
				break;
				
				// REGULAR CHECKBOX
				case 'checkbox':
					echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'"', $meta ? ' checked="checked"' : '', ' />';
					echo '<span class="devlyMetaboxDescription">', $field['desc'], '</span>';
				break;
				
				// CHECKBOX TO HANDLE MULTIPLE SELECTION
				case 'multicheck':
					
					echo '<ul>';
					
					$i = 1;
					foreach ( $field['options'] as $value => $name ) {

						// USE "IN_ARRAY()" TO CHECK WHETHER OR NOT THE CURRENT OPTION SHOULD BE CHECKED
						echo '<li><input type="checkbox" name="', $field['id'], '[]" id="', $field['id'], $i, '" value="', $value, '"', in_array( $value, $meta ) ? ' checked="checked"' : '', ' /><label for="', $field['id'], $i, '">', $name, '</label></li>';
						$i++;

					}

					echo '</ul>';
					echo '<span class="devlyMetaboxDescription">', $field['desc'], '</span>';
				break;
				
				// SECTION TITLE
				case 'title':
					echo '<h5 class="devlyMetaboxTitle">', $field['name'], '</h5>';
					echo '<p class="devlyMetaboxDescription">', $field['desc'], '</p>';
				break;
				
				case 'sub':
					echo '<h6 class="devlySubtitle">', $field['name'], '</h6>';
				break;
				
				// WYSIWYG EDITOR
				case 'wysiwyg':
					wp_editor( $meta ? $meta : $field['std'], $field['id'], isset( $field['options'] ) ? $field['options'] : array() );
			        echo '<p class="devlyMetaboxDescription">', $field['desc'], '</p>';
				break;
				
				// SELECT MENU FOR TAXONOMIES
				case 'taxonomy_select':
					
					echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
					
					$names	= wp_get_object_terms($post->ID, $field['taxonomy']);
					$terms 	= get_terms($field['taxonomy'], 'hide_empty=0');
					
					foreach ($terms as $term) {
					
						if (!is_wp_error($names) && !empty($names) && !strcmp($term->slug, $names[0]->slug)) {
					
							echo '<option value="' . $term->slug . '" selected>' . $term->name . '</option>';
					
						} else {
					
							echo '<option value="' . $term->slug . '  ' , $meta == $term->slug ? $meta : ' ' ,'  ">' . $term->name . '</option>';
					
						}
					
					}
					
					echo '</select>';
					echo '<p class="devlyMetaboxDescription">', $field['desc'], '</p>';
				break;
				
				// RADIO BUTTON FOR TAXONOMIES
				case 'taxonomy_radio':
					
					$names= wp_get_object_terms( $post->ID, $field['taxonomy'] );
					$terms = get_terms( $field['taxonomy'], 'hide_empty=0' );
					
					echo '<ul>';
					
					foreach ($terms as $term) {
					
						if (!is_wp_error($names) && !empty($names) && !strcmp($term->slug, $names[0]->slug)) {
					
							echo '<li><input type="radio" name="'.$field['id'].'" value="'. $term->slug . '" checked>' . $term->name . '</li>';
					
						} else {
					
							echo '<li><input type="radio" name="'.$field['id'].'" value="' . $term->slug . '  ' , $meta == $term->slug ? $meta : ' ' ,'  ">' . $term->name .'</li>';
					
						}
					
					}
					
					echo '</ul>';
					echo '<p class="devlyMetaboxDescription">', $field['desc'], '</p>';
				break;
				
				// MULTICHECK FOR TAXONOMIES
				case 'taxonomy_multicheck':
					
					echo '<ul>';
					
					$names = wp_get_object_terms( $post->ID, $field['taxonomy'] );
					$terms = get_terms( $field['taxonomy'], 'hide_empty=0' );
					
					foreach ($terms as $term) {
						
						echo '<li><input type="checkbox" name="', $field['id'], '[]" id="'.$field['id'].'" value="', $term->name , '"';
						
						foreach ($names as $name) {
						
							if ( $term->slug == $name->slug ){ echo ' checked="checked" ';};
						
						}
						
						echo ' /><label>', $term->name , '</label></li>';
					}
					
					echo '</ul>';
					echo '<span class="devlyMetaboxDescription">', $field['desc'], '</span>';
				break;
				
				// FILE LIST
				case 'file_list':
					
					echo '<input class="devlyFileUpload" type="text" size="36" name="'.$field['id'].'" value="" />';
					echo '<input class="devlyUploadButton button" type="button" value="Upload File" />';
					echo '<p class="devlyMetaboxDescription">', $field['desc'], '</p>';
					
						$args = array(
							'post_type' => 'attachment',
							'numberposts' => null,
							'post_status' => null,
							'post_parent' => $post->ID
						);
						
						$attachments = get_posts($args);
						
						if ($attachments) {
						
							echo '<ul class="attach_list">';
						
							foreach ($attachments as $attachment) {
								echo '<li>'.wp_get_attachment_link($attachment->ID, 'thumbnail', 0, 0, 'Download');
								echo '<span>';
								echo apply_filters('the_title', '&nbsp;'.$attachment->post_title);
								echo '</span></li>';
							}
						
							echo '</ul>';
						
						}
				break;
				
				// REGULAR FILE
				case 'file':
					
					$inputTypeURL = "hidden";
					
					if ('url' == $field['allow'] || (is_array($field['allow']) && in_array('url', $field['allow']))) {
						
						$inputTypeURL = "text";
						
					}
						
					echo '<input class="devlyFileUpload" type="' . $inputTypeURL . '" size="45" id="'.$field['id'].'" name="'.$field['id'].'" value="', $meta, '" />';
					echo '<input class="devlyUploadButton button" type="button" value="Upload File" />';
					echo '<input class="devlyFileUpload_id" type="hidden" id="', $field['id'], '_id" name="', $field['id'], '_id" value="', get_post_meta( $post->ID, $field['id'] . "_id",true), '" />';
					echo '<p class="devlyMetaboxDescription">', $field['desc'], '</p>';
					echo '<div id="', $field['id'], '_status" class="devlyMediaStatus">';
					
						if ($meta != '') {
							
							$checkImage = preg_match('/(^.*\.jpg|jpeg|png|gif|ico*)/i', $meta);
							
							if ($checkImage) {
							
								echo '<div class="img_status">';
								echo '<img src="', $meta, '" alt="" />';
								echo '<a href="#" class="devlyRemoveFileButton" rel="', $field['id'], '">Remove Image</a>';
								echo '</div>';
							
							} else {
								
								$parts = explode( '/', $meta );
								
								for( $i = 0; $i < count( $parts ); ++$i ) { $title = $parts[$i]; }
								
								echo 'File: <strong>', $title, '</strong>&nbsp;&nbsp;&nbsp; (<a href="', $meta, '" target="_blank" rel="external">Download</a> / <a href="#" class="devlyRemoveFileButton" rel="', $field['id'], '">Remove</a>)';
							
							}
						
						}
					echo '</div>';
				break;
				
				// OEMBED INPUT
				case 'oembed':
					
					echo '<input class="devlyOembed" type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="', '' !== $meta ? $meta : $field['std'], '" />','<p class="devlyMetaboxDescription">', $field['desc'], '</p>';
					echo '<p class="devlySpinner spinner"></p>';
					echo '<div id="', $field['id'], '_status" class="devlyMediaStatus ui-helper-clearfix embed_wrap">';
					
						if ($meta != '') {
					
							$checkEmbed = $GLOBALS['wp_embed']->run_shortcode('[embed]'. esc_url( $meta ) .'[/embed]');
					
							if ($checkEmbed) {
					
								echo '<div class="embedStatus">';
								echo $checkEmbed;
								echo '<a href="#" class="devlyRemoveFileButton" rel="', $field['id'], '">Remove Embed</a>';
								echo '</div>';
					
							} else {
					
								echo 'URL is not a valid oEmbed URL.';
					
							}
					
						}
					echo '</div>';
				break;
				
				// DEFAULT OUTPUT
				default:
					
					do_action('devly_render_' . $field['type'] , $field, $meta);
			
			}

			echo '</td>','</tr>';
		
		}
		
		echo '</table>';
	
	}

	function save($postID) {

		// VERIFY NONCE
		if (!isset($_POST['wp_meta_box_nonce']) || !wp_verify_nonce($_POST['wp_meta_box_nonce'], basename(__FILE__))) { return $postID; }

		// CHECK FOR AUTOSAVING
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $postID; }

		// MAKE SURE USER HAS PERMISSIONS
		if ('page' == $_POST['post_type']) {
			
			if (!current_user_can('edit_page', $postID)) {
		
				return $postID;
		
			}
		
		} elseif (!current_user_can('edit_post', $postID)) {
			
			return $postID;
		
		}

		foreach ($this->_meta_box['fields'] as $field) {
			
			$name = $field['id'];

			if (!isset($field['multiple'])) {
				
				$field['multiple'] = ('multicheck' == $field['type']) ? true : false;
				
			}

			$old = get_post_meta($postID, $name, !$field['multiple']);
			$new = isset( $_POST[$field['id']] ) ? $_POST[$field['id']] : null;
			
			// SAVE FOR TAXONOMIES
			if (in_array( $field['type'], array('taxonomy_select', 'taxonomy_radio', 'taxonomy_multicheck')))  {
				
				$new = wp_set_object_terms( $postID, $new, $field['taxonomy'] );
			
			}
			
			// SAVE FOR TEXTAREA(DON'T INTERPRET HTML)
			if (($field['type'] == 'textarea') || ($field['type'] == 'textarea_small')) {
				
				$new = htmlspecialchars( $new );
			
			}
			
			// SAVE FOR TEXTAREA(INTERPRET HTML)
			if (($field['type'] == 'textarea_code')) {
				
				$new = htmlspecialchars_decode( $new );
			
			}
			
			// SAVE FOR DATE + TIMESTAMP
			if ($field['type'] == 'text_date_timestamp') {
				
				$new = strtotime( $new );
			
			}
			
			// SAVE FOR DATE & TIME + TIMESTAMP
			if ($field['type'] == 'text_datetime_timestamp') {
				
				$string = $new['date'] . ' ' . $new['time'];
				$new 	= strtotime( $string );
			
			}
			
			$new = apply_filters('viz_validate_' . $field['type'], $new, $postID, $field);

			// VALIDATE METABOX VALUE IF NEED BE
			if (isset( $field['validate'])) {
				
				$ok = call_user_func(array('Visualyze_Validate_Metabox', $field['validate']), $new);
				
				if ($ok === false) {
				
					continue;
				
				}
			
			} elseif ($field['multiple']) {
				
				delete_post_meta($postID, $name);
				
				if (!empty( $new )) {
					
					foreach ( $new as $add_new ) {
					
						add_post_meta( $postID, $name, $add_new, false );
					
					}
				
				}
			
			} elseif ('' !== $new && $new != $old) {
				
				update_post_meta( $postID, $name, $new );
			
			} elseif ('' == $new) {
				
				delete_post_meta( $postID, $name );
			
			}

			if ('file' == $field['type']) {
				
				$name 	= $field['id'] . "_id";
				$old 	= get_post_meta( $postID, $name, !$field['multiple']);
				
				if (isset($field['save_id']) && $field['save_id']) {
					
					$new = isset( $_POST[$name] ) ? $_POST[$name] : null;
				
				} else {
					
					$new = "";
				
				}

				if ($new && $new != $old) {
					
					update_post_meta($postID, $name, $new);
				
				} elseif ( '' == $new && $old ) {
					
					delete_post_meta($postID, $name, $old);
				
				}
			
			}
		
		}
	
	}
	
	function addPostEnctype() {
		
		echo '
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery("#post").attr("enctype", "multipart/form-data");
				jQuery("#post").attr("encoding", "multipart/form-data");
			});
		</script>';
	
	}
	
	function restrictForID($display, $meta_box) {
		
		if ('id' !== $meta_box['show_on']['key']) {
			
			return $display;
			
		}
			

		// GET CURRENT ID SO WE CAN CHECK IF WE NEED TO DISPLAY
		if(isset( $_GET['post'])) {
			
			$postID = $_GET['post'];
			
		} elseif(isset($_POST['post_ID'])) {
			
			$postID = $_POST['post_ID'];
			
		} 
		
		
		if(!isset($postID)) { return false; }

		// IF GIVEN VALUE IS NOT AN ARRAY, MAKE IT ONE
		$meta_box['show_on']['value'] = !is_array($meta_box['show_on']['value']) ? array($meta_box['show_on']['value']) : $meta_box['show_on']['value'];

		// IF CURRENT PAGE ID IS INCLUDED IN THE "SHOW_ON" ARRAY, DISPLAY THE METABOX
		if (in_array($postID, $meta_box['show_on']['value'])) {
			
			return true;
		
		} else {
		
			return false;
		
		}


	}

	function restrictForTemplate($display, $meta_box) {
	
		if('page-template' !== $meta_box['show_on']['key']) { return $display; }

		// GET CURRENT ID SO WE CAN CHECK IF WE NEED TO DISPLAY
		if(isset($_GET['post'])) {
			
			$postID = $_GET['post'];
			
		} elseif(isset($_POST['post_ID'])) { 
		
			$postID = $_POST['post_ID'];
		
		}
		
		if(!(isset($postID) || is_page())) { return false; }

		// GET THE CURRENT PAGE TEMPLATE
		$currentTemplate = get_post_meta( $postID, '_wp_page_template', true );

		// IF GIVEN VALUE IS NOT AN ARRAY, MAKE IT ONE
		$meta_box['show_on']['value'] = !is_array($meta_box['show_on']['value']) ? array($meta_box['show_on']['value']) : $meta_box['show_on']['value'];

		// CHECK TO SEE IF THE CURRENT PAGE TEMPLATE IS FOUND IN THE "SHOW_ON" ARRAY
		if(in_array($currentTemplate, $meta_box['show_on']['value'])) {
		
			return true;
		
		} else {
			
			return false;
		
		}
	
	}

}

class Visualyze_Validate_Metabox {
	
	function check_text($text) {
	
		if ($text != 'hello') {
	
			return false;
	
		}
	
		return true;
	
	}
	
	// DEFINE VALIDATION METHODS HERE

}



$meta_boxes = array();

$meta_boxes = apply_filters('visualyze_metaboxes' , $meta_boxes);

foreach ($meta_boxes as $meta_box) {

	$my_box = new Visualyze_Metaboxes($meta_box);

}



/*
	
	Use the "Visualyze_Validate_Metabox" class to
	define any and all validation methods you'd
	like to run on specified metaboxes. Once
	you've written out your methods, you can
	call them on a per-metabox basis. An 
	example might look like this:
	
	$meta_boxes[] = array(
		'id'         => 'meta_box_id',
		'title'      => 'My Awesome Metabox',
		'pages'      => array('page'),
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true,
		'fields' => array(
			array(
				'name' 			=> 'Validate This Field',
				'desc' 			=> 'field description (optional)',
				'id'   			=> $prefix . 'test_text',
				'type' 			=> 'text',
				'validate' => 'check_text'
			),
			array(
				'name' => 'Don't Validate Text',
				'desc' => 'field description (optional)',
				'id'   => $prefix . 'test_text',
				'type' => 'text',
			),
		)
	);
	
*/



// END OF VIZ-METABOXES.PHP ?>