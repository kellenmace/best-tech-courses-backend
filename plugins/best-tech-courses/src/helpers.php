<?php

namespace BestTechCourses;

require_once ABSPATH . 'wp-admin/includes/plugin.php';

/**
 * Get the absolute path to this plugin's root directory, with
 * trailing slash.
 *
 * @return string The path.
 */
function get_plugin_dir() {
	return trailingslashit( WP_PLUGIN_DIR ) . trailingslashit( get_plugin_dir_name() );
}

/**
 * Get the URL to this plugin's root directory, with trailing slash.
 *
 * @return string The URL.
 */
function get_plugin_url() {
	return trailingslashit( plugins_url( get_plugin_dir_name() ) );
}

/**
 * Get the name of this plugin's root directory.
 *
 * @return string Directory name on empty string on failure.
 */
function get_plugin_dir_name() {
	$basename       = plugin_basename( __FILE__ );
	$basename_parts = explode( '/', $basename );

	if ( $basename_parts ) {
		return $basename_parts[0];
	}

	return '';
}
