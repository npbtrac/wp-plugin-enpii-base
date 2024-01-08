<?php

declare(strict_types=1);

namespace Enpii_Base\App\Queries;

use Enpii_Base\Foundation\Shared\Base_Query;
use Enpii_Base\Foundation\Support\Executable_Trait;

class Add_More_Providers_Query extends Base_Query {

	use Executable_Trait;

	private $providers = [];

	public function __construct( array $providers ) {
		$this->providers = $providers;
	}

	public function handle(): array {
		$more_providers = [];
		if ( defined( 'WP_APP_TELESCOPE_ENABLED' ) && WP_APP_TELESCOPE_ENABLED ) {
			$more_providers[] = \Enpii_Base\App\Providers\Support\Telescope_Service_Provider::class;
		}

		if ( defined( 'WP_APP_TINKER_ENABLED' ) && WP_APP_TINKER_ENABLED ) {
			$more_providers[] = \Enpii_Base\App\Providers\Support\Tinker_Service_Provider::class;
		}

		if ( defined( 'WP_APP_PASSPORT_ENABLED' ) && WP_APP_PASSPORT_ENABLED ) {
			$more_providers[] = \Enpii_Base\App\Providers\Support\Passport_Service_Provider::class;
		}


		$providers = array_merge(
			$this->providers,
			$more_providers
		);

		return $providers;
	}
}
