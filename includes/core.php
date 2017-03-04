<?php
/**
 * Plugin core functionality.
 *
 * @package SonOfClippy
 * @author  Steve Grunwell
 */

namespace SonOfClippy\Core;

/**
 * Enqueue scripts and styles used by Son of Clippy.
 */
function enqueue_assets() {
	$screen = get_current_screen();

	// Only enqueue assets on the post edit screen(s).
	if ( 'post' !== $screen->base ) {
		return;
	}

	// Enqueue scripts and styles.
	wp_enqueue_style(
		'son-of-clippy',
		CLIPPY_URL . 'assets/css/son_of_clippy.min.css',
		null,
		CLIPPY_VERSION
	);

	wp_enqueue_script(
		'son-of-clippy',
		CLIPPY_URL . 'assets/js/son_of_clippy.min.js',
		array( 'jquery' ),
		CLIPPY_VERSION,
		true
	);

	// Give Clippy all sorts of things to say.
	$user      = wp_get_current_user();
	$post_type = get_post_type_object( $screen->post_type );
	$config    = array(
		'agent' => get_option( 'son_of_clippy_agent', 'Clippy' ),
		'i18n'  => array(
			'consoleMessage' => __( 'You think your console will help you? Puny human, I am 90s incarnate!', 'son-of-clippy' ),
			'wantHelp'       => sprintf(
				/** Translators: %1$s is the user's name, %2$s is the post type. */
				__( '%1$s, it looks like you\'re trying to write a %2$s; want some help?', 'son-of-clippy' ),
				$user->user_firstname ? $user->user_firstname : $user->display_name,
				strtolower( $post_type->labels->singular_name )
			),
		),
	);

	/**
	 * Filters the JavaScript configuration for Clippy.
	 *
	 * @param array $config The current Clippy configuration.
	 */
	$config = apply_filters( 'son-of-clippy-args', $config );

	wp_localize_script( 'son-of-clippy', 'sonOfClippy', $config );
}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\enqueue_assets' );

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
