<?php
/**
 * Plugin Name: Son of Clippy
 * Plugin URI:  http://wordpress.org/plugins
 * Description: Add "fun" animated characters to your WordPress edit screens!
 * Version:     0.1.0
 * Author:      Steve Grunwell
 * Author URI:  http://stevegrunwell.com
 * License:     GPLv2+
 * Text Domain: clippy
 * Domain Path: /languages
 */

// Useful global constants
define( 'CLIPPY_VERSION', '0.1.0' );
define( 'CLIPPY_URL',     plugin_dir_url( __FILE__ ) );
define( 'CLIPPY_PATH',    dirname( __FILE__ ) . '/' );

/**
 * Default initialization for the plugin:
 * - Registers the default textdomain.
 * - Registers scripts and styles.
 */
function clippy_init() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'clippy' );
	load_textdomain( 'clippy', WP_LANG_DIR . '/clippy/clippy-' . $locale . '.mo' );
	load_plugin_textdomain( 'clippy', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

/**
 * Register scripts and styles used by the plugin.
 *
 * If the current page is the the post editor, Clippy will be enqueued.
 */
function clippy_register_assets() {
	$screen = get_current_screen();

	wp_register_style( 'son-of-clippy', CLIPPY_URL . 'assets/css/son_of_clippy.min.css', null, CLIPPY_VERSION );
	wp_register_script( 'son-of-clippy', CLIPPY_URL . 'assets/js/son_of_clippy.min.js', array( 'jquery' ), CLIPPY_VERSION, true );

	if ( is_admin() && 'post' === $screen->base ) {
		wp_enqueue_style( 'son-of-clippy' );
		wp_enqueue_script( 'son-of-clippy' );
	}
}

// Wireup actions
add_action( 'admin_init', 'clippy_init' );
add_action( 'admin_enqueue_scripts', 'clippy_register_assets' );