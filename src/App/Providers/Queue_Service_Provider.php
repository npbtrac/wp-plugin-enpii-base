<?php

declare(strict_types=1);

namespace Enpii_Base\App\Providers;

use Enpii_Base\Deps\Illuminate\Queue\QueueServiceProvider;

class Queue_Service_Provider extends QueueServiceProvider {
	public function register() {
		$this->before_register();

		parent::register();
	}

	protected function before_register(): void {
		wp_app_config(
			[
				'queue' => apply_filters(
					'enpii_base_wp_app_queue_config',
					[

						/*
						|--------------------------------------------------------------------------
						| Default Queue Driver
						|--------------------------------------------------------------------------
						|
						| Laravel's queue API supports an assortment of back-ends via a single
						| API, giving you convenient access to each back-end using the same
						| syntax for each one. Here you may set the default queue driver.
						|
						| Supported: "sync", "database", "beanstalkd", "sqs", "redis", "null"
						|
						*/

						'default' => env('QUEUE_DRIVER', 'sync'),

						/*
						|--------------------------------------------------------------------------
						| Queue Connections
						|--------------------------------------------------------------------------
						|
						| Here you may configure the connection information for each server that
						| is used by your application. A default configuration has been added
						| for each back-end shipped with Laravel. You are free to add more.
						|
						*/

						'connections' => [

							'sync' => [
								'driver' => 'sync',
							],

							'database' => [
								'driver' => 'database',
								'database' => 'mysql_queues',
								'table' => 'jobs',
								'queue' => 'default',
								'retry_after' => 90,
							],
						],

						/*
						|--------------------------------------------------------------------------
						| Failed Queue Jobs
						|--------------------------------------------------------------------------
						|
						| These options configure the behavior of failed queue job logging so you
						| can control which database and table are used to store the jobs that
						| have failed. You may change them to any database / table you wish.
						|
						*/

						'failed' => [
							'database' => 'mysql_queues',
							'table' => 'failed_jobs',
						],

					]
				),
			]
		);
	}
}
