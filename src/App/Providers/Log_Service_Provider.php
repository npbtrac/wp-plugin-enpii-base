<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\Providers;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Log\LogServiceProvider;

class Log_Service_Provider extends LogServiceProvider {
	public function boot() {
		wp_app_config(
			[
				'logging' => apply_filters(
					'enpii_base_wp_app_logging_config',
					[
						'default'  => env( 'WP_APP_DEFAULT_LOG_CHANNEL', 'stack' ),
						'channels' => $this->generate_logging_channels(),
					]
				),
			]
		);
	}

	protected function generate_logging_channels(): array {
		/**
		|--------------------------------------------------------------------------
		| Log Channels
		|--------------------------------------------------------------------------
		|
		| Here you may configure the log channels for your application. Out of
		| the box, Laravel uses the Monolog PHP logging library. This gives
		| you a variety of powerful log handlers / formatters to utilize.
		|
		| Available Drivers: "single", "daily", "slack", "syslog",
		|                    "errorlog", "monolog",
		|                    "custom", "stack"
		|
		*/
		return [
			'stack' => [
				'driver'   => 'stack',
				'channels' => [ 'daily' ],
			],
			'single' => [
				'driver' => 'single',
				'path'   => wp_app_storage_path( '/logs' ) . '/laravel.log',
				'level'  => 'debug',
			],
			'daily' => [
				'driver' => 'daily',
				'path'   => wp_app_storage_path( '/logs' ) . '/laravel.log',
				'level'  => 'debug',
				'days'   => 14,
			],
			'stderr' => [
				'driver'  => 'monolog',
				'handler' => StreamHandler::class,
				'with'    => [
					'stream' => 'php://stderr',
				],
			],
			'syslog' => [
				'driver' => 'syslog',
				'level'  => 'debug',
			],
			'errorlog' => [
				'driver' => 'errorlog',
				'level'  => 'debug',
			],
		];
	}
}
