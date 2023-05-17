<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\Commands;

use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Base_Job_Command;
use Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Traits\Accessor_Set_Get_Has_Trait;

class Register_Main_Service_Providers_Job_Command extends Base_Job_Command {
	use Accessor_Set_Get_Has_Trait;

	protected $providers = [];

	public function __construct(array $providers)
	{
		$this->set_providers($providers);
	}

	public function handle( ): void {
		$wp_app = wp_app();
		foreach ($this->get_providers() as $provider_classname) {
			$wp_app->register( $provider_classname );
		}
	}
}
