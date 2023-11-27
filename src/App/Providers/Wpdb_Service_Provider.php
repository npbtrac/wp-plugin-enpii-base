<?php

declare(strict_types=1);

namespace Enpii_Base\App\Providers;

use Illuminate\Support\ServiceProvider;

class Wpdb_Service_Provider extends ServiceProvider {
	/**
     * Bootstrap the application events.
     */
    public function boot()
    {
        // Model::setConnectionResolver($this->app['db']);
    }

	public function register() {
		$this->before_register();

		// Add database driver.
        $this->app->resolving('db', function ($db) {
            $db->extend('wpdb', function ($config, $name) {
                $config['name'] = $name;

                return new Wpdb_Connection($config);
            });
        });
	}

	protected function before_register(): void {
		wp_app_config(
			[
				'tinker' => apply_filters(
					'enpii_base_wp_app_wpdb_config',
					$this->get_default_config()
				),
			]
		);
	}

	protected function get_default_config(): array {
		$config = [

		];

		return $config;
	}
}
