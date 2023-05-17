<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\WP_CLI;

use Enpii\WP_Plugin\Enpii_Base\App\Commands\WP_CLI\Process_Artisan_Job_Command;

class Enpii_Base_Artisan_WP_CLI {
	public function __invoke( $args, $options ) {
		Process_Artisan_Job_Command::dispatchNow();
    }
}
