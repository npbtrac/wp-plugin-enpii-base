<?php

declare(strict_types=1);

namespace Enpii_Base\App\Commands\WP_CLI;

use Enpii_Base\Foundation\Shared\Base_Job_Command;

class Process_Artisan_Job_Command extends Base_Job_Command {
	public function handle(): void {
		/** @var \Enpii_Base\App\Console\Kernel $kernel */
		$kernel = wp_app()->make(
			\Enpii_Base\Deps\Illuminate\Contracts\Console\Kernel::class
		);

		// We need to remove 2 first items to match the artisan arguments
		$args = $_SERVER['argv'];
		array_shift($args);
		array_shift($args);

		$input = new \Enpii_Base\Deps\Symfony\Component\Console\Input\ArgvInput( $args );

		$status = $kernel->handle(
		 	$input,
			new \Enpii_Base\Deps\Symfony\Component\Console\Output\ConsoleOutput
		);

		exit($status);
	}
}
