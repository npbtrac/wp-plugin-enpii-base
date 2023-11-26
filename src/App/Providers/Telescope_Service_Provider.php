<?php

declare(strict_types=1);

namespace Enpii_Base\App\Providers;

use Illuminate\Foundation\Application;
use Laravel\Telescope\TelescopeServiceProvider;

class Telescope_Service_Provider extends TelescopeServiceProvider {
	public function register() {
		$this->before_register();

		parent::register();
	}

	protected function before_register(): void {
		wp_app_config(
			[
				'telescope' => apply_filters(
					'enpii_base_wp_app_telescope_config',
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

			'domain' => env('TELESCOPE_DOMAIN'),

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

			'path' => env('TELESCOPE_PATH', ENPII_BASE_WP_APP_PREFIX. '/telescope'),

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

			'driver' => env('TELESCOPE_DRIVER', 'database'),

			'storage' => [
				'database' => [
					'connection' => env('DB_CONNECTION', 'mysql'),
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

			'enabled' => env('TELESCOPE_ENABLED', true),

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
					'enabled' => env('TELESCOPE_CACHE_WATCHER', true),
					'hidden' => [],
				],

				\Laravel\Telescope\Watchers\CommandWatcher::class => [
					'enabled' => env('TELESCOPE_COMMAND_WATCHER', true),
					'ignore' => [],
				],

				\Laravel\Telescope\Watchers\DumpWatcher::class => [
					'enabled' => env('TELESCOPE_DUMP_WATCHER', true),
					'always' => env('TELESCOPE_DUMP_WATCHER_ALWAYS', false),
				],

				\Laravel\Telescope\Watchers\EventWatcher::class => [
					'enabled' => env('TELESCOPE_EVENT_WATCHER', true),
					'ignore' => [],
				],

				\Laravel\Telescope\Watchers\ExceptionWatcher::class => env('TELESCOPE_EXCEPTION_WATCHER', true),

				\Laravel\Telescope\Watchers\JobWatcher::class => env('TELESCOPE_JOB_WATCHER', true),

				\Laravel\Telescope\Watchers\LogWatcher::class => [
					'enabled' => env('TELESCOPE_LOG_WATCHER', true),
					'level' => 'error',
				],

				\Laravel\Telescope\Watchers\MailWatcher::class => env('TELESCOPE_MAIL_WATCHER', true),

				\Laravel\Telescope\Watchers\ModelWatcher::class => [
					'enabled' => env('TELESCOPE_MODEL_WATCHER', true),
					'events' => ['eloquent.*'],
					'hydrations' => true,
				],

				\Laravel\Telescope\Watchers\NotificationWatcher::class => env('TELESCOPE_NOTIFICATION_WATCHER', true),

				\Laravel\Telescope\Watchers\QueryWatcher::class => [
					'enabled' => env('TELESCOPE_QUERY_WATCHER', true),
					'ignore_packages' => true,
					'ignore_paths' => [],
					'slow' => 100,
				],

				\Laravel\Telescope\Watchers\RequestWatcher::class => [
					'enabled' => env('TELESCOPE_REQUEST_WATCHER', true),
					'size_limit' => env('TELESCOPE_RESPONSE_SIZE_LIMIT', 64),
					'ignore_http_methods' => [],
					'ignore_status_codes' => [],
				],

				\Laravel\Telescope\Watchers\ScheduleWatcher::class => env('TELESCOPE_SCHEDULE_WATCHER', true),
				\Laravel\Telescope\Watchers\ViewWatcher::class => env('TELESCOPE_VIEW_WATCHER', true),
			],
		];

		if (class_exists(\Laravel\Telescope\Watchers\GateWatcher::class)) {
			$config['watchers'][\Laravel\Telescope\Watchers\GateWatcher::class] = [
				'enabled' => env('TELESCOPE_GATE_WATCHER', true),
				'ignore_abilities' => [],
				'ignore_packages' => true,
				'ignore_paths' => [],
			];
		}

		// We only want to have these Watches on Laravel 8+
		if (version_compare('8.0.0', Application::VERSION, '<=')) {
			if (class_exists(\Laravel\Telescope\Watchers\BatchWatcher::class)) {
				$config['watchers'][\Laravel\Telescope\Watchers\BatchWatcher::class] = env('TELESCOPE_BATCH_WATCHER', true);
			}

			if (class_exists(\Laravel\Telescope\Watchers\ClientRequestWatcher::class)) {
				$config['watchers'][\Laravel\Telescope\Watchers\ClientRequestWatcher::class] = env('TELESCOPE_CLIENT_REQUEST_WATCHER', true);
			}
		}

		$config['enabled'] = apply_filters('enpii_base_wp_app_telescope_enabled', $config['enabled']);

		return $config;
	}
}
