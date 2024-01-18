<?php

namespace Enpii_Base\App\Jobs;

use Enpii_Base\App\Support\Traits\Queue_Trait;
use Enpii_Base\Foundation\Shared\Base_Job;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Artisan;

class Perform_Web_Worker_Job extends Base_Job {
	use Dispatchable;
	use Queue_Trait;

	public function handle() {
		// We want to try a job 3 times after marking it failed
		//  and we only want to retry a job 7 minutes after
		Artisan::call(
			'queue:work',
			[
				'connection' => $this->get_site_database_queue_connection(),
				'--queue' => $this->get_site_default_queue(),
				'--tries' => 3,
				'--backoff' => $this->get_queue_backoff(),
				'--quiet' => true,
				'--stop-when-empty' => true,
				'--timeout' => 60,
				'--memory' => 256,
			]
		);
	}
}
