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

use Enpii\Wp\EnpiiBase\Libs\WpApp;
use Enpii\Wp\EnpiiBase\Helpers\ArrayHelper;

defined( 'ENPII_BASE_PLUGIN_VER' ) || define( 'ENPII_BASE_PLUGIN_VER', 0.3 );
defined( 'ENPII_BASE_PLUGIN_PATH' ) || define( 'ENPII_BASE_PLUGIN_PATH', __DIR__ );
defined( 'ENPII_BASE_PLUGIN_FOLDER_NAME' ) || define( 'ENPII_BASE_PLUGIN_FOLDER_NAME', 'enpii-base' );
defined( 'ENPII_BASE_PLUGIN_URL' ) || define( 'ENPII_BASE_PLUGIN_URL', plugins_url( null, ENPII_BASE_PLUGIN_PATH ) );

if ( ! class_exists( Illuminate\Foundation\Application::class ) ) {
	require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
}

/**
 * Apply a global Application instance when all plugins, theme loaded and user authentication applied
 */
add_action( 'init', function () {
	$config = require_once( ENPII_BASE_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'wp-app.php' );
	$config = apply_filters( 'enpii-base/wp-app-config', $config );
	$wp_app = new WpApp();
	$wp_app->init_config( $config );
} );

/**
 * Apply initial configs to app
 */
add_filter( 'enpii-base/wp-app-config', function ( $config ) {
	return ArrayHelper::merge( $config, [
		'text_domain' => 'enpii',
	] );
}, 10, 1 );

add_action( 'shutdown', function () {
	echo view('test');
//	$view = app();
//	$wp_user_service = resolve(\Enpii\Wp\EnpiiBase\Services\WpUserService::class);
//	$wp_user_service = app()->makeWith(\Enpii\Wp\EnpiiBase\Services\WpUserService::class, [
//		'enable_site_manager_role' => 234,
//	]);
//	echo '<pre> $view: ';
//	print_r( $view );
//	echo '</pre>';
	die( 'asdf' );
} );

//class EnpiiBase {
//	public static $text_domain = 'enpii';
//
//	public static function activate() {
//		// do not generate any output
//	}
//
//	public static function get_default_config() {
//		$config = [
//			'id'         => 'enpii-base',
//			'basePath'   => WP_CONTENT_DIR,
//			'components' => [
//				'wp_theme' => [
//					'class'           => \Enpii\Wp\EnpiiBase\Component\WpTheme::class,
//					'version'         => '0.01',
//					'text_domain'     => 'enpii',
//					'use_cdn'         => false,
//					'base_path'       => get_template_directory(),
//					'base_url'        => get_template_directory_uri(),
//
//					// only set when child theme using
//					'child_base_path' => get_template_directory() === get_stylesheet_directory() ? null : get_stylesheet_directory(),
//					'child_base_url'  => get_template_directory_uri() === get_stylesheet_directory_uri() ? null : get_stylesheet_directory_uri(),
//				],
//			],
//		];
//
//		return $config;
//	}
//
//	/**
//	 * Init the Application after WordPress loaded
//	 */
//	public static function init_app() {
//		WpApp::load_config( static::get_default_config() );
//
//		// If a theme is being used
//		if ( ( defined( 'WP_USE_THEMES' ) && WP_USE_THEMES ) || ( defined( 'WP_ADMIN' ) && WP_ADMIN ) ) {
//			$child_theme_config_file_path = get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'enpii-config.php';
//			$main_theme_config_file_path  = get_template_directory() . DIRECTORY_SEPARATOR . 'enpii-config.php';
//
//			if ( ( $main_theme_config_file_path !== $child_theme_config_file_path ) && file_exists( $child_theme_config_file_path ) ) {
//				WpApp::load_config( require( $child_theme_config_file_path ) );
//			}
//
//			if ( file_exists( $main_theme_config_file_path ) ) {
//				WpApp::load_config( require( $main_theme_config_file_path ) );
//			}
//		}
//		WpApp::initialize();
//	}
//}
//
//register_activation_hook( __FILE__, array( 'EnpiiBase', 'activate' ) );
//
//// After WP fully loaded and before handling request
//add_action( 'plugins_loaded', [ 'EnpiiBase', 'init_app' ] );