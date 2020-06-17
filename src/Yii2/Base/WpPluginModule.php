<?php


namespace Enpii\Wp\EnpiiBase\Yii2\Base;


abstract class WpPluginModule extends WpModule implements WpPluginInterface {

	/** @var string the server path of the plugin */
	public $base_path;

	/** @var string the url to the plugin */
	public $base_url;

	/** @var string version of this plugin, <new_version>.<major_release>.<minor-release> */
	public $version = '1.0.0';

	abstract protected function initPlugin();

	/**
	 * Initialize the plugin instance, provided that, config file is in place
	 *
	 * @param $base_path
	 *
	 * @throws \yii\base\InvalidConfigException
	 */
	public static function initInstanceWithPath( $base_path ) {
		parent::initInstanceWithPath( $base_path );
		static::instance()->initPlugin();
	}
}
