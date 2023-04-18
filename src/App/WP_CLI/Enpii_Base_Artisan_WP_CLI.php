<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\WP_CLI;

class Enpii_Base_Artisan_WP_CLI {
	public function __invoke( $args, $options ) {
		/** @var \Enpii\WP_Plugin\Enpii_Base\App\Console\Kernel $kernel */
		$kernel = wp_app()->make( \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Console\Kernel::class );

		// We need to prepend an item to the array before passing to ArgvInput
		array_unshift($args, ['artisan']);
		$input = new \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Input\ArgvInput($args);

		$status = $kernel->handle(
		 	$input,
			new \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\Output\ConsoleOutput
		);

		exit($status);
    }
}
