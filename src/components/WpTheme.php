<?php
/**
 * Created by PhpStorm.
 * Author: npbtrac@yahoo.com
 * Date time: 12/18/17 3:13 PM
 */

namespace Enpii\Wp\EnpiiCore\Components;

use Enpii\Wp\EnpiiCore\Base\Component;

class WpTheme extends Component {

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

	/**
	 * Instance constructor.
	 * Initialize values for object based on configuration array
	 *
	 * @param null|array $config
	 */
	public function __construct( $config = null ) {
		parent::__construct($config);

		$this->initialize();
	}

	/**
	 * Initialize the theme hooks and basic configurations.
	 */
	public function initialize() {
		$this->add_acf_options_page();
	}

	/**
	 * Add an ACF options page to system
	 *
	 * @param string $menu_slug Slug of the menu on admin url
	 * @param string $page_title Title of the options page, display on top of the options page
	 * @param string $menu_title Title of the me
	 */
	public function add_acf_options_page($menu_slug = 'theme-acf-options', $page_title = null, $menu_title = null) {
		if ( function_exists( 'acf_add_options_page' ) ) {

			if (!$page_title) $page_title = __('Appearance Options', $this->text_domain);
			if (!$menu_title) $menu_title = __('Appearance Options', $this->text_domain);

			acf_add_options_page( [
				'page_title' => $page_title,
				'menu_title' => $menu_title,
				'menu_slug'  => $menu_slug,
				'capability' => 'manage_options',
				'redirect'   => false
			] );

		}
	}
}