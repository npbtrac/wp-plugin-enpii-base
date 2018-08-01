<?php
/**
 * Created by PhpStorm.
 * User: tracnguyen
 * Date: 7/31/18
 * Time: 3:28 PM
 */

namespace Enpii\Wp\EnpiiBase;


class Wp {
	/**
	 * Load Font Awesome
	 * @param bool $use_cdn
	 */
	public static function load_font_awesome( $use_cdn = false ) {
		wp_enqueue_style( 'font-awesome', $use_cdn ? '//use.fontawesome.com/releases/v5.2.0/css/all.css' : ENPII_BASE_PLUGIN_ASSETS_URL . '/font-awesome/web-fonts-with-css/css/fontawesome-all.min.css', array(), ENPII_BASE_PLUGIN_VER, 'all' );
	}

	/**
	 * Load BxSlider assets
	 * @param bool $use_cdn
	 */
	public static function load_bxslider( $use_cdn = false ) {
		wp_enqueue_style( 'bxslider', $use_cdn ? '//cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.css' : ENPII_BASE_PLUGIN_ASSETS_URL . '/bxslider-4/dist/jquery.bxslider.min.css', array(), ENPII_BASE_PLUGIN_VER, 'screen' );

		wp_enqueue_script( 'bxslider', $use_cdn ? '//cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.js' : ENPII_BASE_PLUGIN_ASSETS_URL . '/bxslider-4/dist/jquery.bxslider.min.js', ['jquery'], ENPII_BASE_PLUGIN_VER, true );
	}

	/**
	 * Load Modernizr to detect the browser features
	 * @param bool $use_cdn
	 */
	public static function load_modernizr($use_cdn = false)
	{
		wp_enqueue_script('modernizr', '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', [], ENPII_BASE_PLUGIN_VER, true);
	}

	/**
	 * Load Detectizr to detect client device
	 * @param bool $use_cdn
	 */
	public static function load_detectizr($use_cdn = false)
	{
		static::load_modernizr($use_cdn);
		wp_enqueue_script('detectizr', '//cdnjs.cloudflare.com/ajax/libs/detectizr/2.2.0/detectizr.min.js', ['modernizr'], ENPII_BASE_PLUGIN_VER, true);
	}

	/**
	 * Load Color box resources
	 * @param bool $use_cdn
	 */
	public static function load_colorbox( $use_cdn = false ) {
		wp_enqueue_script( 'colorbox', $use_cdn ? '//cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.4/jquery.colorbox-min.js' : ENPII_BASE_PLUGIN_ASSETS_URL . '/jquery-colorbox/jquery.colorbox-min.js', ['jquery'], ENPII_BASE_PLUGIN_VER, true );
	}

	public static function load_animate_css($use_cdn = false)
	{
		wp_enqueue_style( 'animate-css', $use_cdn ? '//cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css' : '//cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css', array(), ENPII_BASE_PLUGIN_VER, 'screen' );
	}
}