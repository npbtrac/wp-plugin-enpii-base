<?php

declare(strict_types=1);

namespace Enpii_Base\App\WP_CLI;

use Enpii_Base\App\Jobs\WP_CLI\Process_Artisan_Job;

class Enpii_Base_Artisan_WP_CLI {
	public function __invoke( $args, $options ) {
		Process_Artisan_Job::dispatchSync();
	}
}
