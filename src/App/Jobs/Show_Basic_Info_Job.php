<?php

namespace Enpii_Base\App\Jobs;

use Enpii_Base\Foundation\Bus\Dispatchable_Trait;
use Enpii_Base\Foundation\Jobs\Base_Job;
use WP_CLI;

class Show_Basic_Info_Job extends Base_Job
{
    use Dispatchable_Trait;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        WP_CLI::success(
			sprintf(
				'Running Enpii Base plugin version %s on WordPress %s and PHP %s',
				ENPII_BASE_PLUGIN_VERSION,
				get_bloginfo('version'),
				PHP_VERSION
			)
		);
    }
}
