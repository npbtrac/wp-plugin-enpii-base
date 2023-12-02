<?php
/**
 * Plugin Name: Enpii Base
 * Plugin URI:  https://enpii.com/
 * Description: Base plugin for WP development using Laravel
 * Author:      dev@enpii.com, nptrac@yahoo.com
 * Author URI:  https://enpii.com/
 * Version:     0.2.4
 * Text Domain: enpii
 */

// We want to split all the bootstrapping code to a separate file
// 	for putting into composer autoload and
// 	for easier including on other section e.g. unit test
require_once __DIR__ . DIRECTORY_SEPARATOR . 'enpii-base-bootstrap.php';

// We want to put all init actions to a file for putting into composer autoload
// We want to put all init actions to a file for putting into composer autoload
enpii_base_setup_wp_app();

// We register Enpii_Base plugin as a Service Provider
wp_app()->register_plugin(
	\Enpii_Base\App\WP\Enpii_Base_WP_Plugin::class,
	ENPII_BASE_PLUGIN_SLUG,
	__DIR__,
	plugin_dir_url( __FILE__ )
);
