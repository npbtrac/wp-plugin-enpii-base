<?php

declare(strict_types=1);

namespace Enpii_Base\App\Providers\Support;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

class Auth_Service_Provider extends AuthServiceProvider {
	/**
	 * The model to policy mappings for the application.
	 *
	 * @var array<class-string, class-string>
	 */
	protected $policies = [];

	/**
	 * Register any authentication / authorization services.
	 */
	public function boot(): void {
	}
}
