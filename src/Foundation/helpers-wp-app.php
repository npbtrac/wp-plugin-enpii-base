<?php
/**
| We want to define helper functions for the wp_app here
| We don't need to use the prefix for these functions
| This helper will add the prefix 'wp_app'
| to the base Laravel \Illuminate\Support\helpers.php
| to use with WP_Application rather than the Application from Laravel
*/

declare(strict_types=1);

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Contracts\Broadcasting\Factory as BroadcastFactory;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Cookie\Factory as CookieFactory;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Foundation\Mix;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Queue\CallQueuedClosure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\HtmlString;
use Symfony\Component\HttpFoundation\Response;
use Enpii_Base\App\WP\WP_Application;
use Illuminate\Routing\Router;

if ( ! function_exists( 'wp_app_abort' ) ) {
	/**
	 * Throw an HttpException with the given data.
	 *
	 * @param  \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Support\Responsable|int  $code
	 * @param  string  $message
	 * @param  array  $headers
	 * @return void
	 *
	 * @throws \Symfony\Component\HttpKernel\Exception\HttpException
	 * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	function wp_app_abort( $code, $message = '', array $headers = [] ) {
		if ( $code instanceof Response ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped
			throw new HttpResponseException( $code );
		} elseif ( $code instanceof Responsable ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped
			throw new HttpResponseException( $code->toResponse( wp_app_request() ) );
		}

		wp_app()->abort( $code, $message, $headers );
	}
}

if ( ! function_exists( 'wp_app_abort_if' ) ) {
	/**
	 * Throw an HttpException with the given data if the given condition is true.
	 *
	 * @param  bool  $boolean
	 * @param  \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Support\Responsable|int  $code
	 * @param  string  $message
	 * @param  array  $headers
	 * @return void
	 *
	 * @throws \Symfony\Component\HttpKernel\Exception\HttpException
	 * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	function wp_app_abort_if( $boolean, $code, $message = '', array $headers = [] ) {
		if ( $boolean ) {
			wp_app_abort( $code, $message, $headers );
		}
	}
}

if ( ! function_exists( 'wp_app_abort_unless' ) ) {
	/**
	 * Throw an HttpException with the given data unless the given condition is true.
	 *
	 * @param  bool  $boolean
	 * @param  \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Support\Responsable|int  $code
	 * @param  string  $message
	 * @param  array  $headers
	 * @return void
	 *
	 * @throws \Symfony\Component\HttpKernel\Exception\HttpException
	 * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	function wp_app_abort_unless( $boolean, $code, $message = '', array $headers = [] ) {
		if ( ! $boolean ) {
			wp_app_abort( $code, $message, $headers );
		}
	}
}

if ( ! function_exists( 'wp_app_action' ) ) {
	/**
	 * Generate the URL to a controller action.
	 *
	 * @param  string|array  $name
	 * @param  mixed  $parameters
	 * @param  bool  $absolute
	 * @return string
	 */
	function wp_app_action( $name, $parameters = [], $absolute = true ) {
		return wp_app( 'url' )->action( $name, $parameters, $absolute );
	}
}

if ( ! function_exists( 'wp_app' ) ) {
	/**
	 * Get the available container instance.
	 *
	 * @param  string|null  $abstract
	 * @param  array  $parameters
	 * @return mixed|\Enpii_Base\App\WP\WP_Application
	 */
	// phpcs:ignore Universal.NamingConventions.NoReservedKeywordParameterNames.abstractFound
	function wp_app( $abstract = null, array $parameters = [] ) {
		if ( is_null( $abstract ) ) {
			return WP_Application::getInstance();
		}

		return WP_Application::getInstance()->make( $abstract, $parameters );
	}
}

if ( ! function_exists( 'wp_app_path' ) ) {
	/**
	 * Get the path to the application folder.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function wp_app_path( $path = '' ) {
		return wp_app()->path( $path );
	}
}

if ( ! function_exists( 'wp_app_asset' ) ) {
	/**
	 * Generate an asset path for the application.
	 *
	 * @param  string  $path
	 * @param  bool|null  $secure
	 * @return string
	 */
	function wp_app_asset( $path, $secure = null ) {
		return wp_app( 'url' )->asset( $path, $secure );
	}
}

if ( ! function_exists( 'wp_app_auth' ) ) {
	/**
	 * Get the available auth instance.
	 *
	 * @param  string|null  $guard
	 * @return \Illuminate\Contracts\Auth\Factory|\Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
	 */
	function wp_app_auth( $guard = null ) {
		if ( is_null( $guard ) ) {
			return wp_app( AuthFactory::class );
		}

		return wp_app( AuthFactory::class )->guard( $guard );
	}
}

if ( ! function_exists( 'wp_app_back' ) ) {
	/**
	 * Create a new redirect response to the previous location.
	 *
	 * @param  int  $status
	 * @param  array  $headers
	 * @param  mixed  $fallback
	 * @return \Illuminate\Http\RedirectResponse
	 */
	function wp_app_back( $status = 302, $headers = [], $fallback = false ) {
		return wp_app( 'redirect' )->back( $status, $headers, $fallback );
	}
}

if ( ! function_exists( 'wp_app_base_path' ) ) {
	/**
	 * Get the path to the base of the install.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function wp_app_base_path( $path = '' ) {
		return wp_app()->basePath( $path );
	}
}

if ( ! function_exists( 'wp_app_bcrypt' ) ) {
	/**
	 * Hash the given value against the bcrypt algorithm.
	 *
	 * @param  string  $value
	 * @param  array  $options
	 * @return string
	 */
	function wp_app_bcrypt( $value, $options = [] ) {
		return wp_app( 'hash' )->driver( 'bcrypt' )->make( $value, $options );
	}
}

if ( ! function_exists( 'wp_app_broadcast' ) ) {
	/**
	 * Begin broadcasting an event.
	 *
	 * @param  mixed|null  $event
	 * @return \Illuminate\Broadcasting\PendingBroadcast
	 */
	function wp_app_broadcast( $event = null ) {
		return wp_app( BroadcastFactory::class )->event( $event );
	}
}

if ( ! function_exists( 'wp_app_cache' ) ) {
	/**
	 * Get / set the specified cache value.
	 *
	 * If an array is passed, we'll assume you want to put to the cache.
	 *
	 * @param  dynamic  key|key,default|data,expiration|null
	 * @return mixed|\Illuminate\Cache\CacheManager
	 *
	 * @throws \Exception
	 */
	function wp_app_cache() {
		$arguments = func_get_args();

		if ( empty( $arguments ) ) {
			return wp_app( 'cache' );
		}

		if ( is_string( $arguments[0] ) ) {
			return wp_app( 'cache' )->get( ...$arguments );
		}

		if ( ! is_array( $arguments[0] ) ) {
			throw new Exception(
				'When setting a value in the cache, you must pass an array of key / value pairs.'
			);
		}

		return wp_app( 'cache' )->put( key( $arguments[0] ), reset( $arguments[0] ), $arguments[1] ?? null );
	}
}

if ( ! function_exists( 'wp_app_collect' ) ) {
	/**
	 * Create a collection from the given value.
	 *
	 * @param  mixed  $value
	 * @return \Illuminate\Support\Collection
	 */
	function wp_app_collect( $value = null ) {
		return new Collection( $value );
	}
}

if ( ! function_exists( 'wp_app_config' ) ) {
	/**
	 * Get / set the specified configuration value.
	 *
	 * If an array is passed as the key, we will assume you want to set an array of values.
	 *
	 * @param  array|string|null  $key
	 * @param  mixed  $default_value
	 *
	 * @return mixed|\Illuminate\Config\Repository
	 */
	function wp_app_config( $key = null, $default_value = null ) {
		if ( is_null( $key ) ) {
			return wp_app( 'config' );
		}

		if ( is_array( $key ) ) {
			return wp_app( 'config' )->set( $key );
		}

		return wp_app( 'config' )->get( $key, $default_value );
	}
}

if ( ! function_exists( 'wp_app_config_path' ) ) {
	/**
	 * Get the configuration path.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function wp_app_config_path( $path = '' ) {
		return wp_app()->configPath( $path );
	}
}

if ( ! function_exists( 'wp_app_cookie' ) ) {
	/**
	 * Create a new cookie instance.
	 *
	 * @param  string|null  $name
	 * @param  string|null  $value
	 * @param  int  $minutes
	 * @param  string|null  $path
	 * @param  string|null  $domain
	 * @param  bool|null  $secure
	 * @param  bool  $httpOnly
	 * @param  bool  $raw
	 * @param  string|null  $sameSite
	 * @return \Illuminate\Cookie\CookieJar|\Symfony\Component\HttpFoundation\Cookie
	 */
	function wp_app_cookie( $name = null, $value = null, $minutes = 0, $path = null, $domain = null, $secure = null, $httpOnly = true, $raw = false, $sameSite = null ) {
		$cookie = wp_app( CookieFactory::class );

		if ( is_null( $name ) ) {
			return $cookie;
		}

		return $cookie->make( $name, $value, $minutes, $path, $domain, $secure, $httpOnly, $raw, $sameSite );
	}
}

if ( ! function_exists( 'wp_app_csrf_field' ) ) {
	/**
	 * Generate a CSRF token form field.
	 *
	 * @return \Illuminate\Support\HtmlString
	 */
	function wp_app_csrf_field() {
		return new HtmlString( '<input type="hidden" name="_token" value="' . wp_app_csrf_token() . '">' );
	}
}

if ( ! function_exists( 'wp_app_csrf_token' ) ) {
	/**
	 * Get the CSRF token value.
	 *
	 * @return string
	 *
	 * @throws \RuntimeException
	 */
	function wp_app_csrf_token() {
		$session = wp_app( 'session' );

		if ( isset( $session ) ) {
			return $session->token();
		}

		throw new RuntimeException( 'Application session store not set.' );
	}
}

if ( ! function_exists( 'wp_app_database_path' ) ) {
	/**
	 * Get the database path.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function wp_app_database_path( $path = '' ) {
		return wp_app()->databasePath( $path );
	}
}

if ( ! function_exists( 'wp_app_decrypt' ) ) {
	/**
	 * Decrypt the given value.
	 *
	 * @param  string  $value
	 * @param  bool  $unserialize
	 * @return mixed
	 */
	function wp_app_decrypt( $value, $unserialize = true ) {
		return wp_app( 'encrypter' )->decrypt( $value, $unserialize );
	}
}

if ( ! function_exists( 'wp_app_dispatch' ) ) {
	/**
	 * Dispatch a job to its appropriate handler.
	 *
	 * @param  mixed  $job
	 * @return \Illuminate\Foundation\Bus\PendingDispatch
	 */
	function wp_app_dispatch( $job ) {
		if ( $job instanceof Closure ) {
			$job = CallQueuedClosure::create( $job );
		}

		return new PendingDispatch( $job );
	}
}

if ( ! function_exists( 'wp_app_dispatch_now' ) ) {
	/**
	 * Dispatch a command to its appropriate handler in the current process.
	 *
	 * @param  mixed  $job
	 * @param  mixed  $handler
	 * @return mixed
	 */
	function wp_app_dispatch_now( $job, $handler = null ) {
		/** @var Dispatcher $dispatcher */
		$dispatcher = wp_app( Dispatcher::class );
		return method_exists( $dispatcher, 'dispatchNow' ) ? $dispatcher->dispatchNow( $job, $handler ) : $dispatcher->dispatchSync( $job, $handler );
	}
}

if ( ! function_exists( 'wp_app_dispatch_sync' ) ) {
	/**
	 * Dispatch a command to its appropriate handler in the current process.
	 *
	 * @param  mixed  $job
	 * @param  mixed  $handler
	 * @return mixed
	 */
	function wp_app_dispatch_sync( $job, $handler = null ) {
		/** @var Dispatcher $dispatcher */
		$dispatcher = wp_app( Dispatcher::class );
		return method_exists( $dispatcher, 'dispatchSync' ) ? $dispatcher->dispatchSync( $job, $handler ) : $dispatcher->dispatchNow( $job, $handler );
	}
}

if ( ! function_exists( 'wp_app_elixir' ) ) {
	/**
	 * Get the path to a versioned Elixir file.
	 *
	 * @param  string  $file
	 * @param  string  $buildDirectory
	 * @return string
	 *
	 * @throws \InvalidArgumentException
	 *
	 * @deprecated Use Laravel Mix instead.
	 */
	function wp_app_elixir( $file, $buildDirectory = 'build' ) {
		static $manifest = [];
		static $manifestPath;

		if ( empty( $manifest ) || $manifestPath !== $buildDirectory ) {
			$path = wp_app_public_path( $buildDirectory . '/rev-manifest.json' );

			if ( file_exists( $path ) ) {
				// phpcs:ignore WordPressVIPMinimum.Performance.FetchingRemoteData.FileGetContentsUnknown
				$manifest = json_decode( file_get_contents( $path ), true );
				$manifestPath = $buildDirectory;
			}
		}

		$file = ltrim( $file, '/' );

		if ( isset( $manifest[ $file ] ) ) {
			return '/' . trim( $buildDirectory . '/' . $manifest[ $file ], '/' );
		}

		$unversioned = wp_app_public_path( $file );

		if ( file_exists( $unversioned ) ) {
			return '/' . trim( $file, '/' );
		}

		// phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped
		throw new InvalidArgumentException( "File {$file} not defined in asset manifest." );
	}
}

if ( ! function_exists( 'wp_app_encrypt' ) ) {
	/**
	 * Encrypt the given value.
	 *
	 * @param  mixed  $value
	 * @param  bool  $serialize
	 * @return string
	 */
	function wp_app_encrypt( $value, $serialize = true ) {
		return wp_app( 'encrypter' )->encrypt( $value, $serialize );
	}
}

if ( ! function_exists( 'wp_app_event' ) ) {
	/**
	 * Dispatch an event and call the listeners.
	 *
	 * @param  string|object  $event
	 * @param  mixed  $payload
	 * @param  bool  $halt
	 * @return array|null
	 */
	function wp_app_event( ...$args ) {
		return wp_app( 'events' )->dispatch( ...$args );
	}
}

if ( ! function_exists( 'wp_app_factory' ) ) {
	/**
	 * Create a model factory builder for a given class and amount.
	 *
	 * @param  string  $class_object
	 * @param  int  $amount
	 *
	 * @return \Illuminate\Database\Eloquent\FactoryBuilder
	 */
	// phpcs:ignore Universal.NamingConventions.NoReservedKeywordParameterNames.abstractFound
	function wp_app_factory( $class_object, $amount = null ) {
		$factory = wp_app( EloquentFactory::class );

		if ( isset( $amount ) && is_int( $amount ) ) {
			return $factory->of( $class_object )->times( $amount );
		}

		return $factory->of( $class_object );
	}
}

if ( ! function_exists( 'wp_app_info' ) ) {
	/**
	 * Write some information to the log.
	 *
	 * @param  string  $message
	 * @param  array  $context
	 * @return void
	 */
	function wp_app_info( $message, $context = [] ) {
		wp_app( 'log' )->info( $message, $context );
	}
}

if ( ! function_exists( 'wp_app_logger' ) ) {
	/**
	 * Log a debug message to the logs.
	 *
	 * @param  string|null  $message
	 * @param  array  $context
	 * @return \Illuminate\Log\LogManager|null
	 */
	function wp_app_logger( $message = null, array $context = [] ) {
		if ( is_null( $message ) ) {
			return wp_app( 'log' );
		}

		return wp_app( 'log' )->debug( $message, $context );
	}
}

if ( ! function_exists( 'wp_app_logs' ) ) {
	/**
	 * Get a log driver instance.
	 *
	 * @param  string|null  $driver
	 * @return \Illuminate\Log\LogManager|\Psr\Log\LoggerInterface
	 */
	function wp_app_logs( $driver = null ) {
		return $driver ? wp_app( 'log' )->driver( $driver ) : wp_app( 'log' );
	}
}

if ( ! function_exists( 'wp_app_method_field' ) ) {
	/**
	 * Generate a form field to spoof the HTTP verb used by forms.
	 *
	 * @param  string  $method
	 * @return \Illuminate\Support\HtmlString
	 */
	function wp_app_method_field( $method ) {
		return new HtmlString( '<input type="hidden" name="_method" value="' . $method . '">' );
	}
}

if ( ! function_exists( 'wp_app_mix' ) ) {
	/**
	 * Get the path to a versioned Mix file.
	 *
	 * @param  string  $path
	 * @param  string  $manifestDirectory
	 * @return \Illuminate\Support\HtmlString|string
	 *
	 * @throws \Exception
	 */
	// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.FoundAfterLastUsed
	function wp_app_mix( $path, $manifestDirectory = '' ) {
		return wp_app( Mix::class )( ...func_get_args() );
	}
}

if ( ! function_exists( 'wp_app_now' ) ) {
	/**
	 * Create a new Carbon instance for the current time.
	 *
	 * @param  \DateTimeZone|string|null  $tz
	 * @return \Illuminate\Support\Carbon
	 */
	function wp_app_now( $tz = null ) {
		return Date::now( $tz );
	}
}

if ( ! function_exists( 'wp_app_old' ) ) {
	/**
	 * Retrieve an old input item.
	 *
	 * @param  string|null  $key
	 * @param  mixed  $default_value
	 *
	 * @return mixed
	 */
	function wp_app_old( $key = null, $default_value = null ) {
		return wp_app( 'request' )->old( $key, $default_value );
	}
}

if ( ! function_exists( 'wp_app_policy' ) ) {
	/**
	 * Get a policy instance for a given class.
	 *
	 * @param  object|string  $class_object
	 *
	 * @return mixed
	 *
	 * @throws \InvalidArgumentException
	 */
	function wp_app_policy( $class_object ) {
		return wp_app( Gate::class )->getPolicyFor( $class_object );
	}
}

if ( ! function_exists( 'wp_app_precognitive' ) ) {
	/**
	 * Handle a Precognition controller hook.
	 *
	 * @param  null|callable  $callable_value
	 *
	 * @return mixed
	 */
	// phpcs:ignore PHPCompatibility.Operators.NewOperators.t_coalesce_equalFound
	function wp_app_precognitive( $callable_value = null ) {
		// phpcs:ignore PHPCompatibility.Operators.NewOperators.t_coalesce_equalFound
		$callable_value ??= function () {
			//
		};

		$payload = $callable_value(
			function ( $default_value, $precognition = null ) {
				$response = wp_app_request()->isPrecognitive()
				? ( $precognition ?? $default_value )
				: $default_value;

				wp_app_abort( Router::toResponse( request(), value( $response ) ) );
			}
		);

		if ( wp_app_request()->isPrecognitive() ) {
			wp_app_abort( 204, 'precognitive', [ 'Precognition-Success' => 'true' ] );
		}

		return $payload;
	}
}

if ( ! function_exists( 'wp_app_public_path' ) ) {
	/**
	 * Get the path to the public folder.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function wp_app_public_path( $path = '' ) {
		return wp_app()->make( 'path.public' ) . ( $path ? DIRECTORY_SEPARATOR . ltrim( $path, DIRECTORY_SEPARATOR ) : $path );
	}
}

if ( ! function_exists( 'wp_app_redirect' ) ) {
	/**
	 * Get an instance of the redirector.
	 *
	 * @param  string|null  $to
	 * @param  int  $status
	 * @param  array  $headers
	 * @param  bool|null  $secure
	 * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
	 */
	function wp_app_redirect( $to = null, $status = 302, $headers = [], $secure = null ) {
		if ( is_null( $to ) ) {
			return wp_app( 'redirect' );
		}

		return wp_app( 'redirect' )->to( $to, $status, $headers, $secure );
	}
}

if ( ! function_exists( 'wp_app_report' ) ) {
	/**
	 * Report an exception.
	 *
	 * @param  \Throwable  $exception
	 * @return void
	 */
	function wp_app_report( Throwable $exception ) {
		wp_app( ExceptionHandler::class )->report( $exception );
	}
}

if ( ! function_exists( 'wp_app_request' ) ) {
	/**
	 * Get an instance of the current request or an input item from the request.
	 *
	 * @param  array|string|null  $key
	 * @param  mixed  $default_value
	 *
	 * @return \Illuminate\Http\Request|string|array
	 */
	function wp_app_request( $key = null, $default_value = null ) {
		if ( is_null( $key ) ) {
			return wp_app( 'request' );
		}

		if ( is_array( $key ) ) {
			return wp_app( 'request' )->only( $key );
		}

		$value = wp_app( 'request' )->__get( $key );

		return is_null( $value ) ? value( $default_value ) : $value;
	}
}

if ( ! function_exists( 'wp_app_rescue' ) ) {
	/**
	 * Catch a potential exception and return a default value.
	 *
	 * @param  callable  $callback
	 * @param  mixed  $rescue
	 * @param  bool  $report
	 * @return mixed
	 */
	function wp_app_rescue( callable $callback, $rescue = null, $report = true ) {
		try {
			return $callback();
		} catch ( Throwable $e ) {
			if ( $report ) {
				report( $e );
			}

			return $rescue instanceof Closure ? $rescue( $e ) : $rescue;
		}
	}
}

if ( ! function_exists( 'wp_app_resolve' ) ) {
	/**
	 * Resolve a service from the container.
	 *
	 * @param  string  $name
	 * @param  array  $parameters
	 * @return mixed
	 */
	function wp_app_resolve( $name, array $parameters = [] ) {
		return wp_app( $name, $parameters );
	}
}

if ( ! function_exists( 'wp_app_resource_path' ) ) {
	/**
	 * Get the path to the resources folder.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function wp_app_resource_path( $path = '' ) {
		return wp_app()->resourcePath( $path );
	}
}

if ( ! function_exists( 'wp_app_response' ) ) {
	/**
	 * Return a new response from the application.
	 *
	 * @param  \Illuminate\View\View|string|array|null  $content
	 * @param  int  $status
	 * @param  array  $headers
	 * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
	 */
	function wp_app_response( $content = '', $status = 200, array $headers = [] ) {
		$factory = wp_app( ResponseFactory::class );

		if ( func_num_args() === 0 ) {
			return $factory;
		}

		return $factory->make( $content, $status, $headers );
	}
}

if ( ! function_exists( 'wp_app_route' ) ) {
	/**
	 * Generate the URL to a named route.
	 *
	 * @param  array|string  $name
	 * @param  mixed  $parameters
	 * @param  bool  $absolute
	 * @return string
	 */
	function wp_app_route( $name, $parameters = [], $absolute = true ) {
		return wp_app( 'url' )->route( $name, $parameters, $absolute );
	}
}

if ( ! function_exists( 'wp_app_secure_asset' ) ) {
	/**
	 * Generate an asset path for the application.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function wp_app_secure_asset( $path ) {
		return wp_app_asset( $path, true );
	}
}

if ( ! function_exists( 'wp_app_secure_url' ) ) {
	/**
	 * Generate a HTTPS url for the application.
	 *
	 * @param  string  $path
	 * @param  mixed  $parameters
	 * @return string
	 */
	function wp_app_secure_url( $path, $parameters = [] ) {
		return url( $path, $parameters, true );
	}
}

if ( ! function_exists( 'wp_app_session' ) ) {
	/**
	 * Get / set the specified session value.
	 *
	 * If an array is passed as the key, we will assume you want to set an array of values.
	 *
	 * @param  array|string|null  $key
	 * @param  mixed  $default_value
	 *
	 * @return mixed|\Illuminate\Session\Store|\Illuminate\Session\SessionManager
	 */
	function wp_app_session( $key = null, $default_value = null ) {
		if ( is_null( $key ) ) {
			return wp_app( 'session' );
		}

		if ( is_array( $key ) ) {
			return wp_app( 'session' )->put( $key );
		}

		return wp_app( 'session' )->get( $key, $default_value );
	}
}

if ( ! function_exists( 'wp_app_storage_path' ) ) {
	/**
	 * Get the path to the storage folder.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function wp_app_storage_path( $path = '' ) {
		return wp_app( 'path.storage' ) . ( $path ? DIRECTORY_SEPARATOR . $path : $path );
	}
}

if ( ! function_exists( 'wp_app_today' ) ) {
	/**
	 * Create a new Carbon instance for the current date.
	 *
	 * @param  \DateTimeZone|string|null  $tz
	 * @return \Illuminate\Support\Carbon
	 */
	function wp_app_today( $tz = null ) {
		return Date::today( $tz );
	}
}

if ( ! function_exists( 'wp_app_trans' ) ) {
	/**
	 * Translate the given message.
	 *
	 * @param  string|null  $key
	 * @param  array  $replace
	 * @param  string|null  $locale
	 * @return \Illuminate\Contracts\Translation\Translator|string|array|null
	 */
	function wp_app_trans( $key = null, $replace = [], $locale = null ) {
		if ( is_null( $key ) ) {
			return wp_app( 'translator' );
		}

		return wp_app( 'translator' )->get( $key, $replace, $locale );
	}
}

if ( ! function_exists( 'wp_app_trans_choice' ) ) {
	/**
	 * Translates the given message based on a count.
	 *
	 * @param  string  $key
	 * @param  \Countable|int|array  $number
	 * @param  array  $replace
	 * @param  string|null  $locale
	 * @return string
	 */
	function wp_app_trans_choice( $key, $number, array $replace = [], $locale = null ) {
		return wp_app( 'translator' )->choice( $key, $number, $replace, $locale );
	}
}

if ( ! function_exists( 'wp_app_url' ) ) {
	/**
	 * Generate a url for the application.
	 *
	 * @param  string|null  $path
	 * @param  mixed  $parameters
	 * @param  bool|null  $secure
	 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
	 */
	function wp_app_url( $path = null, $parameters = [], $secure = null ) {
		if ( is_null( $path ) ) {
			return wp_app( UrlGenerator::class );
		}

		return wp_app( UrlGenerator::class )->to( $path, $parameters, $secure );
	}
}

if ( ! function_exists( 'wp_app_validator' ) ) {
	/**
	 * Create a new Validator instance.
	 *
	 * @param  array  $data
	 * @param  array  $rules
	 * @param  array  $messages
	 * @param  array  $customAttributes
	 * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Contracts\Validation\Factory
	 */
	function wp_app_validator( array $data = [], array $rules = [], array $messages = [], array $customAttributes = [] ) {
		$factory = wp_app( ValidationFactory::class );

		if ( func_num_args() === 0 ) {
			return $factory;
		}

		return $factory->make( $data, $rules, $messages, $customAttributes );
	}
}

if ( ! function_exists( 'wp_app_view' ) ) {
	/**
	 * Get the evaluated view contents for the given view.
	 *
	 * @param  string|null  $view
	 * @param  \Illuminate\Contracts\Support\Arrayable|array  $data
	 * @param  array  $mergeData
	 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
	 */
	function wp_app_view( $view = null, $data = [], $mergeData = [] ) {
		$factory = wp_app( ViewFactory::class );

		if ( func_num_args() === 0 ) {
			return $factory;
		}

		return $factory->make( $view, $data, $mergeData );
	}
}
