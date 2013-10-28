<?php if (!defined('ABSPATH')) exit; // EXIT IF DIRECTLY ACCESSED



function vizLoginCSS() { 

	echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/core/assets/css/login.css">'; 
	
}

function vizEmailLogin($username) {
	
	$user = get_user_by('email', $username);
	
	if(!empty($user->user_login))
		
		$username = $user->user_login;
	
	return $username;

}



// END OF DEVLY ADMIN.PHP FILE ?>