<?php

return [
	/**
	|--------------------------------------------------------------------------
	| Application Name
	|--------------------------------------------------------------------------
	|
	| This value is the name of your application. This value is used when the
	| framework needs to place the application's name in a notification or
	| any other location as required by the application or its packages.
	|
	*/

	'name' => defined( 'WP_APP_NAME' ) ? WP_APP_NAME : 'Enpii Base Web App',

	/**
	|--------------------------------------------------------------------------
	| Application Environment
	|--------------------------------------------------------------------------
	|
	| This value determines the "environment" your application is currently
	| running in. This may determine how you prefer to configure various
	| services the application utilizes. Set this in your ".env" file.
	|
	*/

	'env' => defined( 'WP_ENV' ) ? WP_ENV : 'production',

	/**
	|--------------------------------------------------------------------------
	| Application Debug Mode
	|--------------------------------------------------------------------------
	|
	| When your application is in debug mode, detailed error messages with
	| stack traces will be shown on every error that occurs within your
	| application. If disabled, a simple generic error page is shown.
	|
	*/

	'debug' => defined( 'WP_DEBUG' ) ? WP_DEBUG : false,

	/**
	|--------------------------------------------------------------------------
	| Application URL
	|--------------------------------------------------------------------------
	|
	| This URL is used by the console to properly generate URLs when using
	| the Artisan command line tool. You should set this to the root of
	| your application so that it is used when running Artisan tasks.
	|
	*/

	'url' => defined( 'WP_HOME' ) ? WP_HOME : home_url(),

	'asset_url' => '/assets/wp-app',

	/**
	|--------------------------------------------------------------------------
	| Application Timezone
	|--------------------------------------------------------------------------
	|
	| Here you may specify the default timezone for your application, which
	| will be used by the PHP date and date-time functions. We have gone
	| ahead and set this to a sensible default for you out of the box.
	|
	*/

	'timezone' => defined( 'TIMEZONE' ) ? TIMEZONE : 'UTC',

	/**
	|--------------------------------------------------------------------------
	| Application Locale Configuration
	|--------------------------------------------------------------------------
	|
	| The application locale determines the default locale that will be used
	| by the translation service provider. You are free to set this value
	| to any of the locales which will be supported by the application.
	|
	*/

	'locale' => get_locale(),

	/**
	|--------------------------------------------------------------------------
	| Application Fallback Locale
	|--------------------------------------------------------------------------
	|
	| The fallback locale determines the locale to use when the current one
	| is not available. You may change the value to correspond to any of
	| the language folders that are provided through your application.
	|
	*/

	'fallback_locale' => 'en_US',

	/**
	|--------------------------------------------------------------------------
	| Faker Locale
	|--------------------------------------------------------------------------
	|
	| This locale will be used by the Faker PHP library when generating fake
	| data for your database seeds. For example, this will be used to get
	| localized telephone numbers, street address information and more.
	|
	*/

	'faker_locale' => get_locale(),

	/**
	|--------------------------------------------------------------------------
	| Encryption Key
	|--------------------------------------------------------------------------
	|
	| This key is used by the Illuminate encrypter service and should be set
	| to a random, 32 character string, otherwise these encrypted strings
	| will not be safe. Please do this before deploying an application!
	|
	*/

	'key' => defined( 'AUTH_KEY' ) ? AUTH_KEY : uniqid(),

	'cipher' => 'AES-256-CBC',

	'aliases' => [
		'App' => \Enpii_Base\Deps\Illuminate\Support\Facades\App::class,
        'Artisan' => \Enpii_Base\Deps\Illuminate\Support\Facades\Artisan::class,
        'Auth' => \Enpii_Base\Deps\Illuminate\Support\Facades\Auth::class,
        'Blade' => \Enpii_Base\Deps\Illuminate\Support\Facades\Blade::class,
        'Broadcast' => \Enpii_Base\Deps\Illuminate\Support\Facades\Broadcast::class,
        'Bus' => \Enpii_Base\Deps\Illuminate\Support\Facades\Bus::class,
        'Cache' => \Enpii_Base\Deps\Illuminate\Support\Facades\Cache::class,
        'Config' => \Enpii_Base\Deps\Illuminate\Support\Facades\Config::class,
        'Cookie' => \Enpii_Base\Deps\Illuminate\Support\Facades\Cookie::class,
        'Crypt' => \Enpii_Base\Deps\Illuminate\Support\Facades\Crypt::class,
        'DB' => \Enpii_Base\Deps\Illuminate\Support\Facades\DB::class,
        'Eloquent' => \Enpii_Base\Deps\Illuminate\Database\Eloquent\Model::class,
        'Event' => \Enpii_Base\Deps\Illuminate\Support\Facades\Event::class,
        'File' => \Enpii_Base\Deps\Illuminate\Support\Facades\File::class,
        'Gate' => \Enpii_Base\Deps\Illuminate\Support\Facades\Gate::class,
        'Hash' => \Enpii_Base\Deps\Illuminate\Support\Facades\Hash::class,
        'Lang' => \Enpii_Base\Deps\Illuminate\Support\Facades\Lang::class,
        'Log' => \Enpii_Base\Deps\Illuminate\Support\Facades\Log::class,
        'Mail' => \Enpii_Base\Deps\Illuminate\Support\Facades\Mail::class,
        'Notification' => \Enpii_Base\Deps\Illuminate\Support\Facades\Notification::class,
        'Password' => \Enpii_Base\Deps\Illuminate\Support\Facades\Password::class,
        'Queue' => \Enpii_Base\Deps\Illuminate\Support\Facades\Queue::class,
        'Redirect' => \Enpii_Base\Deps\Illuminate\Support\Facades\Redirect::class,
        'Redis' => \Enpii_Base\Deps\Illuminate\Support\Facades\Redis::class,
        'Request' => \Enpii_Base\Deps\Illuminate\Support\Facades\Request::class,
        'Response' => \Enpii_Base\Deps\Illuminate\Support\Facades\Response::class,
        'Route' => \Enpii_Base\Deps\Illuminate\Support\Facades\Route::class,
        'Schema' => \Enpii_Base\Deps\Illuminate\Support\Facades\Schema::class,
        'Session' => \Enpii_Base\Deps\Illuminate\Support\Facades\Session::class,
        'Storage' => \Enpii_Base\Deps\Illuminate\Support\Facades\Storage::class,
        'URL' => \Enpii_Base\Deps\Illuminate\Support\Facades\URL::class,
        'Validator' => \Enpii_Base\Deps\Illuminate\Support\Facades\Validator::class,
        'View' => \Enpii_Base\Deps\Illuminate\Support\Facades\View::class,
	],
];
