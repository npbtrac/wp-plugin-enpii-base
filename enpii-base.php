<?php
/**
 * Plugin Name: Enpii Base
 * Description: The Base plugin for Theme and Plugin development. It requires ACF pro to work.
 * Version: 0.0.1
 * Author: Enpii
 * Author URI: http://www.enpii.com/wordpress-plugin-enpii-base
 * License: GPLv2 or later
 * Text Domain: enpii
 * Domain Path: /languages/
 */

use Enpii\Wp\EnpiiBase\Base\WpApp as WpApp;

defined( 'ENPII_BASE_PLUGIN_VER' ) || define( 'ENPII_BASE_PLUGIN_VER', 0.2 );
defined( 'ENPII_BASE_PLUGIN_FOLDER_NAME' ) || define( 'ENPII_BASE_PLUGIN_FOLDER_NAME', 'enpii-base' );
defined( 'ENPII_BASE_PLUGIN_URL' ) || define( 'ENPII_BASE_PLUGIN_URL', plugins_url( ENPII_BASE_PLUGIN_FOLDER_NAME ) );
defined( 'ENPII_BASE_PLUGIN_PATH' ) || define( 'ENPII_BASE_PLUGIN_PATH', __DIR__ );
defined( 'ENPII_BASE_PLUGIN_ASSETS_URL' ) || define( 'ENPII_BASE_PLUGIN_ASSETS_URL', plugins_url( ENPII_BASE_PLUGIN_FOLDER_NAME ) . DIRECTORY_SEPARATOR . 'assets' );

class EnpiiBase {
	public static $text_domain = 'enpii';

	static function activate() {
		// do not generate any output
	}

	static function get_default_config() {
		$config = [
			'id'         => 'enpii-base',
			'basePath'   => WP_CONTENT_DIR,
			'components' => [
				'wp_theme'    => [
					'class'           => \Enpii\Wp\EnpiiBase\Component\WpTheme::class,
					'version'         => '0.01',
					'text_domain'     => 'enpii',
					'use_cdn'         => false,
					'base_path'       => get_template_directory(),
					'base_url'        => get_template_directory_uri(),

					// only set when child theme using
					'child_base_path' => get_template_directory() === get_stylesheet_directory() ? null : get_stylesheet_directory(),
					'child_base_url'  => get_template_directory_uri() === get_stylesheet_directory_uri() ? null : get_stylesheet_directory_uri(),
				],
			],
		];

		return $config;
	}

	/**
	 * Init the Application after WordPress loaded
	 */
	static function init_app() {
		WpApp::load_config( static::get_default_config() );

		// If a theme is being used
		if ( defined( 'WP_USE_THEMES' ) && WP_USE_THEMES ) {
			$child_theme_config_file_path = get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'enpii-config.php';
			$main_theme_config_file_path  = get_template_directory() . DIRECTORY_SEPARATOR . 'enpii-config.php';

			if ( ( $main_theme_config_file_path !== $child_theme_config_file_path ) && file_exists( $child_theme_config_file_path ) ) {
				WpApp::load_config( require( $child_theme_config_file_path ) );
			}

			if ( file_exists( $main_theme_config_file_path ) ) {
				WpApp::load_config( require( $main_theme_config_file_path ) );
			}
		}
		WpApp::initialize();
	}
}

register_activation_hook( __FILE__, array( 'EnpiiBase', 'activate' ) );

// After WP fully loaded and before handling request
add_action( 'plugins_loaded', [ 'EnpiiBase', 'init_app' ] );



