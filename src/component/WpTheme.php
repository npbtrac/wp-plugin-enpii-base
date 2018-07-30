<?php
/**
 * Created by PhpStorm.
 * User: tracnguyen
 * Date: 7/30/18
 * Time: 4:36 PM
 */

namespace Enpii\Wp\EnpiiBase\Component;


use Enpii\Wp\EnpiiBase\Base\Component;

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
	 * @param array $config
	 */
	public function __construct( $config ) {
		parent::__construct( $config );

		$this->initialize();
	}

	public function initialize() {
		echo '<pre> initialize: ';
		print_r( 'wp theme initialize' );
		echo "</pre>\n";
	}
}