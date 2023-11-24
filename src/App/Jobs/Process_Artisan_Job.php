<?php

namespace Enpii_Base\App\Jobs;

use Enpii_Base\Foundation\Bus\Dispatchable_Trait;
use Enpii_Base\Foundation\Jobs\Base_Job;

class Process_Artisan_Job extends Base_Job
{
    use Dispatchable_Trait;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        /** @var \Enpii_Base\App\Console\Kernel $kernel */
		$kernel = wp_app()->make(
			\Illuminate\Contracts\Console\Kernel::class
		);

		// We need to remove 2 first items to match the artisan arguments
		$args = $_SERVER['argv'];
		array_shift($args);
		array_shift($args);

		$input = new \Symfony\Component\Console\Input\ArgvInput( $args );

		$status = $kernel->handle(
		 	$input,
			new \Symfony\Component\Console\Output\ConsoleOutput
		);

		exit($status);
    }
}
