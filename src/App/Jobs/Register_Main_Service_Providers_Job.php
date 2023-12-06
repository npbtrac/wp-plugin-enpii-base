<?php

namespace Enpii_Base\App\Jobs;

use Enpii_Base\Foundation\Bus\Dispatchable_Trait;
use Enpii_Base\Foundation\Shared\Base_Job;
use Enpii_Base\Foundation\Shared\Traits\Accessor_Set_Get_Has_Trait;
use Enpii_Base\Foundation\Shared\Traits\Config_Trait;

class Register_Main_Service_Providers_Job extends Base_Job {

	use Dispatchable_Trait;
	use Config_Trait;
	use Accessor_Set_Get_Has_Trait;

	protected $providers = [];

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct( array $config = [] ) {
		if ( ! empty( $config ) ) {
			$this->bind_config( $config, true );
		}
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(): void {
		$providers = ! empty( $this->get_providers() )
			? $this->get_providers()
			: [
				\Enpii_Base\App\Providers\View_Service_Provider::class,
				\Enpii_Base\App\Providers\Route_Service_Provider::class,
				\Enpii_Base\App\Providers\Filesystem_Service_Provider::class,
				\Enpii_Base\App\Providers\Cache_Service_Provider::class,
				\Enpii_Base\App\Providers\Artisan_Service_Provider::class,
				\Enpii_Base\App\Providers\Queue_Service_Provider::class,
				\Enpii_Base\App\Providers\Database_Service_Provider::class,
				\Enpii_Base\App\Providers\Composer_Service_Provider::class,
				\Enpii_Base\App\Providers\Migration_Service_Provider::class,
				\Enpii_Base\App\Providers\Session_Service_Provider::class,
				\Enpii_Base\App\Providers\Auth_Service_Provider::class,
				\Enpii_Base\App\Providers\Validation_Service_Provider::class,
				\Enpii_Base\App\Providers\Translation_Service_Provider::class,
			];
		// We want to use the the WordPress filter to allow changing the
		//  the Main Service Providers to load
		$providers = apply_filters(
			'enpii_base_wp_app_main_service_providers',
			$providers
		);

		foreach ( $providers as $provider_classname ) {
			wp_app()->register( $provider_classname );
		}
	}
}
