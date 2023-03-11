<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Base\Hook_Handlers;

use Enpii\WP_Plugin\Enpii_Base\Libs\WP_Base_Hook_Handler;

class WP_App_Hook_Handler extends WP_Base_Hook_Handler {
	public function handle(): void {
		$wp_app = wp_app();
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

		$this->process_http_request();
		// dev_logger(memory_get_usage());
	}

	public function process_http_request(): void {
		$wp_app = wp_app();

		/** @var \Enpii\WP_Plugin\Enpii_Base\App\Http\Kernel $kernel */
		$kernel = $wp_app->make( \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Http\Kernel::class );

		$request = \Enpii\WP_Plugin\Enpii_Base\App\Http\Request::capture();
		$response = $kernel->handle( $request );

		$response->send();
		$kernel->terminate( $request, $response );
	}
}
