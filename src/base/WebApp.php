<?php
/**
 * Created by PhpStorm.
 * User: tracnguyen
 * Date: 7/30/18
 * Time: 3:40 PM
 */

namespace Enpii\Wp\EnpiiBase\Base;

use Dice\Dice;

class WebApp {
	/* @var static $_instance */
	protected static $_instance = null;

	/* @var Dice $_di */
	protected static $_di = null;

	/* @var array $_container */
	protected $_container = null;

	/* @var array $_config */
	protected $_config = null;

	public function __construct( $config ) {
		$this->_config = $config;
	}

	/**
	 * Initialize the singleton of application
	 * @param $config
	 * @return void
	 */
	public static function initialize( $config ) {
		if ( null === static::$_instance ) {
			static::$_instance = new static( $config );
		}

		if ( null === static::$_di ) {
			static::$_di = new Dice();
		}
	}

	/**
	 * Getter - Get the singleton of application
	 * @return static
	 */
	public static function instance() {
		if ( null === static::$_instance ) {
			die('WebApp singleton object not created yet. Please `initialize` it');
		} else {
			return static::$_instance;
		}
	}

	/**
	 * Get component of application from container of components
	 * @param $component_name_to_get
	 *
	 * @return mixed
	 */
	public function __get( $component_name_to_get ) {
		if ( ! isset( $this->_container[ $component_name_to_get ] ) || ! $this->_container[ $component_name_to_get ] ) {
			if ( isset( $this->_config['components'] ) && ( $components = $this->_config['components'] ) && ( isset( $components[ $component_name_to_get ] ) && $component_args = $components[ $component_name_to_get ] ) ) {
				$dice            = static::$_di;
				$component_class = isset( $component_args['class'] ) ? $component_args['class'] : '';
				unset( $component_args['class'] );

				$rule = [
					'shared'          => true,
					'constructParams' => [ 'config' => $component_args ],
				];
				$dice->addRule( $component_class, $rule );
				$this->_container[ $component_name_to_get ] = $dice->create( $component_class );
			}
		}

		return $this->_container[ $component_name_to_get ];
	}
}