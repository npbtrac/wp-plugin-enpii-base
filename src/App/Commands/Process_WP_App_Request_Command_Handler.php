<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\Commands;

use Enpii\WP_Plugin\Enpii_Base\App\Commands\Process_WP_App_Request_Command;
use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Base_Command_Handler;

class Process_WP_App_Request_Command_Handler extends Base_Command_Handler {
	public function handle( Process_WP_App_Request_Command $command ): void {
		/** @var \Enpii\WP_Plugin\Enpii_Base\App\Http\Kernel $kernel */
		$wp_app = $command->get_wp_app();
		$kernel = $wp_app->make( \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Http\Kernel::class );

		$request = \Enpii\WP_Plugin\Enpii_Base\App\Http\Request::capture();
		$response = $kernel->handle( $request );

		$response->send();
		$kernel->terminate( $request, $response );
	}
}
