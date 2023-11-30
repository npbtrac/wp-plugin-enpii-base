<?php
/**
| This is the overriding helpers to \Illuminate\Foundation\helpers.php
 */

if ( ! function_exists( 'abort' ) ) {
	/**
	 * Throw an HttpException with the given data.
	 *
	 * @param  \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Support\Responsable|int  $code
	 * @param  string  $message
	 * @param  array  $headers
	 * @return never
	 *
	 * @throws \Symfony\Component\HttpKernel\Exception\HttpException
	 * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	function abort( $code, $message = '', array $headers = [] ) {
		wp_app_abort( $code, $message, $headers );
	}
}

if ( ! function_exists( 'abort_if' ) ) {
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
	function abort_if( $boolean, $code, $message = '', array $headers = [] ) {
		wp_app_abort_if( $boolean, $code, $message, $headers );
	}
}

if ( ! function_exists( 'abort_unless' ) ) {
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
	function abort_unless( $boolean, $code, $message = '', array $headers = [] ) {
		wp_app_abort_unless( $boolean, $code, $message, $headers );
	}
}

if ( ! function_exists( 'action' ) ) {
	/**
	 * Generate the URL to a controller action.
	 *
	 * @param  string|array  $name
	 * @param  mixed  $parameters
	 * @param  bool  $absolute
	 * @return string
	 */
	function action( $name, $parameters = [], $absolute = true ) {
		return wp_app_action( $name, $parameters = [], $absolute = true );
	}
}

if ( ! function_exists( 'app' ) ) {
	/**
	 * Get the available container instance.
	 *
	 * @param  string|null  $abstract
	 * @param  array  $parameters
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|mixed
	 */
	function app( $abstract = null, array $parameters = [] ) {
		return wp_app( $abstract, $parameters );
	}
}

if ( ! function_exists( 'app_path' ) ) {
	/**
	 * Get the path to the application folder.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function app_path( $path = '' ) {
		return wp_app_path( $path );
	}
}

if ( ! function_exists( 'asset' ) ) {
	/**
	 * Generate an asset path for the application.
	 *
	 * @param  string  $path
	 * @param  bool|null  $secure
	 * @return string
	 */
	function asset( $path, $secure = null ) {
		return wp_app_asset( $path, $secure );
	}
}

if ( ! function_exists( 'auth' ) ) {
	/**
	 * Get the available auth instance.
	 *
	 * @param  string|null  $guard
	 * @return \Illuminate\Contracts\Auth\Factory|\Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
	 */
	function auth( $guard = null ) {
		return wp_app_auth( $guard );
	}
}

if ( ! function_exists( 'back' ) ) {
	/**
	 * Create a new redirect response to the previous location.
	 *
	 * @param  int  $status
	 * @param  array  $headers
	 * @param  mixed  $fallback
	 * @return \Illuminate\Http\RedirectResponse
	 */
	function back( $status = 302, $headers = [], $fallback = false ) {
		return wp_app_back( $status, $headers, $fallback );
	}
}

if ( ! function_exists( 'base_path' ) ) {
	/**
	 * Get the path to the base of the install.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function base_path( $path = '' ) {
		return wp_app_base_path( $path );
	}
}

if ( ! function_exists( 'bcrypt' ) ) {
	/**
	 * Hash the given value against the bcrypt algorithm.
	 *
	 * @param  string  $value
	 * @param  array  $options
	 * @return string
	 */
	function bcrypt( $value, $options = [] ) {
		return wp_app_bcrypt( $value, $options );
	}
}

if ( ! function_exists( 'broadcast' ) ) {
	/**
	 * Begin broadcasting an event.
	 *
	 * @param  mixed|null  $event
	 * @return \Illuminate\Broadcasting\PendingBroadcast
	 */
	function broadcast( $event = null ) {
		return wp_app_broadcast( $event );
	}
}

if ( ! function_exists( 'cache' ) ) {
	/**
	 * Get / set the specified cache value.
	 *
	 * If an array is passed, we'll assume you want to put to the cache.
	 *
	 * @param  mixed  ...$arguments  key|key,default|data,expiration|null
	 * @return mixed|\Illuminate\Cache\CacheManager
	 *
	 * @throws \InvalidArgumentException
	 */
	function cache( ...$arguments ) {
		return wp_app_cache( ...$arguments );
	}
}

if ( ! function_exists( 'config' ) ) {
	/**
	 * Get / set the specified configuration value.
	 *
	 * If an array is passed as the key, we will assume you want to set an array of values.
	 *
	 * @param  array|string|null  $key
	 * @param  mixed  $default
	 * @return mixed|\Illuminate\Config\Repository
	 */
	function config( $key = null, $default = null ) {
		return wp_app_config( $key, $default );
	}
}

if ( ! function_exists( 'config_path' ) ) {
	/**
	 * Get the configuration path.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function config_path( $path = '' ) {
		return wp_app_config_path( $path );
	}
}

if ( ! function_exists( 'cookie' ) ) {
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
	function cookie( $name = null, $value = null, $minutes = 0, $path = null, $domain = null, $secure = null, $httpOnly = true, $raw = false, $sameSite = null ) {
		return wp_app_cookie( $name, $value, $minutes, $path, $domain, $secure, $httpOnly, $raw, $sameSite );
	}
}

if ( ! function_exists( 'csrf_field' ) ) {
	/**
	 * Generate a CSRF token form field.
	 *
	 * @return \Illuminate\Support\HtmlString
	 */
	function csrf_field() {
		return wp_app_csrf_field();
	}
}

if ( ! function_exists( 'csrf_token' ) ) {
	/**
	 * Get the CSRF token value.
	 *
	 * @return string
	 *
	 * @throws \RuntimeException
	 */
	function csrf_token() {
		return wp_app_csrf_token();
	}
}

if ( ! function_exists( 'database_path' ) ) {
	/**
	 * Get the database path.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function database_path( $path = '' ) {
		return wp_app_database_path( $path );
	}
}

if ( ! function_exists( 'decrypt' ) ) {
	/**
	 * Decrypt the given value.
	 *
	 * @param  string  $value
	 * @param  bool  $unserialize
	 * @return mixed
	 */
	function decrypt( $value, $unserialize = true ) {
		return wp_app_decrypt( $value, $unserialize );
	}
}

if ( ! function_exists( 'dispatch' ) ) {
	/**
	 * Dispatch a job to its appropriate handler.
	 *
	 * @param  mixed  $job
	 * @return \Illuminate\Foundation\Bus\PendingDispatch
	 */
	function dispatch( $job ) {
		return wp_app_dispatch( $job );
	}
}

if ( ! function_exists( 'dispatch_sync' ) ) {
	/**
	 * Dispatch a command to its appropriate handler in the current process.
	 *
	 * Queueable jobs will be dispatched to the "sync" queue.
	 *
	 * @param  mixed  $job
	 * @param  mixed  $handler
	 * @return mixed
	 */
	function dispatch_sync( $job, $handler = null ) {
		return wp_app_dispatch_sync( $job, $handler );
	}
}

if ( ! function_exists( 'encrypt' ) ) {
	/**
	 * Encrypt the given value.
	 *
	 * @param  mixed  $value
	 * @param  bool  $serialize
	 * @return string
	 */
	function encrypt( $value, $serialize = true ) {
		return wp_app_encrypt( $value, $serialize );
	}
}

if ( ! function_exists( 'event' ) ) {
	/**
	 * Dispatch an event and call the listeners.
	 *
	 * @param  string|object  $event
	 * @param  mixed  $payload
	 * @param  bool  $halt
	 * @return array|null
	 */
	function event( ...$args ) {
		return wp_app_event( ...$args );
	}
}

if ( ! function_exists( 'fake' ) && class_exists( \Faker\Factory::class ) ) {
	/**
	 * Get a faker instance.
	 *
	 * @param  string|null  $locale
	 * @return \Faker\Generator
	 */
	function fake( $locale = null ) {
		return wp_app_fake( $locale = null );
	}
}

if ( ! function_exists( 'info' ) ) {
	/**
	 * Write some information to the log.
	 *
	 * @param  string  $message
	 * @param  array  $context
	 * @return void
	 */
	function info( $message, $context = [] ) {
		wp_app_info( $message, $context );
	}
}

if ( ! function_exists( 'logger' ) ) {
	/**
	 * Log a debug message to the logs.
	 *
	 * @param  string|null  $message
	 * @param  array  $context
	 * @return \Illuminate\Log\LogManager|null
	 */
	function logger( $message = null, array $context = [] ) {
		return wp_app_logger( $message, $context );
	}
}

if ( ! function_exists( 'lang_path' ) ) {
	/**
	 * Get the path to the language folder.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function lang_path( $path = '' ) {
		return wp_app_lang_path( $path );
	}
}

if ( ! function_exists( 'logs' ) ) {
	/**
	 * Get a log driver instance.
	 *
	 * @param  string|null  $driver
	 * @return \Illuminate\Log\LogManager|\Psr\Log\LoggerInterface
	 */
	function logs( $driver = null ) {
		return wp_app_logs( $driver );
	}
}

if ( ! function_exists( 'method_field' ) ) {
	/**
	 * Generate a form field to spoof the HTTP verb used by forms.
	 *
	 * @param  string  $method
	 * @return \Illuminate\Support\HtmlString
	 */
	function method_field( $method ) {
		return wp_app_method_field( $method );
	}
}

if ( ! function_exists( 'mix' ) ) {
	/**
	 * Get the path to a versioned Mix file.
	 *
	 * @param  string  $path
	 * @param  string  $manifestDirectory
	 * @return \Illuminate\Support\HtmlString|string
	 *
	 * @throws \Exception
	 */
	function mix( $path, $manifestDirectory = '' ) {
		return wp_app_mix( $path, $manifestDirectory );
	}
}

if ( ! function_exists( 'now' ) ) {
	/**
	 * Create a new Carbon instance for the current time.
	 *
	 * @param  \DateTimeZone|string|null  $tz
	 * @return \Illuminate\Support\Carbon
	 */
	function now( $tz = null ) {
		return wp_app_now( $tz );
	}
}

if ( ! function_exists( 'old' ) ) {
	/**
	 * Retrieve an old input item.
	 *
	 * @param  string|null  $key
	 * @param  mixed  $default
	 * @return mixed
	 */
	function old( $key = null, $default = null ) {
		return wp_app_old( $key, $default );
	}
}

if ( ! function_exists( 'policy' ) ) {
	/**
	 * Get a policy instance for a given class.
	 *
	 * @param  object|string  $class
	 * @return mixed
	 *
	 * @throws \InvalidArgumentException
	 */
	function policy( $class ) {
		return wp_app_policy( $class );
	}
}

if ( ! function_exists( 'precognitive' ) ) {
	/**
	 * Handle a Precognition controller hook.
	 *
	 * @param  null|callable  $callable
	 * @return mixed
	 */
	function precognitive( $callable = null ) {
		return wp_app_precognitive( $callable );
	}
}

if ( ! function_exists( 'public_path' ) ) {
	/**
	 * Get the path to the public folder.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function public_path( $path = '' ) {
		return wp_app_public_path( $path );
	}
}

if ( ! function_exists( 'redirect' ) ) {
	/**
	 * Get an instance of the redirector.
	 *
	 * @param  string|null  $to
	 * @param  int  $status
	 * @param  array  $headers
	 * @param  bool|null  $secure
	 * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
	 */
	function redirect( $to = null, $status = 302, $headers = [], $secure = null ) {
		return wp_app_redirect( $to, $status, $headers, $secure );
	}
}

if ( ! function_exists( 'report' ) ) {
	/**
	 * Report an exception.
	 *
	 * @param  \Throwable|string  $exception
	 * @return void
	 */
	function report( $exception ) {
		wp_app_report( $exception );
	}
}

if ( ! function_exists( 'report_if' ) ) {
	/**
	 * Report an exception if the given condition is true.
	 *
	 * @param  bool  $boolean
	 * @param  \Throwable|string  $exception
	 * @return void
	 */
	function report_if( $boolean, $exception ) {
		wp_app_report_if( $boolean, $exception );
	}
}

if ( ! function_exists( 'report_unless' ) ) {
	/**
	 * Report an exception unless the given condition is true.
	 *
	 * @param  bool  $boolean
	 * @param  \Throwable|string  $exception
	 * @return void
	 */
	function report_unless( $boolean, $exception ) {
		wp_app_report_unless( $boolean, $exception );
	}
}

if ( ! function_exists( 'request' ) ) {
	/**
	 * Get an instance of the current request or an input item from the request.
	 *
	 * @param  array|string|null  $key
	 * @param  mixed  $default
	 * @return mixed|\Illuminate\Http\Request|string|array|null
	 */
	function request( $key = null, $default = null ) {
		return wp_app_request( $key, $default );
	}
}

if ( ! function_exists( 'rescue' ) ) {
	/**
	 * Catch a potential exception and return a default value.
	 *
	 * @template TRescueValue
	 * @template TRescueFallback
	 *
	 * @param  callable(): TRescueValue  $callback
	 * @param  (callable(\Throwable): TRescueFallback)|TRescueFallback  $rescue
	 * @param  bool|callable  $report
	 * @return TRescueValue|TRescueFallback
	 */
	function rescue( callable $callback, $rescue = null, $report = true ) {
		return wp_app_rescue( $callback, $rescue, $report );
	}
}

if ( ! function_exists( 'resolve' ) ) {
	/**
	 * Resolve a service from the container.
	 *
	 * @param  string  $name
	 * @param  array  $parameters
	 * @return mixed
	 */
	function resolve( $name, array $parameters = [] ) {
		return wp_app_resolve( $name, $parameters );
	}
}

if ( ! function_exists( 'resource_path' ) ) {
	/**
	 * Get the path to the resources folder.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function resource_path( $path = '' ) {
		return wp_app_resource_path( $path );
	}
}

if ( ! function_exists( 'response' ) ) {
	/**
	 * Return a new response from the application.
	 *
	 * @param  \Illuminate\Contracts\View\View|string|array|null  $content
	 * @param  int  $status
	 * @param  array  $headers
	 * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
	 */
	function response( $content = '', $status = 200, array $headers = [] ) {
		if ( func_num_args() === 0 ) {
			return wp_app_response();
		}

		return wp_app_response( $content, $status, $headers );
	}
}

if ( ! function_exists( 'route' ) ) {
	/**
	 * Generate the URL to a named route.
	 *
	 * @param  string  $name
	 * @param  mixed  $parameters
	 * @param  bool  $absolute
	 * @return string
	 */
	function route( $name, $parameters = [], $absolute = true ) {
		return wp_app_route( $name, $parameters, $absolute );
	}
}

if ( ! function_exists( 'secure_asset' ) ) {
	/**
	 * Generate an asset path for the application.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function secure_asset( $path ) {
		return wp_app_secure_asset( $path );
	}
}

if ( ! function_exists( 'secure_url' ) ) {
	/**
	 * Generate a HTTPS url for the application.
	 *
	 * @param  string  $path
	 * @param  mixed  $parameters
	 * @return string
	 */
	function secure_url( $path, $parameters = [] ) {
		return wp_app_secure_url( $path, $parameters );
	}
}

if ( ! function_exists( 'session' ) ) {
	/**
	 * Get / set the specified session value.
	 *
	 * If an array is passed as the key, we will assume you want to set an array of values.
	 *
	 * @param  array|string|null  $key
	 * @param  mixed  $default
	 * @return mixed|\Illuminate\Session\Store|\Illuminate\Session\SessionManager
	 */
	function session( $key = null, $default = null ) {
		return wp_app_session( $key, $default );
	}
}

if ( ! function_exists( 'storage_path' ) ) {
	/**
	 * Get the path to the storage folder.
	 *
	 * @param  string  $path
	 * @return string
	 */
	function storage_path( $path = '' ) {
		return wp_app_storage_path( $path );
	}
}

if ( ! function_exists( 'to_route' ) ) {
	/**
	 * Create a new redirect response to a named route.
	 *
	 * @param  string  $route
	 * @param  mixed  $parameters
	 * @param  int  $status
	 * @param  array  $headers
	 * @return \Illuminate\Http\RedirectResponse
	 */
	function to_route( $route, $parameters = [], $status = 302, $headers = [] ) {
		return wp_app_to_route( $route, $parameters, $status, $headers );
	}
}

if ( ! function_exists( 'today' ) ) {
	/**
	 * Create a new Carbon instance for the current date.
	 *
	 * @param  \DateTimeZone|string|null  $tz
	 * @return \Illuminate\Support\Carbon
	 */
	function today( $tz = null ) {
		return wp_app_today( $tz );
	}
}

if ( ! function_exists( 'trans' ) ) {
	/**
	 * Translate the given message.
	 *
	 * @param  string|null  $key
	 * @param  array  $replace
	 * @param  string|null  $locale
	 * @return \Illuminate\Contracts\Translation\Translator|string|array|null
	 */
	function trans( $key = null, $replace = [], $locale = null ) {
		return wp_app_trans( $key, $replace, $locale );
	}
}

if ( ! function_exists( 'trans_choice' ) ) {
	/**
	 * Translates the given message based on a count.
	 *
	 * @param  string  $key
	 * @param  \Countable|int|array  $number
	 * @param  array  $replace
	 * @param  string|null  $locale
	 * @return string
	 */
	function trans_choice( $key, $number, array $replace = [], $locale = null ) {
		return wp_app_trans_choice( $key, $number, $replace, $locale );
	}
}

if ( ! function_exists( 'url' ) ) {
	/**
	 * Generate a url for the application.
	 *
	 * @param  string|null  $path
	 * @param  mixed  $parameters
	 * @param  bool|null  $secure
	 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
	 */
	function url( $path = null, $parameters = [], $secure = null ) {
		return wp_app_url( $path, $parameters, $secure );
	}
}

if ( ! function_exists( 'validator' ) ) {
	/**
	 * Create a new Validator instance.
	 *
	 * @param  array  $data
	 * @param  array  $rules
	 * @param  array  $messages
	 * @param  array  $attributes
	 * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Contracts\Validation\Factory
	 */
	function validator( array $data = [], array $rules = [], array $messages = [], array $attributes = [] ) {
		if ( func_num_args() === 0 ) {
			return wp_app_validator();
		}

		return wp_app_validator( $data, $rules, $messages, $attributes );
	}
}

if ( ! function_exists( 'view' ) ) {
	/**
	 * Get the evaluated view contents for the given view.
	 *
	 * @param  string|null  $view
	 * @param  \Illuminate\Contracts\Support\Arrayable|array  $data
	 * @param  array  $mergeData
	 * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
	 */
	function view( $view = null, $data = [], $mergeData = [] ) {
		if ( func_num_args() === 0 ) {
			return wp_app_view();
		}

		return wp_app_view( $view, $data, $mergeData );
	}
}
