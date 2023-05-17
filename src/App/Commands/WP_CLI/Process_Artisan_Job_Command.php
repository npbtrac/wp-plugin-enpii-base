<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\Commands\WP_CLI;

use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Base_Job_Command;

class Process_Artisan_Job_Command extends Base_Job_Command {
	public function handle(): void {
		/** @var \Enpii\WP_Plugin\Enpii_Base\App\Console\Kernel $kernel */
		$kernel = wp_app()->make(
			\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Console\Kernel::class
		);

		// We need to remove 2 first items to match the artisan arguments
		$args = $_SERVER['argv'];
		array_shift($args);
		array_shift($args);

		$input = new \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Input\ArgvInput( $args );

		$status = $kernel->handle(
		 	$input,
			new \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Output\ConsoleOutput
		);

		exit($status);
	}
}
