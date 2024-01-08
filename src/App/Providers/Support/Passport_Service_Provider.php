<?php

declare(strict_types=1);

namespace Enpii_Base\App\Providers\Support;

use Enpii_Base\App\Support\App_Const;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\PassportServiceProvider;
use Laravel\Passport\PersonalAccessClient;
use phpseclib\Crypt\RSA as LegacyRSA;
use phpseclib3\Crypt\RSA;

class Passport_Service_Provider extends PassportServiceProvider {
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {
		$this->fetch_config();

		parent::register();
	}

	public function boot() {
		$passport_config = wp_app_config( 'passport' );
		$passport_config = $this->refine_private_public_keys( $passport_config );
		$passport_config = $this->refine_personal_access_client( $passport_config );

		// Re-adjust passport config
		wp_app_config(
			[
				'passport' => $passport_config,
			]
		);

		parent::boot();
	}

	protected function refine_private_public_keys( $passport_config ): array {
		if ( empty( $passport_config['public_key'] || $passport_config['private_key'] ) ) {
			$length = 4096;
			if ( class_exists( LegacyRSA::class ) ) {
				$keys = ( new LegacyRSA() )->createKey( $length );

				$public_key = Arr::get( $keys, 'publickey' );
				$private_key = Arr::get( $keys, 'privatekey' );
			} else {
				$key = RSA::createKey( $length );

				$public_key = (string) $key->getPublicKey();
				$private_key = (string) $key;
			}

			$passport_config['public_key'] = $public_key;
			$passport_config['private_key'] = $private_key;
			add_option( 'wp_app_passport_public_key', $public_key );
			add_option( 'wp_app_passport_private_key', $private_key );
		}

		return $passport_config;
	}

	protected function refine_personal_access_client( $passport_config ): array {
		if ( empty( $passport_config['personal_access_client']['id'] ) ||
			empty( $passport_config['personal_access_client']['secret'] ) ||
			( Schema::hasTable( 'oauth_personal_access_clients' ) && empty( PersonalAccessClient::find( $passport_config['personal_access_client']['id'] ) ) )
		) {
			$clients = new ClientRepository();
			$client = $clients->createPersonalAccessClient(
				null,
				config( 'app.name' ),
				site_url()
			);
			$personal_access_client_id = $client->getKey();
			$personal_access_client_secret = $client->plainSecret;

			$passport_config['personal_access_client']['id'] = $personal_access_client_id;
			$passport_config['personal_access_client']['secret'] = $personal_access_client_secret;
			add_option( 'wp_app_personal_access_client_id', $personal_access_client_id );
			add_option( 'wp_app_personal_access_client_secret', $personal_access_client_secret );
		}

		return $passport_config;
	}

	protected function fetch_config(): void {
		$default_config = $this->get_default_config();
		wp_app_config(
			[
				'passport' => apply_filters(
					App_Const::FILTER_WP_APP_PASSPORT_CONFIG,
					$default_config
				),
			]
		);
	}

	protected function get_default_config() {
		return [
			'path' => ENPII_BASE_WP_APP_PREFIX . '/oauth',

			/*
			|--------------------------------------------------------------------------
			| Passport Guard
			|--------------------------------------------------------------------------
			|
			| Here you may specify which authentication guard Passport will use when
			| authenticating users. This value should correspond with one of your
			| guards that is already present in your "auth" configuration file.
			|
			*/

			'guard' => 'web',

			/*
			|--------------------------------------------------------------------------
			| Encryption Keys
			|--------------------------------------------------------------------------
			|
			| Passport uses encryption keys while generating secure access tokens for
			| your application. By default, the keys are stored as local files but
			| can be set via environment variables when that is more convenient.
			|
			*/

			'private_key' => get_option( 'wp_app_passport_private_key' ),

			'public_key' => get_option( 'wp_app_passport_public_key' ),

			/*
			|--------------------------------------------------------------------------
			| Client UUIDs
			|--------------------------------------------------------------------------
			|
			| By default, Passport uses auto-incrementing primary keys when assigning
			| IDs to clients. However, if Passport is installed using the provided
			| --uuids switch, this will be set to "true" and UUIDs will be used.
			|
			*/

			'client_uuids' => false,

			/*
			|--------------------------------------------------------------------------
			| Personal Access Client
			|--------------------------------------------------------------------------
			|
			| If you enable client hashing, you should set the personal access client
			| ID and unhashed secret within your environment file. The values will
			| get used while issuing fresh personal access tokens to your users.
			|
			*/

			'personal_access_client' => [
				'id' => get_option( 'wp_app_personal_access_client_id' ),
				'secret' => get_option( 'wp_app_personal_access_client_secret' ),
			],
		];
	}
}
