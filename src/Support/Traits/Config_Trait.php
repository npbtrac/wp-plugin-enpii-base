<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Support\Traits;

use InvalidArgumentException;

trait Config_Trait {
	/**
	 * @param array $config
	 */
	public function bind_config( array $config = [], bool $strict = false ): void {
		if ( is_array( $config ) && ! empty( $config ) ) {
			foreach ( $config as $attr_name => $attr_value ) {
				if ( property_exists( $this, $attr_name ) ) {
					$this->$attr_name = $attr_value;
				} elseif ( $strict ) {
					throw new InvalidArgumentException( sprintf( 'Property "%s" does not exist in class "%s"', $attr_name, __CLASS__ ) );
				}
			}
		}
	}
}
