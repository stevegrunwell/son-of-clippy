<?php
/**
 * Tests for the core plugin functionality.
 *
 * @package SonOfClippy
 */

namespace Tests;

use SonOfClippy\Core as Core;
use WP_UnitTestCase;

/**
 * Tests for includes/core.php.
 */
class CoreTest extends WP_UnitTestCase {

	/**
	 * Unenqueue scripts after each test.
	 *
	 * @after
	 */
	public function dequeue_assets() {
		wp_dequeue_script( 'son-of-clippy' );
		wp_deregister_script( 'son-of-clippy' );

		wp_dequeue_style( 'son-of-clippy' );
		wp_deregister_style( 'son-of-clippy' );
	}

	/**
	 * @dataProvider admin_page_url_provider()
	 */
	public function test_enqueue_assets_only_load_on_certain_pages( $url, $should_enqueue ) {
		set_current_screen( $url );

		do_action( 'admin_enqueue_scripts' );

		$this->assertEquals( $should_enqueue, wp_script_is( 'son-of-clippy', 'enqueued' ) );
		$this->assertEquals( $should_enqueue, wp_style_is( 'son-of-clippy', 'enqueued' ) );
	}

	public function admin_page_url_provider() {
		return [
			'Post creation screen' => [ 'post-new.php', true ],
			'Post edit screen'     => [ 'post.php', true ],
			'Edit taxonomy term'   => [ 'edit-tags.php', false ],
			'Upload screen'        => [ 'upload.php', false ],
		];
	}

	public function test_enqueue_assets_localizes_script() {
		set_current_screen( 'post.php' );

		Core\enqueue_assets();

		// Retrieve the localization, strip it down to the JSON, and parse it.
		$data = wp_scripts()->get_data( 'son-of-clippy', 'data' );
		$data = preg_replace( '/^[^}]+({.+});$/U', '$1', $data );
		$data = json_decode( $data, true );

		$this->assertArrayHasKey( 'agent', $data, 'The current agent name should be localized.' );
		$this->assertArrayHasKey( 'i18n', $data, 'The localization object should contain localization strings.' );
	}

	public function test_get_agents() {
		$agents = Core\get_agents();

		$this->assertContains( 'Clippy', $agents, 'Clippy is the O.G. and must be present.' );
		$this->assertContains( 'Merlin', $agents, 'No Merlin? No peace.' );
		$this->assertContains( 'Rocky', $agents, ':Plays "Eye of the Tiger":' );
	}
}
