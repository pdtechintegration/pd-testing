<?php

/**
 * CI-Theme tests
 *
 * @package ci-theme-tests
 */
class CI_Theme_WordPress_Theme_Tests extends WP_UnitTestCase {
	
	/**
	 * Run a simple test to ensure that the testing environment is running
	 */
	 function test_tests() {
		$this->assertTrue( true );
	 }
	
	/**
	 * If these tests are being run on Travis CI, verify that the version of
	 * WordPress installed is the version that we requested.
	 * 
	 * Code here courtesy of solution from Ben Balter ( https://github.com/benbalter )
	 * Though it has been modified to use Wordpress SVN instead of the github repo
	 *
	 */
	function test_wp_version() {
		
		if ( ! getenv( 'TRAVIS' ) )
			$this->markTestSkipped( 'Test skipped since Travis CI was not detected.' );
		
		$requested_version = getenv( 'WP_VERSION' ) . '-src';
		
		// The "master" version requires special handling.
		if ( $requested_version == 'master-src' ) {
			$file = file_get_contents( 'http://develop.svn.wordpress.org/trunk/src/wp-includes/version.php' );
			preg_match( '#\$wp_version = \'([^\']+)\';#', $file, $matches );
			$requested_version = $matches[1];
		}
		
		$this->assertEquals( get_bloginfo( 'version' ), $requested_version );
	}
	

}