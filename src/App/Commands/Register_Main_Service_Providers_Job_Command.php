<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\Commands;

use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Base_Job_Command;
use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Traits\Accessor_Set_Get_Has_Trait;

class Register_Main_Service_Providers_Job_Command extends Base_Job_Command {
	use Accessor_Set_Get_Has_Trait;

	protected $providers = [];

	public function __construct(array $providers = [])
	{
		if (empty($providers)) {
			$providers = [
				\Enpii\WP_Plugin\Enpii_Base\App\Providers\View_Service_Provider::class,
				\Enpii\WP_Plugin\Enpii_Base\App\Providers\Route_Service_Provider::class,
				\Enpii\WP_Plugin\Enpii_Base\App\Providers\Filesystem_Service_Provider::class,
				\Enpii\WP_Plugin\Enpii_Base\App\Providers\Cache_Service_Provider::class,
				\Enpii\WP_Plugin\Enpii_Base\App\Providers\Artisan_Service_Provider::class,
				\Enpii\WP_Plugin\Enpii_Base\App\Providers\Queue_Service_Provider::class,
				\Enpii\WP_Plugin\Enpii_Base\App\Providers\Database_Service_Provider::class,
				\Enpii\WP_Plugin\Enpii_Base\App\Providers\Composer_Service_Provider::class,
				\Enpii\WP_Plugin\Enpii_Base\App\Providers\Migration_Service_Provider::class,
				// \Enpii\WP_Plugin\Enpii_Base\App\Providers\Plates_Template_Service_Provider::class,
			];
		}
		$this->set_providers($providers);
	}

	public function handle( ): void {
		$wp_app = wp_app();
		foreach ($this->get_providers() as $provider_classname) {
			$wp_app->register( $provider_classname );
		}
	}
}
