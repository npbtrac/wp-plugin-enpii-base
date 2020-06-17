<?php


namespace Enpii\Wp\EnpiiBase;


use Enpii\Wp\EnpiiBase\Components\Acf;
use Enpii\Wp\EnpiiBase\Yii2\Base\WpPluginModule;

class EnpiiBasePlugin extends WpPluginModule {

	/**
	 * @inheritDoc
	 */
	protected function initPlugin(): void {
		// For frontend
		add_action( 'safe_style_css', [ $this, 'addSafeStyleCss' ] );
		add_filter( 'body_class', [ $this, 'addSiteIDToBodyClass' ] );

		// For both
		add_action( 'upload_mimes', [ $this, 'allowMoreMimeTypesUpload' ] );
		add_action( 'init', [ $this, 'registerAcfRules' ] );
	}

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
			'position',
			'z-index',
			'top',
			'left',
			'right',
			'bottom',
			'margin-top',
			'margin-left',
			'margin-bottom',
			'margin-right',
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
	 */
	public function allowMoreMimeTypesUpload() {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['webp'] = 'image/webp';

		return $mimes;
	}


	/**
	 * Register needed Acf Rules
	 * @noinspection PhpFullyQualifiedNameUsageInspection
	 * @throws \yii\base\InvalidConfigException
	 */
	public function registerAcfRules() {
		/** @var Acf $acf */
		$acf = static::instance()->get( Acf::class );
		$acf->registerFooterOptions();
	}
}

