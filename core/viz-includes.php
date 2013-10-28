<?php if (!defined('ABSPATH')) exit; // EXIT IF DIRECTLY ACCESSED



// Get Visualyze Core up and running
require_once(TEMPLATEPATH . '/core/viz-config.php');

// The core functions for Visualyze
require_once(TEMPLATEPATH . '/core/viz-core.php');

// Custom login page functionality
require_once(TEMPLATEPATH . '/core/viz-login.php');

// Custom admin functionalities
require_once(TEMPLATEPATH . '/core/viz-admin.php');

// Default theme functionalities
require_once(TEMPLATEPATH . '/core/viz-theme.php');

// Helper functions provided Devly
require_once(TEMPLATEPATH . '/core/viz-helpers.php');

// Setup sample run of metaboxes on pages
require_once(TEMPLATEPATH . '/core/parts/metaboxes.php');

// Old Devly theme settings for reference
require_once(TEMPLATEPATH . '/core/panel/old-settings.php');



// END OF VIZ-INCLUDES.PHP ?>