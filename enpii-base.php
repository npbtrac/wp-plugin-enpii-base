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

use Enpii\Wp\EnpiiBase\Wp as Wp;
use Enpii\Wp\EnpiiBase\Base\WebApp as WpApp;

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
		$config       = [
			'id' => 'enpii-base',
			'basePath' => WP_CONTENT_DIR,
			'components' => [

			],
		];

		return $config;
	}

	/**
	 * Init the Application after WordPress loaded
	 */
	static function init_app() {
		Wp::load_config(static::get_default_config());

		WpApp::initialize(Wp::$config);
	}
}

register_activation_hook( __FILE__, array( 'EnpiiBase', 'activate' ) );

// After WP fully loaded and before handling request
add_action( 'wp_loaded', ['EnpiiBase', 'init_app'] );



