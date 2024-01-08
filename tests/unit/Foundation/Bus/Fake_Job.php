<?php


namespace Enpii_Base\Tests\Unit\Foundation\Bus;

use Illuminate\Foundation\Bus\Dispatchable;

class Fake_Job {

	use Dispatchable;

	public function __construct( $arg1, $arg2 ) {
		$this->init( $arg1, $arg2 );
	}

	public function init( $arg1, $arg2 ) {
	}
}
