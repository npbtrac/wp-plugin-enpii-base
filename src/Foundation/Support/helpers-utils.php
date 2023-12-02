<?php

declare(strict_types=1);

use Symfony\Component\VarDumper\Caster\ReflectionCaster;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Below functions are for development debugging
 */
if ( ! function_exists( 'devd' ) ) {
	function devd( ...$vars ) {
		$dev_trace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 7 );

		// We want to put the file name and the 7 steps trace to know where
		//  where the dump is produced
		dump( array( '=== start of dump ===', $dev_trace[0]['file'] . ':' . $dev_trace[0]['line'], $dev_trace ) );
		return dump( ...$vars );
	}
}

if ( ! function_exists( 'devdd' ) ) {
	function devdd( ...$vars ): void {
		$dev_trace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 7 );
		dump( array( '=== start of dump ===', $dev_trace[0]['file'] . ':' . $dev_trace[0]['line'], $dev_trace ) );
		dd( ...$vars );
	}
}

if ( ! function_exists( 'dev_error_log' ) ) {
	function dev_error_log( ...$vars ): void {
		$cloner = new VarCloner();
		$cloner->addCasters( ReflectionCaster::UNSET_CLOSURE_FILE_INFO );

		$dev_trace = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 7 );

		VarDumper::setHandler(
			function ( $var ) use ( $cloner ) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_var_dump
				return $var === false ? 'bool value false' : print_r( $var, true );
			}
		);

		$log_message = '';
		$log_message .= "Debugging dev_error_log \n======= Dev logging start here \n" . $dev_trace[0]['file'] . ':' . $dev_trace[0]['line'] . " \n";
		foreach ( $vars as $index => $var ) {
			$log_message .= "Var no $index: type ".gettype($var)." - " . VarDumper::dump( $var );
		}
		$log_message .= "\n======= Dev logging ends here\n\n\n\n";
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_var_dump
		error_log( $log_message );
	}
}

if ( ! function_exists( 'dev_logger' ) ) {
	function dev_logger( ...$vars ): void {
		$cloner = new VarCloner();
		$cloner->addCasters( ReflectionCaster::UNSET_CLOSURE_FILE_INFO );
		$dumper = new CliDumper();

		$dev_trace = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 7 );

		VarDumper::setHandler(
			function ( $var ) use ( $cloner, $dumper ) {
				return $dumper->dump( $cloner->cloneVar( $var ), true );
			}
		);

		$logger = wp_app_logger()->channel( 'single' );

		$log_message = '';
		$log_message .= "Debugging dev_logger \n======= Dev logging start here \n" . $dev_trace[0]['file'] . ':' . $dev_trace[0]['line'] . " \n";
		foreach ( $vars as $index => $var ) {
			$log_message .= "Var no $index: " . VarDumper::dump( $var );

		}
		$log_message .= "\n======= Dev logging ends here\n\n\n\n";

		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_var_dump
		$logger->debug( $log_message );
	}
}

if ( ! function_exists( 'dev_log' ) ) {
	function dev_log( ...$vars ): void {
		dev_error_log( ...$vars );
		dev_logger( ...$vars );
	}
}

if ( ! function_exists( 'dev_dump_log' ) ) {
	function dev_dump_log( ...$vars ): void {
		devd( ...$vars );
		dev_error_log( ...$vars );
		dev_logger( ...$vars );
	}
}
