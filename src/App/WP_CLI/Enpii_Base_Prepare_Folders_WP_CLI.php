<?php

declare(strict_types=1);

namespace Enpii_Base\App\WP_CLI;

use Enpii_Base\App\Jobs\Prepare_WP_App_Folders_Job;
use WP_CLI;

class Enpii_Base_Prepare_Folders_WP_CLI {
	public function __invoke( $args ) {
        Prepare_WP_App_Folders_Job::dispatchSync();

		// Return 0 to tell that everything is alright
		exit(0);
    }
}
