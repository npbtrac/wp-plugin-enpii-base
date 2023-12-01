<?php


namespace Enpii_Base\Tests\Unit\Foundation\Bus;

use Enpii_Base\Foundation\Bus\Dispatchable_Trait;

class Fake_Job {

	use Dispatchable_Trait;

	public function __construct( $arg1, $arg2 ) {
		$this->init( $arg1, $arg2 );
	}

	public function init( $arg1, $arg2 ) {
	}
}
