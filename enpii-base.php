<?php
/**
 * Plugin Name: Enpii Base
 * Plugin URI:  https://enpii.com/
 * Description: Base plugin for WP development
 * Author:      dev@enpii.com, nptrac@yahoo.com
 * Author URI:  https://enpii.com/
 * Version:     0.1.1
 * Text Domain: enpii
 */

// Update these constants whenever you bump the version
defined( 'ENPII_BASE_PLUGIN_VERSION' ) || define( 'ENPII_BASE_PLUGIN_VERSION', '0.1.1' );

// General fixed constants
defined( 'DIR_SEP' ) || define( 'DIR_SEP', DIRECTORY_SEPARATOR );

// We include composer autoload here
if ( ! class_exists( \Enpii\WP_Plugin\Enpii_Base\Libs\WP_Application::class ) ) {
	require_once __DIR__ . DIR_SEP . 'vendor' . DIR_SEP . 'autoload.php';
}

// Plugin constants
defined( 'ENPII_BASE_PLUGIN_SLUG' ) || define( 'ENPII_BASE_PLUGIN_SLUG', 'enpii-base' );
defined( 'ENPII_BASE_WP_APP_PREFIX' ) || define( 'ENPII_BASE_WP_APP_PREFIX', env('ENPII_BASE_WP_APP_PREFIX', 'wp-app') );

/**
 | WP CLI handlers
 |
 */
add_action( 'cli_init', 'enpii_base_wp_cli_register_commands' );

/**
 | Create a wp_app() instance to be used in the whole application
 */
$wp_app_base_path = enpii_base_wp_app_get_base_path();
$config = apply_filters( 'enpii_base_wp_app_prepare_config', [
	'app' => require_once __DIR__ . DIR_SEP . 'wp-app-config' . DIR_SEP . 'app.php',
] );
// We initiate the WP Application instance
$wp_app = new \Enpii\WP_Plugin\Enpii_Base\Libs\WP_Application( $wp_app_base_path );
$wp_app->init_config( $config );

// We register Enpii_Base plugin as a Service Provider
$wp_app->register_plugin( \Enpii\WP_Plugin\Enpii_Base\Base\Enpii_Base_Plugin::class, __DIR__, plugin_dir_url( __FILE__ ) );
