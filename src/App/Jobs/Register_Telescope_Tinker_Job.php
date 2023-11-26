<?php

namespace Enpii_Base\App\Jobs;

use Enpii_Base\App\Providers\Telescope_Service_Provider;
use Enpii_Base\App\Providers\Tinker_Service_Provider;
use Enpii_Base\Foundation\Bus\Dispatchable_Trait;
use Enpii_Base\Foundation\Jobs\Base_Job;

class Register_Telescope_Tinker_Job extends Base_Job
{
    use Dispatchable_Trait;

	private array $providers = [];

	public function __construct(array $providers)
	{
		$this->providers = $providers;
	}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): array
    {
		$providers = array_merge($this->providers, [
			Telescope_Service_Provider::class,
			Tinker_Service_Provider::class,
		]);

		return $providers;
    }
}
