<?php
/**
 * Created by PhpStorm.
 * Author: npbtrac@yahoo.com
 * Date time: 12/16/17 12:06 PM
 */

namespace Enpii\Wp\EnpiiCore\Base;


class Component {

	/* @var static singleton instance of this class */
	protected static $_instance = null;

	/**
	 * Component constructor.
	 * Initialize values for object based on configuration array
	 *
	 * @param null|array $config
	 */
	public function __construct( $config = null ) {
		if ( ! empty( $config ) ) {
			foreach ( (array) $config as $key => $value ) {
				if ( property_exists( get_class( $this ), $key ) ) {
					$this->$key = $value;
				}
			}
		}
	}

	/**
	 * Singleton
	 *
	 * @param null $configs
	 *
	 * @return static
	 */
	public static function instance( $configs = null ) {
		if ( null === static::$_instance ) {
			static::$_instance = new static( $configs );
		}

		return static::$_instance;
	}
}