<?php

declare(strict_types=1);

if ( ! function_exists( 'wp_app_dispatch_command_handler' ) ) {
	function wp_app_dispatch_command_handler( string $handler_classname, $command = null ): void {
		wp_app()->dispatch_command_handler($handler_classname, $command);
	}
}

if ( ! function_exists( 'wp_app_execute_query_handler' ) ) {
	function wp_app_execute_query_handler( string $handler_classname, $command = null ): mixed {
		return wp_app()->execute_query_handler($handler_classname, $command);
	}
}
