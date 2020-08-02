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

//use Enpii\Wp\EnpiiBase\Libs\WpApp;
//
//defined( 'ENPII_BASE_PLUGIN_VER' ) || define( 'ENPII_BASE_PLUGIN_VER', 0.3 );
//defined( 'ENPII_BASE_PLUGIN_PATH' ) || define( 'ENPII_BASE_PLUGIN_PATH', __DIR__ );
//defined( 'ENPII_BASE_PLUGIN_FOLDER_NAME' ) || define( 'ENPII_BASE_PLUGIN_FOLDER_NAME', 'enpii-base' );
//defined( 'ENPII_BASE_PLUGIN_URL' ) || define( 'ENPII_BASE_PLUGIN_URL', plugins_url( null, ENPII_BASE_PLUGIN_PATH ) );
//
//// Use autoload if Laravel not loaded
//if ( ! class_exists( \Illuminate\Foundation\Application::class ) ) {
//	require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
//}
//
//if ( ! function_exists( 'enpii_base_init_wp_app_config' ) ) {
//	/**
//	 * Apply a global Application instance when all plugins, theme loaded and user authentication applied
//	 */
//	function enpii_base_init_wp_app_config() {
//		$config_file_path = ENPII_BASE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'wp-app.php';
//		$config           = file_exists( $config_file_path ) ? require_once( $config_file_path ) : [];
//
//		return apply_filters( 'enpii-base/wp-app-config', $config );
//	}
//}
//
//if ( ! function_exists( 'enpii_base_init_wp_app' ) ) {
//	/**
//	 * Get application instance
//	 */
//	function enpii_base_init_wp_app() {
//		$wp_app = require ENPII_BASE_PLUGIN_PATH . '/bootstrap/app.php';
//	}
//}
//add_action( 'muplugins_loaded', 'enpii_base_init_wp_app', 100 );
//
//if ( ! function_exists( 'enpii_base_setup_wp_app_for_theme' ) ) {
//	/**
//	 * Make Laravel view paths working with WordPress theme system
//	 */
//	function enpii_base_setup_wp_app_for_theme() {
//		WpApp::getInstance()->setWpThemeViewPaths();
//	}
//}
//add_action( 'after_setup_theme', 'enpii_base_setup_wp_app_for_theme', 10 );
