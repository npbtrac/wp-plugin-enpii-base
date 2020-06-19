<?php


namespace Enpii\Wp\EnpiiBase\Yii2\Base;

abstract class WpThemeModule extends WpModule {

	/** @var string the server path of the plugin */
	public $base_path;

	/** @var string the url to the plugin */
	public $base_url;

	/** @var string path of parent theme */
	public $template_path;

	/** @var string url of parent theme */
	public $template_url;

	/** @var string path of child theme */
	public $stylesheet_path;

	/** @var string path of child theme */
	public $stylesheet_url;

	/** @var string version of this plugin, <new_version>.<major_release>.<minor-release> */
	public $version = '1.0.0';

	/**
	 * Execute all needed things to init the plugin
	 *
	 * @return void
	 */
	abstract protected function initTheme(): void;

	/**
	 * Initialize view component of app and set basic view path
	 */
	abstract public static function initView(): void;

	/**
	 * Initialize the plugin instance, provided that, config file is in place
	 *
	 * @param $base_path
	 *
	 * @noinspection PhpFullyQualifiedNameUsageInspection
	 * @throws \yii\base\InvalidConfigException
	 */
	public static function initInstanceWithPath( $base_path ) {
		if ( is_null( static::instance() ) ) {
			$config = static::initConfig( $base_path );

			// We use the module class name for alias and the class to initialize the module instance
			$module_class_name = get_called_class();
			wp_app()->setModules( [
				$module_class_name => array_merge( [
					'__class'         => $module_class_name,
					'template_path'   => get_template_directory(),
					'template_url'    => get_template_directory_uri(),
					'stylesheet_path' => get_stylesheet_directory(),
					'stylesheet_url'  => get_stylesheet_directory_uri(),
				], $config )
			] );
		}
		$instance = static::instance();
		$instance->initTheme();
	}
}
