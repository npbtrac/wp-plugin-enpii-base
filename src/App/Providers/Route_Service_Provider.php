<?php

declare(strict_types=1);

namespace Enpii\Wp_Plugin\Enpii_Base\App\Providers;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades\Route;

class Route_Service_Provider extends RouteServiceProvider {

	/**
	 * This namespace is applied to your controller routes.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'Enpii\Wp_Plugin\Enpii_Base\App\Http\Controllers';

	/**
	 * The path to the "home" route for your application.
	 *
	 * @var string
	 */
	public const HOME = '/home';

	/**
	 * Define the routes for the application.
	 *
	 * @return void
	 */
	public function map() {
		Route::prefix( '/wp-app' )
			->group(
				function () {
					do_action( 'enpii_base_wp_app_register_routes' );
				}
			);
	}
}
