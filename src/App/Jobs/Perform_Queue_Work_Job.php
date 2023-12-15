<?php

namespace Enpii_Base\App\Jobs;

use Enpii_Base\Foundation\Bus\Dispatchable_Trait;
use Enpii_Base\Foundation\Shared\Base_Job;
use Illuminate\Support\Facades\Artisan;

class Perform_Queue_Work_Job extends Base_Job {
	use Dispatchable_Trait;

	public function handle() {
		Artisan::call(
			'queue:work',
			[
				'connection' => 'database',
				'--queue' => 'high,default,low',
				'--tries' => 3,
				'--quiet' => true,
				'--stop-when-empty' => true,
				'--timeout' => 60,
				'--memory' => 256,
			]
		);
	}
}
