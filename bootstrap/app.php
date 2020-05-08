<?php

$wp_app = new \Enpii\Wp\EnpiiBase\Libs\WpApp(
	dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

//$wp_app->singleton(
//	Illuminate\Contracts\Debug\ExceptionHandler::class,
//	\Enpii\Wp\EnpiiBase\App\Exceptions\Handler::class
//);
//
//$wp_app->singleton(
//	Illuminate\Contracts\Console\Kernel::class,
//	\Enpii\Wp\EnpiiBase\App\Console\Kernel::class
//);

/*
|--------------------------------------------------------------------------
| Initialize configs from array (instead of from files like Laravel sample did
|--------------------------------------------------------------------------
|
| You can use the hook `enpii-base/wp-app-config` to filter the configs
|
*/
$config = enpii_base_init_wp_app_config();
\Symfony\Component\VarDumper\VarDumper::dump($config);
$wp_app->initAppWithConfig( $config );
$wp_app->registerConfiguredProviders();

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $wp_app;
