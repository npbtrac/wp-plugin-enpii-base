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
	 * Get content of a template block for the layout with params
	 * Template file should be in `templates` folder of child theme, parent theme or of this plugin
	 *
	 * @param string $template_slug name of the template
	 * @param array $params arguments needed to be sent to the view
	 *
	 * @return string
	 */
	public static function get_template_part( $template_slug, $params = [] ) {
		// Todo: add object cache function for template
		extract( $params );
		$template_default_path     = ENPII_BASE_PLUGIN_PATH . DIRECTORY_SEPARATOR . $template_slug . '.php';
		$template_theme_path       = get_template_directory() . DIRECTORY_SEPARATOR . $template_slug . '.php';
		$template_child_theme_path = get_stylesheet_directory() . DIRECTORY_SEPARATOR . $template_slug . '.php';
		ob_start();
		if ( file_exists( $template_child_theme_path ) ) {
			include $template_child_theme_path;
		} else if ( file_exists( $template_theme_path ) ) {
			include $template_theme_path;
		} else if ( file_exists( $template_default_path ) ) {
			include( $template_default_path );
		}
		$result = ob_get_contents();
		ob_end_clean();

		return $result;
	}

	/**
	 * Turn a post content to complete output like `the_content`
	 *
	 * @param string $post_content
	 */
	public static function get_post_content( $content ) {
		/**
		 * Filters the post content.
		 *
		 * @since 0.71
		 *
		 * @param string $content Content of the current post.
		 */
		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );

		return $content;
	}

	/**
	 * Highlight the occurrence of words in a string in a text
	 *
	 * @param string $text_to_highlight
	 * @param null|string $search_term
	 */
	public static function highlight_keyword( $text_to_highlight, $search_query = null, $regex_replacement = "<i class='found-text'>$0</i>" ) {
		$search_query        = trim( $search_query );
		$arr_tmp             = array_unique( preg_split( '/\s+/', $search_query ) );
		$arr_keyword_pattern = array_map( function ( $search_term ) {
			return "/\p{L}*?" . preg_quote( $search_term ) . "\p{L}*/ui";
		}, $arr_tmp );

		return preg_replace( $arr_keyword_pattern, $regex_replacement, $text_to_highlight );
	}

	/**
	 * Shorten a text with highlighted keywords and some words around it
	 *
	 * @param $text_to_highlight
	 * @param null $search_query
	 * @param int $character_count
	 * @param string $str_ellipsis
	 * @param string $regex_replacement
	 *
	 * @return string
	 */
	public static function get_keyword_highlighted_text( $text_to_highlight, $search_query = null, $character_count = 36, $str_ellipsis = ' ... ', $regex_replacement = "<i class='found-text'>$0</i>" ) {

		$search_query      = trim( $search_query );
		$text_to_highlight = preg_replace( '/[\s]+/', ' ', $text_to_highlight );

		$arr_tmp             = array_unique( preg_split( '/\s+/', $search_query ) );
		$arr_keyword_pattern = array_map( function ( $search_term ) {
			return "/\p{L}*?" . preg_quote( $search_term ) . "\p{L}*/ui";
		}, $arr_tmp );

		$arr_text_to_return = [];

		foreach ( $arr_tmp as $index_arr => $search_term ) {
			if ( preg_match( '/[\s].{1,' . $character_count . '}(' . $search_term . ').{1,' . $character_count . '}[\s]/is', $text_to_highlight, $match ) ) {
				$text_with_keyword = $match[0];
			} else {
				$text_with_keyword = '';
			}

			if ( $tmp_text = preg_replace( $arr_keyword_pattern, $regex_replacement, $text_with_keyword ) ) {
				$arr_text_to_return[] = $tmp_text;
			}
		}

		return ! empty( $arr_text_to_return ) ? $str_ellipsis . implode( $str_ellipsis, $arr_text_to_return ) . $str_ellipsis : $str_ellipsis;
	}

	/**
	 * Escape a rich text field entered from Admin
	 *
	 * @param $content
	 *
	 * @return string
	 */
	public static function esc_editor_field( $content ) {
		$content = static::get_post_content( $content );

		return wp_kses_post( $content );
	}

	/**
	 * Load Font Awesome
	 *
	 * @param bool $use_cdn
	 */
	public static function load_font_awesome( $use_cdn = false ) {
		wp_enqueue_style( 'font-awesome', $use_cdn ? '//use.fontawesome.com/releases/v5.2.0/css/all.css' : ENPII_BASE_PLUGIN_ASSETS_URL . '/font-awesome/web-fonts-with-css/css/fontawesome-all.min.css', array(), ENPII_BASE_PLUGIN_VER, 'all' );
	}

	/**
	 * Load BxSlider assets
	 *
	 * @param bool $use_cdn
	 */
	public static function load_bxslider( $use_cdn = false ) {
		wp_enqueue_style( 'bxslider', $use_cdn ? '//cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.css' : ENPII_BASE_PLUGIN_ASSETS_URL . '/bxslider-4/dist/jquery.bxslider.min.css', array(), ENPII_BASE_PLUGIN_VER, 'screen' );

		wp_enqueue_script( 'bxslider', $use_cdn ? '//cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.js' : ENPII_BASE_PLUGIN_ASSETS_URL . '/bxslider-4/dist/jquery.bxslider.min.js', [ 'jquery' ], ENPII_BASE_PLUGIN_VER, true );
	}

	/**
	 * Load Modernizr to detect the browser features
	 *
	 * @param bool $use_cdn
	 */
	public static function load_modernizr( $use_cdn = false ) {
		wp_enqueue_script( 'modernizr', $use_cdn ? '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js' : ENPII_BASE_PLUGIN_ASSETS_URL . '/components-modernizr/modernizr.js', [], ENPII_BASE_PLUGIN_VER, true );
	}

	/**
	 * Load Detectizr to detect client device
	 *
	 * @param bool $use_cdn
	 */
	public static function load_detectizr( $use_cdn = false ) {
		static::load_modernizr( $use_cdn );
		wp_enqueue_script( 'detectizr', $use_cdn ? '//cdnjs.cloudflare.com/ajax/libs/detectizr/2.2.0/detectizr.min.js' : ENPII_BASE_PLUGIN_ASSETS_URL . '/detectizr/dist/detectizr.min.js', [ 'modernizr' ], ENPII_BASE_PLUGIN_VER, true );
	}

	/**
	 * Load Color box resources
	 *
	 * @param bool $use_cdn
	 */
	public static function load_colorbox( $use_cdn = false ) {
		wp_enqueue_style( 'colorbox', $use_cdn ? '//cdn.jsdelivr.net/npm/jquery-colorbox@1.6.4/example3/colorbox.css' : ENPII_BASE_PLUGIN_ASSETS_URL . '/jquery-colorbox/example3/colorbox.css', [], ENPII_BASE_PLUGIN_VER, 'screen' );
		wp_enqueue_script( 'colorbox', $use_cdn ? '//cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.4/jquery.colorbox-min.js' : ENPII_BASE_PLUGIN_ASSETS_URL . '/jquery-colorbox/jquery.colorbox-min.js', [ 'jquery' ], ENPII_BASE_PLUGIN_VER, true );
	}

	/**
	 * Load css for animation
	 * https://daneden.github.io/animate.css/
	 *
	 * @param bool $use_cdn
	 */
	public static function load_animate_css( $use_cdn = false ) {
		wp_enqueue_style( 'animate-css', $use_cdn ? '//cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css' : ENPII_BASE_PLUGIN_ASSETS_URL . '/animate.css/animate.min.css', [], ENPII_BASE_PLUGIN_VER, 'screen' );
	}

	/**
	 * Load imagesLoaded jquery plugin
	 * http://desandro.github.com/imagesloaded/
	 *
	 * @param bool $use_cdn
	 */
	public static function load_images_loaded( $use_cdn = false ) {
		wp_enqueue_script( 'images-loaded', $use_cdn ? '//cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.4/imagesloaded.pkgd.min.js' : ENPII_BASE_PLUGIN_ASSETS_URL . '/imagesloaded/imagesloaded.pkgd.min.js', [ 'jquery' ], ENPII_BASE_PLUGIN_VER, true );
	}

	/**
	 * Load isotope for sorting items arbitrary
	 * https://isotope.metafizzy.co/
	 *
	 * @param bool $use_cdn
	 */
	public static function load_isotope( $use_cdn = false ) {
		wp_enqueue_script( 'isotope', $use_cdn ? '//cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js' : ENPII_BASE_PLUGIN_ASSETS_URL . '/isotope/dist/isotope.pkgd.min.js', [ 'jquery' ], ENPII_BASE_PLUGIN_VER, true );
		wp_enqueue_script( 'isotope-fit-columns', $use_cdn ? '//cdn.jsdelivr.net/npm/isotope-fit-columns@1.1.4/fit-columns.min.js' : ENPII_BASE_PLUGIN_ASSETS_URL . '/isotope-fit-columns/fit-columns.js', [ 'isotope' ], ENPII_BASE_PLUGIN_VER, true );
		wp_enqueue_script( 'isotope-horizontal', $use_cdn ? '//cdn.jsdelivr.net/npm/isotope-horizontal@2.0.1/horizontal.min.js' : ENPII_BASE_PLUGIN_ASSETS_URL . '/isotope-horizontal/horizontal.js', [ 'isotope' ], ENPII_BASE_PLUGIN_VER, true );
		wp_enqueue_script( 'isotope-masonry-horizontal', $use_cdn ? '//cdn.jsdelivr.net/npm/isotope-masonry-horizontal@2.0.1/masonry-horizontal.min.js' : ENPII_BASE_PLUGIN_ASSETS_URL . '/isotope-masonry-horizontal/masonry-horizontal.js', [ 'isotope' ], ENPII_BASE_PLUGIN_VER, true );
		wp_enqueue_script( 'isotope-cells-by-row', $use_cdn ? '//cdn.jsdelivr.net/npm/isotope-cells-by-row@1.1.4/cells-by-row.min.js' : ENPII_BASE_PLUGIN_ASSETS_URL . '/isotope-cells-by-row/cells-by-row.js', [ 'isotope' ], ENPII_BASE_PLUGIN_VER, true );
		wp_enqueue_script( 'isotope-cells-by-column', $use_cdn ? '//cdn.jsdelivr.net/npm/isotope-cells-by-column@1.1.4/cells-by-column.min.js' : ENPII_BASE_PLUGIN_ASSETS_URL . '/isotope-cells-by-column/cells-by-column.js', [ 'isotope' ], ENPII_BASE_PLUGIN_VER, true );
		wp_enqueue_script( 'isotope-packery', $use_cdn ? '//cdn.jsdelivr.net/npm/isotope-packery@2.0.1/packery-mode.pkgd.min.js' : ENPII_BASE_PLUGIN_ASSETS_URL . '/isotope-packery/packery-mode.pkgd.min.js', [ 'isotope' ], ENPII_BASE_PLUGIN_VER, true );
	}

	/**
	 * Load fancybox 3 plugin
	 * https://fancyapps.com/fancybox/3/
	 *
	 * @param bool $use_cdn
	 */
	public static function load_fancybox( $use_cdn = false ) {
		wp_enqueue_style( 'fancybox', $use_cdn ? '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css' : ENPII_BASE_PLUGIN_ASSETS_URL . '/fancybox/dist/jquery.fancybox.min.css', array(), ENPII_BASE_PLUGIN_VER, 'screen' );
		wp_enqueue_script( 'fancybox', $use_cdn ? '//cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js' : ENPII_BASE_PLUGIN_ASSETS_URL . '/fancybox/dist/jquery.fancybox.min.js', [ 'jquery' ], ENPII_BASE_PLUGIN_VER, true );
	}
}