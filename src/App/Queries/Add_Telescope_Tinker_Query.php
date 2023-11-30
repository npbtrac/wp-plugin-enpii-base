<?php

declare(strict_types=1);

namespace Enpii_Base\App\Queries;

use Enpii_Base\Foundation\Bus\Dispatchable_Trait;
use Enpii_Base\Foundation\Shared\Base_Query;

class Add_Telescope_Tinker_Query extends Base_Query {

	use Dispatchable_Trait;

	private array $providers = [];

	public function __construct( array $providers ) {
		$this->providers = $providers;
	}

	public function handle(): array {
		$providers = array_merge(
			$this->providers,
			[
				\Enpii_Base\App\Providers\Telescope_Service_Provider::class,
				\Enpii_Base\App\Providers\Tinker_Service_Provider::class,
			]
		);

		return $providers;
	}
}
