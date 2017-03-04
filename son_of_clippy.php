<?php
/**
 * Plugin Name: Son of Clippy
 * Plugin URI:  https://github.com/stevegrunwell/son-of-clippy
 * Description: Add "fun" animated characters to your WordPress edit screens!
 * Version:     0.1.0
 * Author:      Steve Grunwell
 * Author URI:  http://stevegrunwell.com
 * License:     GPLv2+
 * Text Domain: son-of-clippy
 * Domain Path: /languages
 */

// Useful global constants
define( 'CLIPPY_VERSION', '0.1.0' );
define( 'CLIPPY_URL',     plugin_dir_url( __FILE__ ) );

require_once __DIR__ . '/includes/core.php';
require_once __DIR__ . '/includes/settings.php';
