<?php

namespace Enpii_Base\App\Jobs;

use Enpii_Base\Foundation\Bus\Dispatchable_Trait;
use Enpii_Base\Foundation\Jobs\Base_Job;
use Enpii_Base\Foundation\Shared\Traits\Accessor_Set_Get_Has_Trait;
use Enpii_Base\Foundation\Shared\Traits\Config_Trait;

class Register_Main_Service_Providers_Job extends Base_Job
{
    use Dispatchable_Trait;
    use Config_Trait;
	use Accessor_Set_Get_Has_Trait;

	protected $providers = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $config)
    {
        $this->bind_config($config, true);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
		foreach ($this->get_providers() as $provider_classname) {
			wp_app()->register( $provider_classname );
		}
    }
}
