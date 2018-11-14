<?php
/**
 * Created by PhpStorm.
 * User: tracnguyen
 * Date: 10/22/18
 * Time: 4:03 PM
 */

namespace Enpii\Wp\EnpiiBase\Base;


abstract class BaseComponent {
	/* @var WpApp $appInstance */
	protected $appInstance = null;

	use ComponentTrait {
		ComponentTrait::__construct as protected __component_construct;
	}

	/**
	 * Instance constructor.
	 * Initialize values for object based on configuration array
	 *
	 * @param array $config
	 */
	public function __construct( array $config = null ) {
		$this->construct_instance( $config );
	}

	/**
	 * Build instance with params in config set
	 *
	 * @param $config
	 */
	public function construct_instance( $config ) {
		$this->__component_construct( $config );
	}

	/**
	 * Set app instance for the component
	 *
	 * @param $appInstance
	 */
	public function set_app_instance( $appInstance ) {
		if ( ! $this->appInstance ) {
			$this->appInstance = $appInstance;
		}
	}

	/**
	 * @param $component_name
	 *
	 * @return object|BaseComponent|null
	 */
	public function get_component( $component_name ) {
		return $this->appInstance ? $this->appInstance->get_component( $component_name ) : null;
	}

	/**
	 * Initialize things to be use in this component
	 * Should be override by child class
	 */
	abstract public function initialize();
}