<?php
/**
 * Configuration for the Clippy configuration screen.
 *
 * @package SonOfClippy
 * @author  Steve Grunwell
 */

namespace SonOfClippy\Settings;

use SonOfClippy\Core as Core;

/**
 * Register the "Office Assistant" settings within WordPress.
 */
function register_plugin_settings() {
	add_settings_field(
		'son_of_clippy_agent',
		__( 'Office Assistant', 'son-of-clippy' ),
		__NAMESPACE__ . '\render_agent_selection',
		'writing',
		'default'
	);
	register_setting(
		'writing',
		'son_of_clippy_agent',
		__NAMESPACE__ . '\validate_agent_selection'
	);
}
add_action( 'admin_init', __NAMESPACE__ . '\register_plugin_settings' );

/**
 * Render the agent selection setting.
 */
function render_agent_selection() {
	$val = get_option( 'son_of_clippy_agent', 'Clippy' );
?>

	<select name="son_of_clippy_agent" id="son_of_clippy_agent">
		<?php foreach ( Core\get_agents() as $agent ) : ?>

			<option value="<?php echo esc_attr( $agent ); ?>" <?php selected( $val, $agent ); ?>><?php echo esc_html( $agent ); ?></option>

		<?php endforeach; ?>
	</select>

<?php
}

/**
 * Validate the agent selected by the user.
 *
 * If an invalid agent is selected, the plugin will default to Clippy.
 *
 * @param string $agent The selected agent.
 * @return string The sanitized agent, checked against all available options.
 */
function validate_agent_selection( $agent ) {
	return in_array( $agent, Core\get_agents(), true ) ? $agent : 'Clippy';
}
