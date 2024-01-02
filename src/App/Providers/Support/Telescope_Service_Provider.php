<?php

declare(strict_types=1);

namespace Enpii_Base\App\Providers\Support;

use Enpii_Base\App\Support\App_Const;
use Laravel\Telescope\TelescopeServiceProvider;

class Telescope_Service_Provider extends TelescopeServiceProvider {
	public function register() {
		$this->fetch_config();

		parent::register();
	}

	protected function fetch_config(): void {
		wp_app_config(
			[
				'telescope' => apply_filters(
					App_Const::FILTER_WP_APP_TELESCOPE_CONFIG,
					$this->get_default_config()
				),
			]
		);
	}

	protected function get_default_config(): array {
		$config = [
			/*
			|--------------------------------------------------------------------------
			| Telescope Domain
			|--------------------------------------------------------------------------
			|
			| This is the subdomain where Telescope will be accessible from. If the
			| setting is null, Telescope will reside under the same domain as the
			| application. Otherwise, this value will be used as the subdomain.
			|
			*/

			'domain' => env( 'WP_APP_TELESCOPE_DOMAIN' ),

			/*
			|--------------------------------------------------------------------------
			| Telescope Path
			|--------------------------------------------------------------------------
			|
			| This is the URI path where Telescope will be accessible from. Feel free
			| to change this path to anything you like. Note that the URI will not
			| affect the paths of its internal API that aren't exposed to users.
			|
			*/

			'path' => env( 'WP_APP_TELESCOPE_PATH', ENPII_BASE_WP_APP_PREFIX . '/telescope' ),

			/*
			|--------------------------------------------------------------------------
			| Telescope Storage Driver
			|--------------------------------------------------------------------------
			|
			| This configuration options determines the storage driver that will
			| be used to store Telescope's data. In addition, you may set any
			| custom options as needed by the particular driver you choose.
			|
			*/

			'driver' => env( 'WP_APP_TELESCOPE_DRIVER', 'database' ),

			'storage' => [
				'database' => [
					'connection' => env( 'DB_CONNECTION', 'mysql' ),
					'chunk' => 1000,
				],
			],

			/*
			|--------------------------------------------------------------------------
			| Telescope Master Switch
			|--------------------------------------------------------------------------
			|
			| This option may be used to disable all Telescope watchers regardless
			| of their individual configuration, which simply provides a single
			| and convenient way to enable or disable Telescope data storage.
			|
			*/

			'enabled' => env( 'WP_APP_TELESCOPE_ENABLED', true ),

			/*
			|--------------------------------------------------------------------------
			| Telescope Route Middleware
			|--------------------------------------------------------------------------
			|
			| These middleware will be assigned to every Telescope route, giving you
			| the chance to add your own middleware to this list or change any of
			| the existing middleware. Or, you can simply stick with this list.
			|
			*/

			'middleware' => [
				'web',
			],

			/*
			|--------------------------------------------------------------------------
			| Allowed / Ignored Paths & Commands
			|--------------------------------------------------------------------------
			|
			| The following array lists the URI paths and Artisan commands that will
			| not be watched by Telescope. In addition to this list, some Laravel
			| commands, like migrations and queue commands, are always ignored.
			|
			*/

			'only_paths' => [
				// 'api/*'
			],

			'ignore_paths' => [
				'nova-api*',
			],

			'ignore_commands' => [
				//
			],

			/*
			|--------------------------------------------------------------------------
			| Telescope Watchers
			|--------------------------------------------------------------------------
			|
			| The following array lists the "watchers" that will be registered with
			| Telescope. The watchers gather the application's profile data when
			| a request or task is executed. Feel free to customize this list.
			|
			*/

			'watchers' => [
				\Laravel\Telescope\Watchers\CacheWatcher::class => [
					'enabled' => env( 'WP_APP_TELESCOPE_CACHE_WATCHER', true ),
					'hidden' => [],
				],

				\Laravel\Telescope\Watchers\CommandWatcher::class => [
					'enabled' => env( 'WP_APP_TELESCOPE_COMMAND_WATCHER', true ),
					'ignore' => [],
				],

				\Laravel\Telescope\Watchers\DumpWatcher::class => [
					'enabled' => env( 'WP_APP_TELESCOPE_DUMP_WATCHER', true ),
					'always' => env( 'WP_APP_TELESCOPE_DUMP_WATCHER_ALWAYS', false ),
				],

				\Laravel\Telescope\Watchers\EventWatcher::class => [
					'enabled' => env( 'WP_APP_TELESCOPE_EVENT_WATCHER', true ),
					'ignore' => [],
				],

				\Laravel\Telescope\Watchers\ExceptionWatcher::class => env( 'WP_APP_TELESCOPE_EXCEPTION_WATCHER', true ),

				\Laravel\Telescope\Watchers\JobWatcher::class => env( 'WP_APP_TELESCOPE_JOB_WATCHER', true ),

				\Laravel\Telescope\Watchers\LogWatcher::class => [
					'enabled' => env( 'WP_APP_TELESCOPE_LOG_WATCHER', true ),
					'level' => 'error',
				],

				\Laravel\Telescope\Watchers\MailWatcher::class => env( 'WP_APP_TELESCOPE_MAIL_WATCHER', true ),

				\Laravel\Telescope\Watchers\ModelWatcher::class => [
					'enabled' => env( 'WP_APP_TELESCOPE_MODEL_WATCHER', true ),
					'events' => [ 'eloquent.*' ],
					'hydrations' => true,
				],

				\Laravel\Telescope\Watchers\NotificationWatcher::class => env( 'TELESCOPE_NOTIFICATION_WATCHER', true ),

				\Laravel\Telescope\Watchers\QueryWatcher::class => [
					'enabled' => env( 'WP_APP_TELESCOPE_QUERY_WATCHER', true ),
					'ignore_packages' => true,
					'ignore_paths' => [],
					'slow' => 100,
				],

				\Laravel\Telescope\Watchers\RequestWatcher::class => [
					'enabled' => env( 'WP_APP_TELESCOPE_REQUEST_WATCHER', true ),
					'size_limit' => env( 'WP_APP_TELESCOPE_RESPONSE_SIZE_LIMIT', 64 ),
					'ignore_http_methods' => [],
					'ignore_status_codes' => [],
				],

				\Laravel\Telescope\Watchers\ScheduleWatcher::class => env( 'WP_APP_TELESCOPE_SCHEDULE_WATCHER', true ),
				\Laravel\Telescope\Watchers\ViewWatcher::class => env( 'WP_APP_TELESCOPE_VIEW_WATCHER', true ),
			],
		];

		if ( class_exists( \Laravel\Telescope\Watchers\GateWatcher::class ) ) {
			$config['watchers'][ \Laravel\Telescope\Watchers\GateWatcher::class ] = [
				'enabled' => env( 'WP_APP_TELESCOPE_GATE_WATCHER', true ),
				'ignore_abilities' => [],
				'ignore_packages' => true,
				'ignore_paths' => [],
			];
		}

		if ( class_exists( \Laravel\Telescope\Watchers\BatchWatcher::class ) ) {
			$config['watchers'][ \Laravel\Telescope\Watchers\BatchWatcher::class ] = env( 'WP_APP_TELESCOPE_BATCH_WATCHER', true );
		}

		if ( class_exists( \Laravel\Telescope\Watchers\ClientRequestWatcher::class ) ) {
			$config['watchers'][ \Laravel\Telescope\Watchers\ClientRequestWatcher::class ] = env( 'WP_APP_TELESCOPE_CLIENT_REQUEST_WATCHER', true );
		}

		return $config;
	}
}
