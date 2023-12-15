<?php

namespace Enpii_Base\App\Jobs;

use Enpii_Base\Foundation\Shared\Base_Job;
use Enpii_Base\Foundation\Support\Executable_Trait;

class Process_WP_App_Request_Job extends Base_Job {
	use Executable_Trait;

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(): void {
		/** @var \Illuminate\Foundation\Http\Kernel $kernel */
		$kernel = wp_app()->make( \Illuminate\Contracts\Http\Kernel::class );

		/** @var \Enpii_Base\App\Http\Request $request */
		$request = \Enpii_Base\App\Http\Request::capture();
		$response = $kernel->handle( $request );

		// We don't want to call Response::send() here because we don't want
		//  to end the request here
		$response->sendHeaders();
		$response->sendContent();
	}
}
