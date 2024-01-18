<?php

namespace Enpii_Base\App\Jobs;

use Enpii_Base\Foundation\Shared\Base_Job;
use Enpii_Base\Foundation\Support\Executable_Trait;

class Bootstrap_WP_App_Job extends Base_Job {
	use Executable_Trait;

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(): void {
		/** @var \Enpii_Base\App\WP\WP_Application $wp_app  */
		$wp_app = wp_app();
		$wp_app['env'] = wp_app_config( 'app.env' );

		$wp_app->singleton(
			\Illuminate\Contracts\Http\Kernel::class,
			\Enpii_Base\App\Http\Kernel::class
		);

		$wp_app->singleton(
			\Illuminate\Contracts\Console\Kernel::class,
			\Enpii_Base\App\Console\Kernel::class
		);

		$wp_app->singleton(
			\Illuminate\Contracts\Debug\ExceptionHandler::class,
			\Enpii_Base\App\Exceptions\Handler::class
		);

		// As we may not use Contracts\Kernel::handle(), we need to call bootstrap method
		//  to iinitialize all boostrappers
		/** @var \Enpii_Base\App\Http\Kernel $http_kernel */
		$http_kernel = $wp_app->make( \Illuminate\Contracts\Http\Kernel::class );
		$http_kernel->capture_request();
		$http_kernel->bootstrap();

		/** @var \Enpii_Base\App\Console\Kernel $http_kernel */
		$console_kernel = $wp_app->make( \Illuminate\Contracts\Console\Kernel::class );
		$console_kernel->bootstrap();
	}
}
