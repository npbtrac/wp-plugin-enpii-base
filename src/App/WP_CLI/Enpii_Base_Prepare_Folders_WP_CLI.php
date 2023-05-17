<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\WP_CLI;

use Enpii\WP_Plugin\Enpii_Base\App\Commands\WP_CLI\Prepare_WP_App_Folders_Command_Handler;
use Enpii\WP_Plugin\Enpii_Base\App\Commands\WP_CLI\Prepare_WP_App_Folders_Job_Command;
use WP_CLI;

class Enpii_Base_Prepare_Folders_WP_CLI {
	public function __invoke( $args ) {
        Prepare_WP_App_Folders_Job_Command::dispatchNow();
		WP_CLI::success( 'Preparing needed folders for WP App done!' );

		// Return 0 to tell that everything is alright
		exit(0);
    }
}
