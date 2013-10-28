<?php



// =========================================================================
// ====== Get Visualyze Core up and running - DO NOT REMOVE
// =========================================================================

require_once('core/viz-includes.php');



// =========================================================================
// ====== Build Visualyze sample metaboxes - core/parts/metaboxes.php
// =========================================================================

add_filter('visualyze_metaboxes', 'vizSampleMetaboxes');



// =========================================================================
// ====== Uncomment and edit lines below for custom image sizes
// =========================================================================

//add_image_size('viz_header', 1200, 480, true);
//add_image_size('viz_large', 720, 300, true);
//add_image_size('viz_medium', 400, 150, true);
//add_image_size('viz_thumb', 210, 100, true);



// =========================================================================
// ====== Define any custom theme functionality here
// =========================================================================



// END FUNCTIONS.PHP ?>