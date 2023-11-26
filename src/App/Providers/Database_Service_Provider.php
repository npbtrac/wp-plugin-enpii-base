<?php

declare(strict_types=1);

namespace Enpii_Base\App\Providers;

use Illuminate\Database\DatabaseServiceProvider;

class Database_Service_Provider extends DatabaseServiceProvider {
	public function register() {
		$this->before_register();

		parent::register();
	}

	protected function before_register(): void {
		wp_app_config(
			[
				'database' => apply_filters(
					'enpii_base_wp_app_database_config',
					$this->get_default_config()
				),
			]
		);
	}

	protected function get_default_config(): array {
		$default_mysql_config = [
			'driver' => 'mysql',
			'host' => DB_HOST,
			'port' => DB_PORT,
			'database' => DB_NAME,
			'username' => DB_USER,
			'password' => DB_PASSWORD,
		];

		if (defined('DB_SOCKET') && !empty(DB_SOCKET) && empty($default_mysql_config['host'])) {
			$default_mysql_config['socker'] = DB_SOCKET;
			unset($default_mysql_config['host'], $default_mysql_config['port']);
		}

		if (defined('DB_CHARSET') && !empty(DB_CHARSET)) {
			$default_mysql_config['charset'] = DB_CHARSET;
		}

		if (defined('DB_TABLE_PREFIX') && !empty(DB_TABLE_PREFIX)) {
			$default_mysql_config['prefix'] = DB_TABLE_PREFIX;
		}

		if (defined('DB_COLLATE') && !empty(DB_COLLATE)) {
			$default_mysql_config['collate'] = DB_COLLATE;
		}

		if (defined('DB_STRICT_MODE') && !empty(DB_STRICT_MODE)) {
			$default_mysql_config['strict'] = DB_STRICT_MODE;
		}

		if (defined('DB_ENGINE') && !empty(DB_ENGINE)) {
			$default_mysql_config['engine'] = DB_ENGINE;
		}

		$config = [

			/*
			|--------------------------------------------------------------------------
			| Default Database Connection Name
			|--------------------------------------------------------------------------
			|
			| Here you may specify which of the database connections below you wish
			| to use as your default connection for all database work. Of course
			| you may use many connections at once using the Database library.
			|
			*/

			'default' => env('DB_CONNECTION', 'mysql'),

			/*
			|--------------------------------------------------------------------------
			| Database Connections
			|--------------------------------------------------------------------------
			|
			| Here are each of the database connections setup for your application.
			| Of course, examples of configuring each database platform that is
			| supported by Laravel is shown below to make development simple.
			|
			|
			| All database work in Laravel is done through the PHP PDO facilities
			| so make sure you have the driver for your particular database of
			| choice installed on your machine before you begin development.
			|
			*/

			'connections' => [
				'mysql' => $default_mysql_config,
				'mysql_logs' => $default_mysql_config,
				'mysql_queues' => $default_mysql_config,
			],

			/*
			|--------------------------------------------------------------------------
			| Migration Repository Table
			|--------------------------------------------------------------------------
			|
			| This table keeps track of all the migrations that have already run for
			| your application. Using this information, we can determine which of
			| the migrations on disk haven't actually been run in the database.
			|
			*/
			'migrations' => 'zzz_migrations',
		];

		return $config;
	}
}
