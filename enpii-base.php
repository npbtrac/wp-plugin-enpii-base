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

use Enpii\Wp\EnpiiBase\Yii2\Base\WebApplication;
use Enpii\Wp\EnpiiBase\Yii2\Base\ConsoleApplication;
use Enpii\Wp\EnpiiBase\EnpiiBasePlugin;
use yii\base\Application;
use yii\base\InvalidConfigException;

defined( 'ENPII_BASE_PLUGIN_VER' ) || define( 'ENPII_BASE_PLUGIN_VER', '0.4.0' );
defined( 'ENPII_BASE_CONFIG_APP_FILENAME' ) || define( 'ENPII_BASE_CONFIG_APP_FILENAME', 'wp-app.php' );

// For Yii2
defined( 'YII_DEBUG' ) or define( 'YII_DEBUG', defined( 'WP_DEBUG' ) ? WP_DEBUG : false );
defined( 'YII_ENV' ) or define( 'YII_ENV', defined( 'WP_ENV' ) ? WP_ENV : 'production' );

// Use autoload if Yii not loaded
if ( ! class_exists( Application::class ) ) {
	require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
}

if ( ! class_exists( Yii::class ) ) {
	require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'yiisoft' . DIRECTORY_SEPARATOR . 'yii2' . DIRECTORY_SEPARATOR . 'Yii.php';
}

require_once __DIR__ . DIRECTORY_SEPARATOR . 'helpers.php';

if ( ! function_exists( 'enpii_base_init_wp_app' ) ) {
	/**
	 * Get application instance
	 */

	/**
	 * Initialize global application
	 *
	 * @throws InvalidConfigException
	 */
	function enpii_base_init_wp_app() {
		$config_file_path = __DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . ENPII_BASE_CONFIG_APP_FILENAME;
		if ( ! file_exists( $config_file_path ) ) {
			throw new InvalidConfigException( sprintf( __( 'No Configuration File. Please initialize `%s` in %s', 'enpii' ), ENPII_BASE_CONFIG_APP_FILENAME, __DIR__ . DIRECTORY_SEPARATOR . 'config' ) );
		}
		/** @noinspection PhpIncludeInspection */
		$config = file_exists( $config_file_path ) ? require_once( $config_file_path ) : [];

		$config = apply_filters( 'enpii-base/wp-app-config', $config );

		is_console_application() ? new ConsoleApplication( $config ) : new WebApplication( $config );

		EnpiiBasePlugin::initInstanceWithPath( __DIR__ );
	}
}
add_action( 'muplugins_loaded', 'enpii_base_init_wp_app', 100 );

if ( ! function_exists( 'enpii_base_setup_wp_app_for_theme' ) ) {
	/**
	 * Make Laravel view paths working with WordPress theme system
	 */
	function enpii_base_setup_wp_app_for_theme() {
//		dump(wp_app()->modules);
//		die();
	}
}
add_action( 'after_setup_theme', 'enpii_base_setup_wp_app_for_theme', 10 );
