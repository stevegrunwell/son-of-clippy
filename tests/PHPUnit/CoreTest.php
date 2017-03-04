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

	public function testGetAgents() {
		$agents = get_agents();

		$this->assertInternalType( 'array', $agents );
		$this->assertContains( 'Clippy', $agents );
	}
}
