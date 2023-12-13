<?php

/**
 * Below functions are for development debugging
 */

declare(strict_types=1);

use Symfony\Component\VarDumper\Caster\ReflectionCaster;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\VarDumper;

if ( ! function_exists( 'devd' ) ) {
	/**
	 * @throws \Exception
	 */
	function devd( ...$vars ) {
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_debug_backtrace
		$dev_trace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 50 );

		// We want to put the file name and the 7 steps trace to know where
		//  where the dump is produced
		if ( ! enpii_base_is_console_mode() ) {
			echo 'Traceback: ';
			dump( $dev_trace );
		}

		echo '=== start of dump === ' . esc_html( $dev_trace[0]['file'] ) . ':' . esc_html( $dev_trace[0]['line'] ) . ': ' . "\n";
		dump( ...$vars );
	}
}

if ( ! function_exists( 'devdd' ) ) {
	/**
	 * @throws \Exception
	 */
	function devdd( ...$vars ): void {
		devd( ...$vars );
		die( ' end of devdd ' );
	}
}

if ( ! function_exists( 'dev_error_log' ) ) {
	function dev_error_log( ...$vars ): void {
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_debug_backtrace
		$dev_trace = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 1 );
		$dumper = new CliDumper();
		$cloner = new VarCloner();
		$cloner->addCasters( ReflectionCaster::UNSET_CLOSURE_FILE_INFO );

		$log_message = '';
		$log_message .= "Debugging dev_error_log \n======= Dev logging start here \n" . $dev_trace[0]['file'] . ':' . $dev_trace[0]['line'] . " \n";
		foreach ( $vars as $index => $var ) {
			$dump_content = null;
			if ( $var === false ) {
				$type = 'NULL';
			} else {
				$type = is_object( $var ) ? get_class( $var ) : gettype( $var );

				// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_var_export
				$dump_content = is_object( $var ) ? $dumper->dump( $cloner->cloneVar( $var ), true ) : var_export( $var, true );
			}
			$log_message .= "Var no $index: type " . $type . ' - ' . $dump_content . " \n";
		}
		$log_message .= "\n======= Dev logging ends here\n\n\n\n";
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		error_log( $log_message );
	}
}

if ( ! function_exists( 'dev_logger' ) ) {
	function dev_logger( ...$vars ): void {
		$cloner = new VarCloner();
		$cloner->addCasters( ReflectionCaster::UNSET_CLOSURE_FILE_INFO );
		$dumper = new CliDumper();

		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_debug_backtrace
		$dev_trace = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, 1 );

		VarDumper::setHandler(
			function ( $variable ) use ( $cloner, $dumper ) {
				return $dumper->dump( $cloner->cloneVar( $variable ), true );
			}
		);

		$logger = wp_app_logger()->channel( 'single' );

		$log_message = '';
		$log_message .= "Debugging dev_logger \n======= Dev logging start here \n" . $dev_trace[0]['file'] . ':' . $dev_trace[0]['line'] . " \n";
		foreach ( $vars as $index => $var ) {
			$log_message .= "Var no $index: " . VarDumper::dump( $var ) . "\n";

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
	/**
	 * @throws \Exception
	 */
	function dev_dump_log( ...$vars ): void {
		devd( ...$vars );
		dev_error_log( ...$vars );
		dev_logger( ...$vars );
	}
}
