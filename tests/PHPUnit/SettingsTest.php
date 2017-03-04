<?php
/**
 * Tests for the plugin settings.
 *
 * @package SonOfClippy
 * @author  Steve Grunwell
 */

namespace SonOfClippy\Settings;

use WP_Mock as M;

class SettingsTest extends \SonOfClippy\TestCase {

	protected $testFiles = array(
		'settings.php',
	);

	public function testRegisterPluginSettings() {
		M::userFunction( 'add_settings_field', array(
			'times' => 1,
			'args'  => array(
				'son_of_clippy_agent',
				'*',
				__NAMESPACE__ . '\render_agent_selection',
				'writing',
				'default',
			),
		) );

		M::userFunction( 'register_setting', array(
			'times' => 1,
			'args'  => array( 'writing', 'son_of_clippy_agent', __NAMESPACE__ . '\validate_agent_selection' ),
		) );

		register_plugin_settings();
	}

	public function testRenderAgentSelection() {
		M::userFunction( 'get_option', array(
			'args'   => array( 'son_of_clippy_agent', 'Clippy' ),
			'return' => 'Clippy',
		) );

		M::userFunction( 'SonOfClippy\Core\get_agents', array(
			'return' => array( 'Foo', 'Clippy' ),
		) );

		M::userFunction( 'selected', array(
			'return' => function ( $val1, $val2 ) {
				echo $val1 === $val2 ? 'selected' : '';
			}
		) );

		ob_start();
		render_agent_selection();
		$result = ob_get_contents();
		ob_end_clean();

		$this->assertContains( '<option value="Foo" >Foo</option>', $result );
		$this->assertContains( '<option value="Clippy" selected>Clippy</option>', $result );
	}

	public function testValidateAgentSelection() {
		M::userFunction( 'SonOfClippy\Core\get_agents', array(
			'return' => array( 'Foo', 'Bar' ),
		) );

		$this->assertEquals( 'Foo', validate_agent_selection( 'Foo' ) );
	}

	public function testValidateAgentSelectionDefaultsToClippy() {
		M::userFunction( 'SonOfClippy\Core\get_agents', array(
			'return' => array( 'Foo', 'Bar' ),
		) );

		$this->assertEquals( 'Clippy', validate_agent_selection( 'Baz' ) );
	}
}
