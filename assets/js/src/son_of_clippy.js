/**
 * Son of Clippy
 *
 * Copyright (c) 2014 Steve Grunwell
 * Licensed under the GPLv2+ license.
 */

jQuery( function( $ ) {
	'use strict';

	clippy.load(sonOfClippy.agent, function ( agent ) {
		agent.show();

		agent.speak( sonOfClippy.i18n.wantHelp );
		if ( 'undefined' !== console ) {
			console.warn( sonOfClippy.i18n.consoleMessage );
		}

		// Actions
		$(document).on( 'before-autosave', function () {
			agent.play( 'Save' );
		} );

	} );
} );