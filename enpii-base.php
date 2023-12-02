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
require_once __DIR__ . DIRECTORY_SEPARATOR . 'enpii-base-init.php';
