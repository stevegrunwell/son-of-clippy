<?php
/**
 * Bootstrap the test suite.
 *
 * @package SonOfClippy
 * @author  Steve Grunwell
 */

if ( ! defined( 'PROJECT' ) ) {
	define( 'PROJECT', __DIR__ . '/../' );
}

if ( ! file_exists( __DIR__ . '/../vendor/autoload.php' ) ) {
	throw new PHPUnit_Framework_Exception(
		'ERROR: You must use Composer to install the test suite\'s dependencies!' . PHP_EOL
	);
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/test-tools/TestCase.php';

WP_Mock::bootstrap();

require_once PROJECT . 'son_of_clippy.php';

WP_Mock::tearDown();
