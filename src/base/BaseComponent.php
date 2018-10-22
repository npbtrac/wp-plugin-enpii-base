<?php
/**
 * Created by PhpStorm.
 * User: tracnguyen
 * Date: 10/22/18
 * Time: 4:03 PM
 */

namespace Enpii\Wp\EnpiiBase\Base;


abstract class BaseComponent {
	use ComponentTrait {
		ComponentTrait::__construct as private __componentConstruct;
	}

	/**
	 * Instance constructor.
	 * Initialize values for object based on configuration array
	 *
	 * @param array $config
	 */
	public function __construct( array $config = null ) {
		$this->__componentConstruct( $config );

		$this->initialize();
	}

	/**
	 * Initialize theme with hooks
	 * Should be override by child class
	 */
	abstract public function initialize();
}