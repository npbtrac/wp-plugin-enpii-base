<?php

namespace Enpii_Base\App\Jobs\WP_CLI;

use Enpii_Base\Foundation\Bus\Dispatchable_Trait;
use Enpii_Base\Foundation\Shared\Base_Job;
use InvalidArgumentException;
use WP_CLI;

class Process_Artisan_Job extends Base_Job {

	use Dispatchable_Trait;

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(): void {
		/** @var \Enpii_Base\App\Console\Kernel $kernel */
		$kernel = wp_app()->make(
			\Illuminate\Contracts\Console\Kernel::class
		);

		// We need to remove 2 first items to match the artisan arguments
		$args = $_SERVER['argv'];
		if ( ! in_array( 'artisan', $args ) ) {
			throw new InvalidArgumentException( 'Not an artisan command' );
		}

		$artisan_args = [];
		foreach ( $args as $arg ) {
			if ( $arg === 'artisan' || ! empty( $artisan_args ) ) {
				$artisan_args[] = $arg;
			}
		}

		$input = new \Symfony\Component\Console\Input\ArgvInput( $artisan_args );

		$status = $kernel->handle(
			$input,
			new \Symfony\Component\Console\Output\ConsoleOutput()
		);

		exit( $status );
	}
}
