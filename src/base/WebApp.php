<?php
/**
 * Created by PhpStorm.
 * User: tracnguyen
 * Date: 7/30/18
 * Time: 3:40 PM
 */

namespace Enpii\Wp\EnpiiBase\Base;

use Aura\Di\ContainerBuilder;
use Aura\Di\Container;

class WebApp {
	/* @var static $_instance */
	protected static $_instance = null;

	// Find out more here https://github.com/auraphp/Aura.Di/blob/3.x/docs/index.md
	/* @var Container $_di */
	protected static $_di = null;

	public function __construct( $config ) {
		$di = static::$_di;

		if ( isset( $config['components'] ) && is_array( $components = $config['components'] ) ) {
			foreach ( $components as $component_name => $component_args ) {
				if ( isset( $component_args['class'] ) && $component_class = $component_args['class'] ) {
					unset( $component_args['class'] );

					// params needs to match the constructor
					$di->set( $component_name, $di->lazyNew( $component_class, [ 'config' => $component_args ] ) );
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
	public static function initialize( $config ) {
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
			die( 'WebApp singleton object not created yet. Please `initialize` it' );
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
}