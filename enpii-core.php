<?php
/**
 * Plugin Name: Enpii Core
 * Created by PhpStorm.
 * User: lacphan
 * Date: 2/19/16
 * Time: 2:19 PM
 */
defined( 'NP_PLUGIN_CORE_VER' ) || define( 'NP_PLUGIN_CORE_VER', 0.2 );
defined( 'NP_PLUGIN_CORE_NAME' ) || define( 'NP_PLUGIN_CORE_NAME', 'enpii-core' );
defined( 'NP_ENPII_URL' ) || define( 'NP_ENPII_URL', plugins_url( NP_PLUGIN_CORE_NAME ) );
defined( 'NP_ENPII_PATH' ) || define( 'NP_ENPII_PATH', __DIR__ );
defined( 'NP_ASSETS_URL' ) || define( 'NP_ASSETS_URL', plugins_url( NP_PLUGIN_CORE_NAME ) . DIRECTORY_SEPARATOR . 'assets' );
require_once __DIR__ . "/vendor/autoload.php";

class EnpiiCore {
	public static $text_domain = 'enpii';

	static function activate() {
		// do not generate any output

		// Require ACF pro
		$plugin = 'advanced-custom-fields-pro/acf.php';
		if ( ! is_plugin_active( $plugin ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			die( __( 'Enpii Core requires ACF pro', _NP_TEXT_DOMAIN ) );
		} else {
		}

	}
}

register_activation_hook( __FILE__, array( 'EnpiiCore', 'activate' ) );



