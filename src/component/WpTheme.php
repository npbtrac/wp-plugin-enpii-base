<?php
/**
 * Created by PhpStorm.
 * User: tracnguyen
 * Date: 7/30/18
 * Time: 4:36 PM
 */

namespace Enpii\Wp\EnpiiBase\Component;


use Enpii\Wp\EnpiiBase\Base\Component;
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
	 */
	public function initialize() {

	}
}