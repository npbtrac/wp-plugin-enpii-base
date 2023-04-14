<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\Commands;

use Enpii\WP_Plugin\Enpii_Base\App\Commands\Process_WP_App_Request_Command;
use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Base_Command_Handler;

class Process_WP_App_Request_Command_Handler extends Base_Command_Handler {
	public function handle( Process_WP_App_Request_Command $command ): void {
		$wp_app = $command->get_wp_app();
		$wp_app['env'] = wp_app_config( 'app.env' );

		$wp_app->singleton(
			\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Http\Kernel::class,
			\Enpii\WP_Plugin\Enpii_Base\App\Http\Kernel::class
		);

		$wp_app->singleton(
			\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Console\Kernel::class,
			\Enpii\WP_Plugin\Enpii_Base\App\Console\Kernel::class
		);

		$wp_app->singleton(
			\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Debug\ExceptionHandler::class,
			\Enpii\WP_Plugin\Enpii_Base\App\Exceptions\Handler::class
		);

		$this->process_http_request( $wp_app );
	}

	protected function process_http_request( $wp_app ): void {
		/** @var \Enpii\WP_Plugin\Enpii_Base\App\Http\Kernel $kernel */
		$kernel = $wp_app->make( \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Http\Kernel::class );

		$request = \Enpii\WP_Plugin\Enpii_Base\App\Http\Request::capture();
		$response = $kernel->handle( $request );

		$response->send();
		$kernel->terminate( $request, $response );
	}
}
