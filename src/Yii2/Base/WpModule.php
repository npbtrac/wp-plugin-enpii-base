<?php


namespace Enpii\Wp\EnpiiBase\Yii2\Base;


use yii\base\InvalidConfigException;
use yii\base\Module;

abstract class WpModule extends Module {
	public $text_domain = 'default';

	/**
	 * @param $base_path
	 *
	 * @throws InvalidConfigException
	 */
	public static function initConfig( $base_path ) {
		$config_file_path = $base_path . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'wp-app-module.php';
		if ( ! file_exists( $config_file_path ) ) {
			throw new InvalidConfigException( sprintf( __( 'No Configuration File. Please initialize `wp-app-module.php` in %s' ), $base_path . DIRECTORY_SEPARATOR . 'config' ) );
		}
		/** @noinspection PhpIncludeInspection */
		return file_exists( $config_file_path ) ? require_once( $config_file_path ) : [];
	}

	/**
	 * @throws InvalidConfigException
	 */
	public static function initInstanceWithPath( $base_path ) {
		if ( is_null( static::instance() ) ) {
			$config = static::initConfig( $base_path );

			// We use the module class name for alias and the class to initialize the module instance
			$module_class_name = get_called_class();
			wp_app()->setModules( [
				$module_class_name => array_merge( [
					'__class' => $module_class_name,
				], $config )
			] );
		}
	}

	/**
	 * Get the loaded module instance
	 *
	 * @return Module|null
	 */
	public static function instance() {
		return wp_app()->getModule( get_called_class() );
	}
}
