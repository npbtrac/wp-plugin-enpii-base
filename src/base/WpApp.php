<?php
/**
 * Created by PhpStorm.
 * User: tracnguyen
 * Date: 10/20/18
 * Time: 12:48 PM
 */

namespace Enpii\Wp\EnpiiBase\Base;

use Aura\Di\ContainerBuilder;
use Aura\Di\Container;

use Enpii\Wp\EnpiiBase\Component\WpTheme;
use Enpii\Wp\EnpiiBase\Helper\ArrayHelper as ArrayHelper;

class WpApp {
	/* @var string $_id */
	protected $_id = null;

	/* @var string $_basePath */
	protected $_basePath = null;

	/* @var [] config params of application */
	protected static $config = [];

	/* @var static $_instance */
	protected static $_instance = null;

	// Find out more here https://github.com/auraphp/Aura.Di/blob/3.x/docs/index.md
	/* @var Container $_di */
	protected static $_di = null;

	public function __construct( $config ) {
		if ( isset( $config['id'] ) ) {
			$this->_id = $config['id'];
		}

		if ( isset( $config['basePath'] ) ) {
			$this->_basePath = $config['basePath'];
		}

		/* @var Container $di */
		$di = static::$_di;

		if ( isset( $config['components'] ) && is_array( $components = $config['components'] ) ) {
			foreach ( $components as $component_name => $component_args ) {
				if ( isset( $component_args['class'] ) && $component_class = $component_args['class'] ) {
					unset( $component_args['class'] );

					try {
						$component_args['appInstance'] = $this;
						// params needs to match the constructor
						$di->set( $component_name, $di->lazyNew( $component_class, [ 'config' => $component_args ] ) );
					} catch ( \Exception $e ) {

					}
				}
			}
		}
	}

	/**
	 * Initialize the singleton of application
	 *
	 * @param $config
	 *
	 * @return void
	 */
	public static function initialize( $config = null ) {
		$config = $config ?: static::$config;
		if ( null === static::$_di ) {
			$builder     = new ContainerBuilder();
			static::$_di = $builder->newInstance();
		}

		if ( null === static::$_instance ) {
			static::$_instance = new static( $config );
		}
	}

	/**
	 * Getter - Get the singleton of application
	 * @return static
	 */
	public static function instance() {
		if ( null === static::$_instance ) {
			die( 'WpApp singleton object not created yet. Please `initialize` it' );
		} else {
			return static::$_instance;
		}
	}

	/**
	 * Get component of application from container of components
	 *
	 * @param $component_name_to_get
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function __get( $component_name_to_get ) {
		$di = static::$_di;

		return $di->get( $component_name_to_get );
	}


	/**
	 * Get component of application from container of components
	 *
	 * @param $component_name
	 *
	 * @return bool| object | BaseComponent
	 */
	public function get_component( $component_name ) {
		$di = static::$_di;

		try {
			return $di->get( $component_name );
		} catch ( \Exception $e ) {
			return null;
		}
	}

	/**
	 * Load a config to the Enpii App config
	 *
	 * @param $config
	 */
	public static function load_config( $config ) {
		static::$config = ArrayHelper::merge( static::$config, $config );
	}

	/**
	 * Return id of the application
	 * @return string
	 */
	public function get_id() {
		return $this->_id;
	}

	/**
	 * Return base path of application
	 * @return string
	 */
	public function get_base_path() {
		return $this->_basePath;
	}

	/**
	 * Return the WpTheme object
	 * @return WpTheme
	 */
	public function get_wp_theme() {
		return $this->wp_theme;
	}
}