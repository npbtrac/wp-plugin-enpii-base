<?php
/**
 * Created by PhpStorm.
 * User: tracnguyen
 * Date: 7/30/18
 * Time: 4:36 PM
 */

namespace Enpii\Wp\EnpiiBase\Component;

use Enpii\Wp\EnpiiBase\Base\ComponentTrait;
use Enpii\Wp\EnpiiBase\Base\WebApp;

class WpTheme {
	use ComponentTrait {
		ComponentTrait::__construct as private __componentConstruct;
	}

	/* @var string represent current version of theme */
	public $version;
	/* @var string for theme translation */
	public $text_domain;
	/* @var bool choose to load popular assets from CDN or not */
	public $use_cdn = false;
	public $base_path;
	public $base_url;
	public $child_base_path;
	public $child_base_url;

	/* @var \Snscripts\HtmlHelper\Html $html_helper */
	public $html_helper = null;

	/**
	 * Instance constructor.
	 * Initialize values for object based on configuration array
	 *
	 * @param array $config
	 */
	public function __construct( $config ) {
		$this->__componentConstruct( $config );

		// Init Html Helper
		// Find out more here https://github.com/mikebarlow/html-helper
		$this->html_helper = WebApp::instance()->{$this->html_helper};
	}

	/**
	 * Initialize theme with hooks
	 * Should be override by child class
	 */
	public function initialize() {
		// For frontend
		add_action( 'safe_style_css', [ $this, 'add_safe_style_css' ] );
		add_filter( 'body_class', [ $this, 'add_site_id_to_body_class' ] );

		// For Admin
//		Uncomment to use custom editor style
//		add_action( 'admin_init', [ $this, 'add_editor_style' ] );

//		Uncomment to add custom styles & scripts to admin
//		add_action( 'admin_head', [ $this, 'add_admin_styles' ] );

		// For both
		add_action( 'upload_mimes', [ $this, 'allow_svg_upload' ] );

	}

	/**
	 * Allow svg file to be uploaded as a media file
	 *
	 * @param $mimes
	 *
	 * @return mixed
	 */
	public function allow_svg_upload( $mimes ) {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['webp'] = 'image/webp';

		return $mimes;
	}

	/**
	 * Add an extra caption field to Flexible content layout title
	 *
	 * @param $title
	 * @param $field
	 * @param $layout
	 * @param $i
	 *
	 * @return bool
	 */
	public function add_caption_to_flexible_content( $title, $field, $layout, $i ) {
		if ( $value = get_sub_field( 'caption' ) ) {
			return $title . ' - ' . $value;
		} else {
			foreach ( $layout['sub_fields'] as $sub ) {
				if ( $sub['name'] == 'caption' ) {
					$key = $sub['key'];
					if ( array_key_exists( $i, $field['value'] ) && $value = $field['value'][ $i ][ $key ] ) {
						return $title . ' - ' . $value;
					}
				}
			}
		}

		return $title;
	}

	/**
	 * Handle HTML Text to produce a safe rich text
	 *
	 * @param $html_text
	 *
	 * @return string
	 */
	public function process_html( $html_text ) {
		$content = wp_kses( $html_text, $GLOBALS['allowedposttags'] );

		/**
		 * Filters the post content.
		 *
		 * @since 0.71
		 *
		 * @param string $content Content of the current post.
		 */
		$content = apply_filters( 'the_content', $content );

		return str_replace( ']]>', ']]&gt;', $content );
	}

	/**
	 * Handle HTML Text to produce a safe rich text inside an <a> tag
	 *
	 * @param $html_text
	 *
	 * @return string
	 */
	public function process_html_for_a( $html_text ) {
		$allowed_tags_for_a = $GLOBALS['allowedposttags'];
		unset( $allowed_tags_for_a['a'] );

		$content = wp_kses( $html_text, $allowed_tags_for_a );

		/**
		 * Filters the post content.
		 *
		 * @since 0.71
		 *
		 * @param string $content Content of the current post.
		 */
		$content = apply_filters( 'the_content', $content );

		return str_replace( ']]>', ']]&gt;', $content );
	}

	/**
	 * Add more allowed styles
	 *
	 * @param $styles
	 *
	 * @return array
	 */
	public function add_safe_style_css( $styles ) {
		$styles[] = 'display';
		$styles[] = 'position';
		$styles[] = 'z-index';
		$styles[] = 'top';
		$styles[] = 'left';
		$styles[] = 'right';
		$styles[] = 'bottom';
		$styles[] = 'margin-top';
		$styles[] = 'margin-left';
		$styles[] = 'margin-bottom';
		$styles[] = 'margin-right';

		return $styles;
	}

	/**
	 * Render a button taking data from button group declaration
	 *
	 * @param array $button_group
	 * @param string $css_class
	 *
	 * @return string
	 */
	public function render_button( $button_group, $css_class = '' ) {
		$extra_css_class = isset( $button_group['extra_css_class'] ) ? $button_group['extra_css_class'] : '';

		$tmp_button_link = '';
		if ( isset( $button_group['link_type'] ) ) {
			$tmp_button_link = $button_group['link_type'] ? $button_group['button_custom_link'] : $button_group['button_internal_link'];
		}


		$allowed_tags_for_a = $GLOBALS['allowedposttags'];
		unset( $allowed_tags_for_a['a'] );
		$tmp_button_text = wp_kses( $button_group['button_text'], $allowed_tags_for_a );

		$tmp_button_attributes = [
			'href'  => $tmp_button_link,
			'title' => strip_tags( $tmp_button_text ),
		];

		if ( isset( $button_group['link_target'] ) ) {
			if ( $button_group['link_target'] == 1 ) {
				$tmp_button_attributes['target'] = '_blank';
				$tmp_button_attributes['rel']    = isset( $tmp_button_attributes['rel'] ) ? $tmp_button_attributes['rel'] . ' ' . 'noopener nofollow' : 'noopener nofollow';
			} elseif ( $button_group['link_target'] ) {
				$tmp_button_attributes['target'] = $button_group['link_target'];
			}
		}

		$tmp_button_attributes['class'] = $css_class . ' ' . $extra_css_class;

		if ( ! empty( $button_group['html_attributes'] ) ) {
			foreach ( $button_group['html_attributes'] as $html_attribute ) {
				$tmp_button_attributes[ $html_attribute['attribute_name'] ] = $html_attribute['attribute_value'];
			}
		}

		if ( $tmp_button_attributes['href'] ) {
			return $this->html_helper->tag( 'a', $tmp_button_attributes, $tmp_button_text, true );
		} else {
			unset( $tmp_button_attributes['href'], $tmp_button_attributes['title'], $tmp_button_attributes['target'] );

			return $this->html_helper->div( wp_kses( $button_group['button_text'], $GLOBALS['allowedposttags'] ), $tmp_button_attributes );
		}
	}
}