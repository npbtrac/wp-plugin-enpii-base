<?php

declare(strict_types=1);

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Access\Gate;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Factory as AuthFactory;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Broadcasting\Factory as BroadcastFactory;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Bus\Dispatcher;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Cookie\Factory as CookieFactory;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Debug\ExceptionHandler;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Routing\ResponseFactory;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Routing\UrlGenerator;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Support\Responsable;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\View\Factory as ViewFactory;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Bus\PendingDispatch;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Mix;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Exceptions\HttpResponseException;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Queue\CallQueuedClosure;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Collection;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades\Date;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\HtmlString;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Response;
use Enpii\WP_Plugin\Enpii_Base\App\WP\WP_Application;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\VarDumper\VarDumper;

/**
| We want to define helper functions for the app here
| We don't need to use the prefix for these functions
|
*/

if ( ! function_exists( 'wp_app_abort' ) ) {
	/**
	 * Throw an HttpException with the given data.
	 *
	 * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Response|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Support\Responsable|int  $code
	 * @param  string  $message
	 * @param  array  $headers
	 * @return void
	 *
	 * @throws \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpKernel\Exception\HttpException
	 * @throws \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	function wp_app_abort( $code, $message = '', array $headers = [] ) {
		if ( $code instanceof Response ) {
			throw new HttpResponseException( $code );
		} elseif ( $code instanceof Responsable ) {
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
	 * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Response|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Support\Responsable|int  $code
	 * @param  string  $message
	 * @param  array  $headers
	 * @return void
	 *
	 * @throws \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpKernel\Exception\HttpException
	 * @throws \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpKernel\Exception\NotFoundHttpException
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
	 * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Response|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Support\Responsable|int  $code
	 * @param  string  $message
	 * @param  array  $headers
	 * @return void
	 *
	 * @throws \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpKernel\Exception\HttpException
	 * @throws \Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	function wp_app_abort_unless( $boolean, $code, $message = '', array $headers = [] ) {
		if ( ! $boolean ) {
			wp_app_abort( $code, $message, $headers );
		}
	}
}

if ( ! function_exists( 'wp_action' ) ) {
	/**
	 * Generate the URL to a controller action.
	 *
	 * @param  string|array  $name
	 * @param  mixed  $parameters
	 * @param  bool  $absolute
	 * @return string
	 */
	function wp_action( $name, $parameters = [], $absolute = true ) {
		return wp_app( 'url' )->action( $name, $parameters, $absolute );
	}
}

if ( ! function_exists( 'wp_app' ) ) {
	/**
	 * Get the available container instance.
	 *
	 * @param  string|null  $abstract
	 * @param  array  $parameters
	 * @return mixed|\Enpii\WP_Plugin\Enpii_Base\App\WP\WP_Application
	 */
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
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Factory|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\Guard|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Auth\StatefulGuard
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
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\RedirectResponse
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
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Broadcasting\PendingBroadcast
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
	 * @return mixed|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Cache\CacheManager
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
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Collection
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
	 * @param  mixed  $default
	 * @return mixed|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Config\Repository
	 */
	function wp_app_config( $key = null, $default = null ) {
		if ( is_null( $key ) ) {
			return wp_app( 'config' );
		}

		if ( is_array( $key ) ) {
			return wp_app( 'config' )->set( $key );
		}

		return wp_app( 'config' )->get( $key, $default );
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
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Cookie\CookieJar|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Cookie
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
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\HtmlString
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
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Foundation\Bus\PendingDispatch
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
		return wp_app( Dispatcher::class )->dispatchNow( $job, $handler );
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
	 * @param  string  $class
	 * @param  int  $amount
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Eloquent\FactoryBuilder
	 */
	function wp_app_factory( $class, $amount = null ) {
		$factory = wp_app( EloquentFactory::class );

		if ( isset( $amount ) && is_int( $amount ) ) {
			return $factory->of( $class )->times( $amount );
		}

		return $factory->of( $class );
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
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Log\LogManager|null
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
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Log\LogManager|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Psr\Log\LoggerInterface
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
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\HtmlString
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
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\HtmlString|string
	 *
	 * @throws \Exception
	 */
	function wp_app_mix( $path, $manifestDirectory = '' ) {
		return wp_app( Mix::class )( ...func_get_args() );
	}
}

if ( ! function_exists( 'wp_app_now' ) ) {
	/**
	 * Create a new Enpii\WP_Plugin\Enpii_Base\Dependencies\Carbon instance for the current time.
	 *
	 * @param  \DateTimeZone|string|null  $tz
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Carbon
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
	 * @param  mixed  $default
	 * @return mixed
	 */
	function wp_app_old( $key = null, $default = null ) {
		return wp_app( 'request' )->old( $key, $default );
	}
}

if ( ! function_exists( 'wp_app_policy' ) ) {
	/**
	 * Get a policy instance for a given class.
	 *
	 * @param  object|string  $class
	 * @return mixed
	 *
	 * @throws \InvalidArgumentException
	 */
	function wp_app_policy( $class ) {
		return wp_app( Gate::class )->getPolicyFor( $class );
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
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Routing\Redirector|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\RedirectResponse
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
	 * @param  mixed  $default
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Request|string|array
	 */
	function wp_app_request( $key = null, $default = null ) {
		if ( is_null( $key ) ) {
			return wp_app( 'request' );
		}

		if ( is_array( $key ) ) {
			return wp_app( 'request' )->only( $key );
		}

		$value = wp_app( 'request' )->__get( $key );

		return is_null( $value ) ? value( $default ) : $value;
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
	 * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\View\View|string|array|null  $content
	 * @param  int  $status
	 * @param  array  $headers
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http\Response|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Routing\ResponseFactory
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
	 * @param  mixed  $default
	 * @return mixed|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Session\Store|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Session\SessionManager
	 */
	function wp_app_session( $key = null, $default = null ) {
		if ( is_null( $key ) ) {
			return wp_app( 'session' );
		}

		if ( is_array( $key ) ) {
			return wp_app( 'session' )->put( $key );
		}

		return wp_app( 'session' )->get( $key, $default );
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
	 * Create a new Enpii\WP_Plugin\Enpii_Base\Dependencies\Carbon instance for the current date.
	 *
	 * @param  \DateTimeZone|string|null  $tz
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Carbon
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
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Translation\Translator|string|array|null
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
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Routing\UrlGenerator|string
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
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Validation\Validator|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Validation\Factory
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
	 * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Support\Arrayable|array  $data
	 * @param  array  $mergeData
	 * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\View\View|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\View\Factory
	 */
	function wp_app_view( $view = null, $data = [], $mergeData = [] ) {
		$factory = wp_app( ViewFactory::class );

		if ( func_num_args() === 0 ) {
			return $factory;
		}

		return $factory->make( $view, $data, $mergeData );
	}
}
