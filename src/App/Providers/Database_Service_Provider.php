<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\Providers;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database\DatabaseServiceProvider;

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
					[

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

							'mysql' => [
								'driver' => 'mysql',
								'host' => DB_HOST,
								'port' => DB_PORT,
								'database' => DB_NAME,
								'username' => DB_USER,
								'password' => DB_PASSWORD,
								'unix_socket' => DB_SOCKET,
								'charset' => DB_CHARSET,
								'collation' => DB_COLLATE,
								'prefix' => DB_TABLE_PREFIX,
								'strict' => DB_STRICT_MODE,
								'engine' => DB_ENGINE,
							],

							'mysql_logs' => [
								'driver' => 'mysql',
								'host' => DB_HOST,
								'port' => DB_PORT,
								'database' => DB_NAME,
								'username' => DB_USER,
								'password' => DB_PASSWORD,
								'unix_socket' => DB_SOCKET,
								'charset' => DB_CHARSET,
								'collation' => DB_COLLATE,
								'prefix' => DB_TABLE_PREFIX,
								'strict' => DB_STRICT_MODE,
								'engine' => DB_ENGINE,
							],

							'mysql_queues' => [
								'driver' => 'mysql',
								'host' => DB_HOST,
								'port' => DB_PORT,
								'database' => DB_NAME,
								'username' => DB_USER,
								'password' => DB_PASSWORD,
								'unix_socket' => DB_SOCKET,
								'charset' => DB_CHARSET,
								'collation' => DB_COLLATE,
								'prefix' => DB_TABLE_PREFIX,
								'strict' => DB_STRICT_MODE,
								'engine' => DB_ENGINE,
							],

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

						'migrations' => 'migrations',
					]
				),
			]
		);
	}
}
