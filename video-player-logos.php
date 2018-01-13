<?php
/*
 * Plugin Name: Video Player Logos
 * Plugin URI:  https://github.com/CodeParrots/video-player-logos
 * Description: Add a custom logo to the WordPress media player and media player toolbar.
 * Author:      Code Parrots
 * Author URI:  https://www.codeparrots.com
 * Version:     1.0.0
 * Text Domain: video-player-logos
 * License:     GPL v2 or later
 */

class CP_Video_Player_Logos {

	public static $version = '1.0.0';

	public $options = [
		'overlay_logo'     => '',
		'overlay_location' => 'top-left',
		'toolbar_logo'     => '',
	];

	public function __construct() {

		add_action( 'admin_init', [ $this, 'media_settings' ] );

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

	}

	public function media_settings() {

		$this->options = get_option( 'video_player_logo', $this->options );

		/* Register Settings */
		register_setting(
			'media',
			'video_player_logo',
			function( $input ) {

				$input['overlay_logo']     = isset( $input['overlay_logo'] ) ? esc_url( $input['overlay_logo'] ) : '';
				$input['overlay_location'] = isset( $input['overlay_location'] ) ? sanitize_text_field( $input['overlay_location'] ) : 'top-left';
				$input['toolbar_logo']     = isset( $input['toolbar_logo'] ) ? esc_url( $input['toolbar_logo'] ) : '';

				return $input;

			}
		);

		add_settings_section(
			'cp-video-player',
			esc_html__( 'Video Player', 'video-player-logos' ),
			function() {
				echo wpautop( __( 'Customize the video player globally on your site.', 'video-player-logos' ) );
			},
			'media'
		);

		add_settings_field(
			'overlay_logo',
			esc_html__( 'Video Player Overlay Logo', 'video-player-logos' ),
			function() {
				?>
				<label for="overlay_logo">
					<input id="overlay_logo" type="text" value="<?php echo $this->options['overlay_logo']; ?>" name="video_player_logo[overlay_logo]" class="widefat" />
				</label>
				<p class="description"><?php esc_html_e( 'Enter the URL to the image you would like to display in the video player.', 'video-player-logos' ); ?></p>
				<?php
			},
			'media',
			'cp-video-player'
		);

		add_settings_field(
			'overlay_location',
			esc_html__( 'Video Player Overlay Logo Location', 'video-player-logos' ),
			function() {
				?>
				<label for="overlay_location-1">
					<input id="overlay_location-1" type="radio" value="top-left" name="video_player_logo[overlay_location]" <?php checked( $this->options['overlay_location'], 'top-left' ); ?>>
					<?php esc_html_e( 'Top Left', 'video-player-logos' ); ?>
				</label>&nbsp;
				<label for="overlay_location-2">
					<input id="overlay_location-2" type="radio" value="top-right" name="video_player_logo[overlay_location]" <?php checked( $this->options['overlay_location'], 'top-right' ); ?>>
					<?php esc_html_e( 'Top Right', 'video-player-logos' ); ?>
				</label>&nbsp;
				<label for="overlay_location-3">
					<input id="overlay_location-3" type="radio" value="bottom-left" name="video_player_logo[overlay_location]" <?php checked( $this->options['overlay_location'], 'bottom-left' ); ?>>
					<?php esc_html_e( 'Bottom Left', 'video-player-logos' ); ?>
				</label>&nbsp;
				<label for="overlay_location-4">
					<input id="overlay_location-4" type="radio" value="bottom-right" name="video_player_logo[overlay_location]" <?php checked( $this->options['overlay_location'], 'bottom-right' ); ?>>
					<?php esc_html_e( 'Bottom Right', 'video-player-logos' ); ?>
				</label>&nbsp;
				<label for="overlay_location-5">
					<input id="overlay_location-5" type="radio" value="center" name="video_player_logo[overlay_location]" <?php checked( $this->options['overlay_location'], 'center' ); ?>>
					<?php esc_html_e( 'Center', 'video-player-logos' ); ?>
				</label>
				<p class="description"><?php esc_html_e( 'Select the location of the video player overlay logo.', 'video-player-logos' ); ?></p>
				<?php
			},
			'media',
			'cp-video-player'
		);

		add_settings_field(
			'toolbar_logo',
			esc_html__( 'Video Player Toolbar Logo', 'video-player-logos' ),
			function() {
				?>
				<label for="toolbar_logo">
					<input id="toolbar_logo" type="text" value="<?php echo $this->options['toolbar_logo']; ?>" name="video_player_logo[toolbar_logo]" class="widefat" />
				</label>
				<p class="description"><?php esc_html_e( 'Enter the URL to the image you would like to display in the video player toolbar.', 'video-player-logos' ); ?></p>
				<?php
			},
			'media',
			'cp-video-player'
		);

	}

	/**
	 * Enqueue the scripts and styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'video-player-logos', plugin_dir_url( __FILE__ ) . '/assets/js/video-player-logo.js', [ 'jquery', 'wp-mediaelement' ], self::$version, true );
		wp_localize_script( 'video-player-logos', 'videoPlayerLogo', apply_filters( 'video-player-logos', get_option( 'video_player_logo', $this->options ) ) );

		wp_enqueue_style( 'video-player-logos', plugin_dir_url( __FILE__ ) . '/assets/css/video-player-logo.css', [ 'wp-mediaelement' ], self::$version, 'all' );

	}

}

new CP_Video_Player_Logos();
