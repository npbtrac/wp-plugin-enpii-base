<?php

declare(strict_types=1);

namespace Enpii_Base\App\Providers;

use Enpii_Base\App\Http\Controllers\Index_Controller;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

class Route_Service_Provider extends RouteServiceProvider {

	/**
	 * This namespace is applied to your controller routes.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'Enpii_Base\App\Http\Controllers';

	/**
	 * The path to the "home" route for your application.
	 *
	 * @var string
	 */
	public const HOME = '/';

	/**
	 * Define the routes for the application.
	 *
	 * @return void
	 */
	public function map() {
		Route::prefix( '/' . wp_app()->get_wp_app_slug() )
			->group(
				function () {
					do_action( 'enpii_base_wp_app_register_routes' );
				}
			);

		Route::prefix( '/' . wp_app()->get_wp_api_slug() )
			->group(
				function () {
					do_action( 'enpii_base_wp_api_register_routes' );
				}
			);
	}
}
