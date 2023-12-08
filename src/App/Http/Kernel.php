<?php

declare(strict_types=1);

namespace Enpii_Base\App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * These middleware are run during every request to your application.
	 *
	 * @var array
	 */
	protected $middleware = [
	];

	/**
     * The bootstrap classes for the application.
	 * As we are loading configurations from memory (array) with WP_Application
	 * 	we don't need to load config from files.
	 * 	So we exclude `\Illuminate\Foundation\Bootstrap\LoadConfiguration`
     *
     * @var array
     */
    protected $bootstrappers = [
		\Illuminate\Foundation\Bootstrap\HandleExceptions::class,
        \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
        \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
        \Illuminate\Foundation\Bootstrap\BootProviders::class,
    ];

	/**
	 * The application's route middleware groups.
	 *
	 * @var array
	 */
	protected $middlewareGroups = [
		'web' => [],
		'api' => [],
	];

	/**
	 * The application's route middleware.
	 *
	 * These middleware may be assigned to groups or used individually.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'wp_user_session_validation' => \Enpii_Base\App\Http\Middleware\WP_User_Session_Validation::class,
		'wp_user_session_is_admin_user_validation' => \Enpii_Base\App\Http\Middleware\WP_User_Session_Is_Admin_User_Validation::class,
	];
}
