<?php

declare(strict_types=1);

use Enpii_Base\Deps\Symfony\Component\VarDumper\VarDumper;

/**
 * Below functions are for development debugging
 */
if ( ! function_exists( 'dev_dump' ) ) {
	function dev_dump( ...$vars ): void {
		VarDumper::dump("==========>>>>>>");
		VarDumper::dump("========== start dumping ============");
		foreach ( $vars as $index => $var ) {
			VarDumper::dump("=== var $index: === type: ".gettype($var));
			VarDumper::dump($var);
		}
		VarDumper::dump("============ end dumping ============");
		VarDumper::dump("============================<<<<<<<<<");
	}
}

if ( ! function_exists( 'dev_dump_die' ) ) {
	function dev_dump_die( ...$vars ): void {
		dev_dump(...$vars);
		die();
	}
}

if ( ! function_exists( 'dev_error_log' ) ) {
	function dev_error_log( ...$vars ): void {
		foreach ( $vars as $index => $var ) {
			error_log(print_r("=== var $index: === type: ".gettype($var), true));
			error_log(print_r($var, true));
			error_log(print_r("\n", true));
		}
		error_log(print_r("end dev_error_log =====\n\n\n\n", true));
	}
}

if ( ! function_exists( 'dev_logger' ) ) {
	function dev_logger( ...$vars ): void {
		foreach ( $vars as $index => $var ) {
			wp_app_logger()->channel('single')->info( "=== var $index: === type: ".gettype($var) );
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_var_dump
			wp_app_logger()->channel('single')->debug( print_r( $var, true ) );
		}
		wp_app_logger()->channel('single')->info( "end dev_logger =====\n\n\n\n" );
	}
}

if ( ! function_exists( 'dev_logger_dump' ) ) {
	function dev_logger_dump( ...$vars ): void {
		dev_dump( ...$vars );
		dev_logger( ...$vars );
	}
}
