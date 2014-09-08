<?php
// Loading the test environment, we identify the path to the expected default bootstrap.php
$path = dirname( __FILE__ ) . '/tests/phpunit/includes/bootstrap.php';

// We check if the path is valid, if so then we can define globals and proceed.
if ( file_exists( $path ) ) {
	
	// activation of theme or plugins would happen here, at this point you can define
	// $GLOBALS['wp_tests_options'] = array() 
	// the array contains key/value pairs such as:
	//
	// 'active_plugins' => array( 'wp-iron-io/wp-iron-io.php' )
	
	// Make sure this is the last line, as the environment will now initialize
	require_once $path;
} else {
	// Unable to load the default bootstrap.php file.
	exit( 'Unable to locate the core bootstrap.php, have you included the svn repository from http://develop.svn.wordpress.org/trunk/ ?' );
}