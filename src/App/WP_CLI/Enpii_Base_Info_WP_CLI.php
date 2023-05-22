<?php

declare(strict_types=1);

namespace Enpii_Base\App\WP_CLI;

use Enpii_Base\App\Commands\WP_CLI\Show_Basic_Info_Command_Handler;
use Enpii_Base\App\Commands\WP_CLI\Show_Basic_Info_Job_Command;

class Enpii_Base_Info_WP_CLI {
	public function __invoke( $args ) {
		Show_Basic_Info_Job_Command::dispatchNow();

		// Return 0 to tell that everything is alright
		exit(0);
    }
}
