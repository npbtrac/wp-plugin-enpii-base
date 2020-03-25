<?php


namespace Enpii\Wp\EnpiiBase\Libs\Traits;


trait ComponentTrait {
	/**
	 * @var string
	 */
	public $text_domain = 'default';

	/**
	 * @param null $config
	 */
	protected function init_config( $config = null ) {
		if ( ! empty( $config ) ) {
			foreach ( (array) $config as $key => $value ) {
				if ( property_exists( get_class( $this ), $key ) ) {
					$this->$key = $value;
				}
			}
		}
	}
}