<?php

declare(strict_types=1);

namespace Enpii_Base\Foundation\Shared\Traits;

/**
 * This trait allows to get the protected/private propeties
 **/
trait Getter_Trait {
	public function __get( $name ) {
		$method_name = 'get_' . $name;
		if ( method_exists( $this, 'get_' . $name ) ) {
			return $this->$method_name();
		}

		return $this->$name;
	}
}
