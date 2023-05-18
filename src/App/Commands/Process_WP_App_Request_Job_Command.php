<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\Commands;

use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Base_Job_Command;

class Process_WP_App_Request_Job_Command extends Base_Job_Command {
	public function handle(): void {
		/** @var \Enpii\WP_Plugin\Enpii_Base\App\Http\Kernel $kernel */
		$wp_app = wp_app();
		$kernel = $wp_app->make( \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Http\Kernel::class );

		$request = \Enpii\WP_Plugin\Enpii_Base\App\Http\Request::capture();
		$response = $kernel->handle( $request );

		$response->send();
		$kernel->terminate( $request, $response );
	}
}
