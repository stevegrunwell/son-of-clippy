<?php
/**
 * Plugin core functionality.
 *
 * @package SonOfClippy
 * @author  Steve Grunwell
 */

namespace SonOfClippy\Core;

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
