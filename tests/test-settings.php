<?php
/**
 * Tests for the plugin settings.
 *
 * @package SonOfClippy
 */

namespace Tests;

use SonOfClippy\Core as Core;
use SonOfClippy\Settings as Settings;
use SteveGrunwell\PHPUnit_Markup_Assertions\MarkupAssertionsTrait;
use WP_UnitTestCase;

/**
 * Tests for includes/settings.php.
 */
class SettingsTest extends WP_UnitTestCase {
	use MarkupAssertionsTrait;

	public function test_register_plugin_settings() {
		global $wp_settings_fields;

		Settings\register_plugin_settings();

		$this->assertArrayHasKey( 'son_of_clippy_agent', $wp_settings_fields['writing']['default'] );
		$this->assertArrayHasKey( 'son_of_clippy_agent', get_registered_settings() );
	}

	public function test_render_agent_selection() {
		$agents = Core\get_agents();

		ob_start();
		Settings\render_agent_selection();
		$output = ob_get_clean();

		$this->assertContainsSelector( 'select[name="son_of_clippy_agent"]', $output );
		$this->assertSelectorCount( count( $agents ), 'option', $output, 'Every agent should be represented.' );
	}

	public function test_render_agent_selection_selects_current_agent() {
		$agent = Core\get_agents()[4]; // Anyone but Clippy.
		update_option( 'son_of_clippy_agent', $agent );

		$this->assertNotEquals( 'Clippy', $agent, 'The whole point of the test is to *not* use Clippy.' );

		ob_start();
		Settings\render_agent_selection();
		$output = ob_get_clean();

		$this->assertHasElementWithAttributes( [
			'value'    => $agent,
			'selected' => 'selected',
		], $output );
	}

	public function test_validate_agent_selection() {
		$this->assertEquals( 'Merlin', Settings\validate_agent_selection( 'Merlin' ) );
		$this->assertEquals( 'Rover', Settings\validate_agent_selection( 'Rover' ) );
		$this->assertEquals(
			'Clippy',
			Settings\validate_agent_selection( 'Not Clippy' ),
			'If an unrecognized agent is selected, fall back to Clippy.'
		);
	}
}
