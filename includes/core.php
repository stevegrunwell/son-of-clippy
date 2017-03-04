<?php
/**
 * Plugin core functionality.
 *
 * @package SonOfClippy
 * @author  Steve Grunwell
 */

namespace SonOfClippy\Core;

/**
 * Retrieve all available agents.
 *
 * @return array An array of all agents available via Clippy.js.
 */
function get_agents() {
	return array(
		'Bonzi',
		'Clippy',
		'F1',
		'Genie',
		'Genius',
		'Links',
		'Merlin',
		'Peedy',
		'Rocky',
		'Rover',
	);
}

/**
 * Load the plugin textdomain.
 */
function load_textdomain() {
	load_plugin_textdomain( 'son-of-clippy', false, plugin_basename( dirname( __DIR__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\load_textdomain' );
