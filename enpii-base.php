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

defined( 'ENPII_BASE_PLUGIN_VER' ) || define( 'ENPII_BASE_PLUGIN_VER', 0.2 );
defined( 'ENPII_BASE_PLUGIN_FOLDER_NAME' ) || define( 'NP_PLUGIN_CORE_NAME', 'enpii-core' );
defined( 'ENPII_BASE_PLUGIN_URL' ) || define( 'ENPII_BASE_PLUGIN_URL', plugins_url( NP_PLUGIN_CORE_NAME ) );
defined( 'ENPII_BASE_PLUGIN_PATH' ) || define( 'ENPII_BASE_PLUGIN_PATH', __DIR__ );
defined( 'ENPII_BASE_PLUGIN_ASSETS_URL' ) || define( 'ENPII_BASE_PLUGIN_ASSETS_URL', plugins_url( NP_PLUGIN_CORE_NAME ) . DIRECTORY_SEPARATOR . 'assets' );

! file_exists(__DIR__ . "/vendor/autoload.php") || require_once (__DIR__ . "/vendor/autoload.php");

class EnpiiBase {
	public static $text_domain = 'enpii';

	static function activate() {
		// do not generate any output

		// Require ACF pro
		$plugin = 'advanced-custom-fields-pro/acf.php';
		if ( ! is_plugin_active( $plugin ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			die( __( 'Enpii Base plugin requires ACF pro', _NP_TEXT_DOMAIN ) );
		}
	}
}

register_activation_hook( __FILE__, array( 'EnpiiBase', 'activate' ) );



