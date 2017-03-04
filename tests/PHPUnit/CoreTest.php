<?php
/**
 * Tests for the plugin core functionality.
 *
 * @package SonOfClippy
 * @author  Steve Grunwell
 */

namespace SonOfClippy\Core;

use WP_Mock as M;

class CoreTest extends \SonOfClippy\TestCase {

	protected $testFiles = array(
		'core.php',
	);

	public function testEnqueueAssets() {
		$screen = new \stdClass;
		$screen->base = 'post';
		$screen->post_type = 'post';

		$user = new \stdClass;
		$user->user_firstname = 'Eric';

		$post_type = new \stdClass;
		$post_type->labels = new \stdClass;
		$post_type->labels->singular_name = 'Post';

		M::userFunction( 'get_current_screen', array(
			'return' => $screen,
		) );

		M::userFunction( 'wp_get_current_user', array(
			'return' => $user,
		) );

		M::userFunction( 'get_post_type_object', array(
			'args'   => array( 'post' ),
			'return' => $post_type,
		) );

		M::userFunction( 'wp_enqueue_style', array(
			'times'  => 1,
			'args'   => array( 'son-of-clippy', '*', null, '*' ),
		) );

		M::userFunction( 'wp_enqueue_script', array(
			'times'  => 1,
			'args'   => array( 'son-of-clippy', '*', array( 'jquery' ), '*', true ),
		) );

		M::userFunction( 'get_option', array(
			'args'   => array( 'son_of_clippy_agent', 'Clippy' ),
			'return' => 'Clippy',
		) );

		M::userFunction( 'wp_localize_script', array(
			'times'  => 1,
			'args'   => array( 'son-of-clippy', 'sonOfClippy', '*' ),
		) );

		enqueue_assets();
	}

	public function testEnqueueAssetsReturnsEarlyIfNotOnPostEditScreen() {
		$screen = new \stdClass;
		$screen->base = 'something-else';

		M::userFunction( 'get_current_screen', array(
			'return' => $screen,
		) );

		$this->assertNull( enqueue_assets() );
	}

		public function testEnqueueAssetsFallsBackToUserDisplayName() {
		$screen = new \stdClass;
		$screen->base = 'post';
		$screen->post_type = 'post';

		$user = new \stdClass;
		$user->user_firstname = '';
		$user->display_name = 'admin';

		$post_type = new \stdClass;
		$post_type->labels = new \stdClass;
		$post_type->labels->singular_name = 'Post';

		M::userFunction( 'get_current_screen', array(
			'return' => $screen,
		) );

		M::userFunction( 'wp_get_current_user', array(
			'return' => $user,
		) );

		M::userFunction( 'get_post_type_object', array(
			'return' => $post_type,
		) );

		M::userFunction( 'wp_enqueue_style' );
		M::userFunction( 'wp_enqueue_script' );
		M::userFunction( 'get_option' );

		M::userFunction( 'wp_localize_script', array(
			'return' => function ( $script, $var, $config ) {
				$this->assertContains( 'admin', $config['i18n']['wantHelp'] );
			}
		) );

		enqueue_assets();
	}

	public function testGetAgents() {
		$agents = get_agents();

		$this->assertInternalType( 'array', $agents );
		$this->assertContains( 'Clippy', $agents );
	}

	public function testLoadTextdomain() {
		M::userFunction( 'load_plugin_textdomain', array(
			'times' => 1,
		) );

		M::passthruFunction( 'plugin_basename' );

		load_textdomain();
	}
}
