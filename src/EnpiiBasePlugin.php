<?php


namespace Enpii\Wp\EnpiiBase;


use Enpii\Wp\EnpiiBase\Components\Acf;
use Enpii\Wp\EnpiiBase\Yii2\Base\WpPluginModule;

class EnpiiBasePlugin extends WpPluginModule {
	public function init_plugin() {
		// TODO: Implement init_plugin() method.
	}

	protected function initPlugin() {
		// For frontend
		add_action( 'safe_style_css', [ $this, 'addSafeStyleCss' ] );
		add_filter( 'body_class', [ $this, 'addSiteIDToBodyClass' ] );

		// For both
		add_action( 'upload_mimes', [ $this, 'allowMoreMimeTypesUpload' ] );
	}

//	public static function initInstance() {
//		$module_class_name = get_called_class();
//		/** @var static $plugin */
//		$plugin = wp_app()->getModule( $module_class_name );
//		$plugin->initPlugin();
//	}

	/**
	 * Allow more safe attributes
	 *
	 * @param string[] $attr
	 *
	 * @return array
	 */
	public function addSafeStyleCss( $attr ) {
		$attr = array_merge( $attr, [
			'display',
		] );

		return $attr;
	}

	/**
	 * Add more classes to body
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	public function addSiteIDToBodyClass( $classes ) {
		$classes[] = 'site-' . get_current_blog_id();
		if ( is_singular() ) {
			global $post;
			$classes[] = $post->post_name;
		}

		return $classes;
	}

	/**
	 * Add more MIME Types to uploading
	 *
	 * @throws \yii\base\InvalidConfigException
	 */
	public function allowMoreMimeTypesUpload() {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['webp'] = 'image/webp';

		return $mimes;
	}

	/**
	 * Register needed Acf Rules
	 *
	 * @throws \yii\base\InvalidConfigException
	 */
	public function registerAcfRules() {
		/** @var Acf $acf */
		$acf = static::instance()->get( Acf::class );
		$acf->registerFooterOptions();
	}
}

