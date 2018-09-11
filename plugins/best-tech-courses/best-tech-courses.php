<?php
/**
 * Plugin Name: Best Tech Courses
 * Description: Best Tech Courses core plugin
 * Version:     1.0.0
 * Author:      Kellen Mace
 * Author URI:  https://kellenmace.com/
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

$autoload = plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

// If dependencies not found, deactivate plugin and return early.
if ( ! is_readable( $autoload ) ) {
	add_action( 'admin_init', function() {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	} );
	return;
}

require_once $autoload;

( new BestTechCourses\BestTechCourses() )->run();
