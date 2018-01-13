/*!
* Video Player Logo
*
* @author Code Parrots <support@codeparrots.com>
*/
( function( $ ) {

	var settings = window._wpmejsSettings || {};

	settings.features = settings.features || mejs.MepDefaults.features;

	settings.features.push( 'logo' );

	MediaElementPlayer.prototype.buildlogo = function( player, controls, layers, media ) {

		player.options.logo = {
			overlayLogo: 'https://images.freecreatives.com/wp-content/uploads/2015/04/logo033.png',
			toolbarLogo: 'http://www.maxxsouth.com/wp-content/themes/maxxSouth/images/footer/facebook-256.png',
			link:        'https://www.wp-timelineexpress.com',
		};

		if ( videoPlayerLogo.toolbar_logo ) {

			// Toolbar Logo.
			controls.append( '<div class="mejs-button mejs-toolbar-logo-button"><button type="button" class="mejs-logo" style="background: url(\'' + videoPlayerLogo.toolbar_logo + '\');" aria-controls="mep_0" title="Logo" aria-label="Logo" tabindex="0"></button></div>' );

		}

		if ( videoPlayerLogo.overlay_logo ) {

			// Overlay Logo.
			player.container.append( '<div class="mejs-overlay-logo ' + videoPlayerLogo.overlay_location + '"><img src="' + videoPlayerLogo.overlay_logo + '"/></div>' );

		}

		$( 'body' ).on( 'click', '.mejs-overlay-logo', function() {

			window.open( player.options.logo.link, '_blank' );

		} );

		$( 'body' ).on( 'click', '.mejs-logo', function() {

			window.open( player.options.logo.link, '_blank' );

		} );

	};

} )( jQuery );
