<?php
/**
 * Plugin Name: Enpii Base
 * Plugin URI:  https://enpii.com/wp-plugin-enpii-base/
 * Description: Base plugin for WP development using Laravel
 * Author:      dev@enpii.com, nptrac@yahoo.com
 * Author URI:  https://enpii.com/enpii-team/
 * Version:     0.3.1
 * Text Domain: enpii
 */

// We want to split all the bootstrapping code to a separate file
// 	for putting into composer autoload and
// 	for easier including on other section e.g. unit test
require_once __DIR__ . DIRECTORY_SEPARATOR . 'enpii-base-bootstrap.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'enpii-base-init.php';
