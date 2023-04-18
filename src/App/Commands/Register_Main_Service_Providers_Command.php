<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\Commands;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Foundation\Application;
use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Interfaces\Command_Interface;
use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Traits\Accessor_Set_Get_Has_Trait;
use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Traits\Config_Trait;

class Register_Main_Service_Providers_Command implements Command_Interface {
	private Application $wp_app;
	private array $providers;

	use Config_Trait;
	use Accessor_Set_Get_Has_Trait;

	public function __construct(Application $wp_app = null, array $providers = null)
	{
		$this->wp_app = !empty($wp_app) ? $wp_app : wp_app();
		$this->providers = !empty($providers) ? $providers :[
			\Enpii\WP_Plugin\Enpii_Base\App\Providers\Log_Service_Provider::class,
			\Enpii\WP_Plugin\Enpii_Base\App\Providers\View_Service_Provider::class,
			\Enpii\WP_Plugin\Enpii_Base\App\Providers\Route_Service_Provider::class,
			\Enpii\WP_Plugin\Enpii_Base\App\Providers\Filesystem_Service_Provider::class,
			\Enpii\WP_Plugin\Enpii_Base\App\Providers\Cache_Service_Provider::class,
			\Enpii\WP_Plugin\Enpii_Base\App\Providers\Artisan_Service_Provider::class,
			\Enpii\WP_Plugin\Enpii_Base\App\Providers\Queue_Service_Provider::class,
			\Enpii\WP_Plugin\Enpii_Base\App\Providers\Database_Service_Provider::class,
			\Enpii\WP_Plugin\Enpii_Base\App\Providers\Composer_Service_Provider::class,
			\Enpii\WP_Plugin\Enpii_Base\App\Providers\Migration_Service_Provider::class,
		];
	}
}
