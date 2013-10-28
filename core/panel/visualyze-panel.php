<?php if (!defined('ABSPATH')) exit; // EXIT IF DIRECTLY ACCESSED


$viz_panels = array();
$viz_panels = apply_filters('visualyze_options' , $viz_panels);

foreach ($viz_panels as $panel) {

	$my_panel = new Visualyze_Panel($panel);

}



class Visualyze_Panel {
	
	// Array of options to build panel
	protected $_panel;
	
	// Array of saved options
	protected $_saved;
	
	// Options group from database
	protected $_group;
	
	// Array of fields for panel
	protected $_fields;
	
	// Array of any thrown errors
	public $errors = array();
	
	// Setup flags variables
	public $savedFlag = false;
	public $errorFlag = false;


	// Get things up and running
	function __construct($panel) {
		
		if(!is_admin()) { return; }
		
		global $pagenow, $visualyze;
		
		$this->_panel = $panel;
		
	}
	
	
	public function parseTabs() {
		
		$tabs = $this->_panel;
		
		foreach($this->_panel as $panel) {
			
			echo '<a id="'.$panel['id'].'" href="javascript:void(0)">'.$panel['title'].'</a>';
			
		}
		
	}
	
	public function parsePanel() {
		
		
		
	}
	
	public function saveOptions() {
		
		
		
	}

}













