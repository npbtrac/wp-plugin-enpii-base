<?php

namespace Enpii_Base\App\Jobs;

use Enpii_Base\App\Http\Response;
use Enpii_Base\App\Support\App_Const;
use Enpii_Base\Foundation\Shared\Base_Job;
use Enpii_Base\Foundation\Support\Executable_Trait;

class Conclude_WP_App_Request_Job extends Base_Job {
	use Executable_Trait;

	public function handle() {
		// We only want to run this
		do_action( App_Const::ACTION_WP_APP_COMPLETE_EXECUTION );

		if ( \function_exists( 'fastcgi_finish_request' ) ) {
			fastcgi_finish_request();
		} elseif ( \function_exists( 'litespeed_finish_request' ) ) {
			litespeed_finish_request();
		} elseif ( ! \in_array( \PHP_SAPI, [ 'cli', 'phpdbg' ], true ) ) {
			Response::closeOutputBuffers( 0, true );
			flush();
		}

		/** @var \Illuminate\Foundation\Http\Kernel $kernel */
		$kernel = wp_app()->make( \Illuminate\Contracts\Http\Kernel::class );
		$kernel->terminate( wp_app_request(), wp_app_response() );
	}
}
