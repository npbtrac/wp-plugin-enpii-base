<?php

namespace Enpii_Base\App\Jobs;

use Enpii_Base\Foundation\Bus\Dispatchable_Trait;
use Enpii_Base\Foundation\Shared\Base_Job;

class Process_WP_Api_Request_Job extends Base_Job {

	use Dispatchable_Trait;

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(): void {
		/** @var \Enpii_Base\App\Http\Kernel $kernel */
		$kernel = wp_app()->make( \Illuminate\Contracts\Http\Kernel::class );

		/** @var \Enpii_Base\App\Http\Request $request */
		$request = \Enpii_Base\App\Http\Request::capture();
		$response = $kernel->handle( $request );

		// We want to call WordPress shutdown action here
		do_action( 'shutdon' );
		$response->send();
		$kernel->terminate( $request, $response );
	}
}
