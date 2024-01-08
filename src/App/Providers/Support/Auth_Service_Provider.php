<?php

declare(strict_types=1);

namespace Enpii_Base\App\Providers\Support;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Laravel\Passport\Passport;

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
		if ( method_exists( Passport::class, 'routes' ) ) {
			Passport::routes(
				null,
				[
					'prefix' => ENPII_BASE_WP_APP_PREFIX . '/oauth',
				]
			);
		}

		Passport::tokensExpireIn( now()->addMinutes( 30 ) );
		Passport::refreshTokensExpireIn( now()->addDays( 30 ) );
		Passport::personalAccessTokensExpireIn( now()->addDays( 180 ) );
	}
}
