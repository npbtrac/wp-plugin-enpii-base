<?php


namespace Enpii\Wp\EnpiiBase\App\Services;


use Enpii\Wp\EnpiiBase\Libs\Traits\ServiceTrait;
use WP_CLI;
use Exception;

class WpCli {
	use ServiceTrait;

	/**
	 * @param $args
	 * @param $assoc_args
	 */
	public static function runCommands( $args, $assoc_args ) {
		if ( isset( $args[0] ) ) {
			$command = $args[0];
			unset( $args[0] );
			try {
				static::$command( $args, $assoc_args );
			} catch ( Exception $e ) {
				throw( sprintf( 'Command %s not available', $command ) );
			}
		}
	}

	/**
	 * @param $args
	 * @param $assoc_args
	 *
	 * @throws WP_CLI\ExitException
	 */
	protected static function setup( $args = null, $assoc_args = null ) {
		static::prepareWritableFolders();
	}

	/**
	 * @throws WP_CLI\ExitException
	 */
	protected static function prepareWritableFolders() {
		WP_CLI::log( "\n" . sprintf( 'Create and make cached Config Path writable: %s', config( 'cachedConfigPath' ) ) );
		if ( wp_mkdir_p( config( 'cachedConfigPath' ) ) ) {
			WP_CLI::success( 'Done' );
		} else {
			WP_CLI::error( 'Failed' );
		}
		WP_CLI::log( "\n" );
	}
}