<?php

namespace Enpii_Base\App\Jobs;

use Enpii_Base\Foundation\Bus\Dispatchable_Trait;
use Enpii_Base\Foundation\Jobs\Base_Job;

class Init_WP_App_Bootstrap_Job extends Base_Job
{
    use Dispatchable_Trait;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
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
    }
}
