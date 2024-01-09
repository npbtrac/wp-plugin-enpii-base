<?php

declare(strict_types=1);

namespace Enpii_Base\App\WP;

use Enpii_Base\App\Http\Response;
use Enpii_Base\App\Jobs\Bootstrap_WP_App_Job;
use Enpii_Base\App\Jobs\Login_WP_App_User;
use Enpii_Base\App\Jobs\Logout_WP_App_User;
use Enpii_Base\App\Jobs\Perform_Setup_WP_App_Job;
use Enpii_Base\App\Jobs\Perform_Web_Worker_Job;
use Enpii_Base\App\Jobs\Process_WP_Api_Request_Job;
use Enpii_Base\App\Jobs\Process_WP_App_Request_Job;
use Enpii_Base\App\Jobs\Register_Base_WP_Api_Routes_Job;
use Enpii_Base\App\Jobs\Register_Base_WP_App_Routes_Job;
use Enpii_Base\App\Jobs\Show_Admin_Notice_From_Flash_Messages_Job;
use Enpii_Base\App\Jobs\Write_Setup_Client_Script_Job;
use Enpii_Base\App\Jobs\Write_Web_Worker_Script_Job;
use Enpii_Base\App\Queries\Add_More_Providers_Query;
use Enpii_Base\App\Support\App_Const;
use Enpii_Base\Foundation\WP\WP_Plugin;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\ViewException;
use InvalidArgumentException;
use PHPUnit\Framework\ExpectationFailedException;
use WP_CLI;
use WP_User;

/**
 * @package Enpii_Base\App\WP
 */
final class Enpii_Base_WP_Plugin extends WP_Plugin {
	public function boot() {
		if ( $this->app->runningInConsole() ) {
			// Register migrations rules
			$this->publishes(
				[
					$this->get_base_path() . '/database/migrations' => database_path( 'migrations' ),
				],
				[ 'enpii-base-migrations', 'laravel-migrations' ]
			);

			// Register assets
			$this->publishes(
				[
					$this->get_base_path() . '/public-assets/dist' => wp_app_public_path( 'plugins/' . $this->get_plugin_slug() ),
				],
				[ 'enpii-base-assets', 'laravel-assets' ]
			);
			$this->publishes(
				[
					$this->get_base_path() . '/public-assets/src/vendor' => wp_app_public_path( 'vendor' ),
				],
				[ 'enpii-base-assets', 'laravel-assets' ]
			);
		}

		parent::boot();
	}

	public function get_name(): string {
		return 'Enpii Base';
	}

	public function get_version(): string {
		return ENPII_BASE_PLUGIN_VERSION;
	}

	public function get_text_domain(): string {
		return 'enpii';
	}

	/**
	 * @inheritDoc
	 * @return void
	 * @throws ExpectationFailedException
	 * @throws Exception
	 */
	public function manipulate_hooks(): void {
		// We want to stop some default actions of WordPress
		$this->prevent_defaults();

		// We want to create hooks for this plugin here
		$this->enroll_self_hooks();

		/** WP App hooks */
		// We want to bootstrap the wp_app(). We use the closure here to ensure that
		//  it can't be removed
		add_action(
			App_Const::ACTION_WP_APP_BOOTSTRAP,
			function () {
				Bootstrap_WP_App_Job::execute_now();
			},
			5
		);
		add_action( App_Const::ACTION_WP_APP_INIT, [ $this, 'build_wp_app_response_via_middleware' ], 5 );
		add_action( App_Const::ACTION_WP_APP_INIT, [ $this, 'sync_wp_user_to_wp_app_user' ] );
		// We need to have wp_app() terminated before shutting down WP
		add_action( App_Const::ACTION_WP_APP_COMPLETE_EXECUTION, [ $this, 'perform_wp_app_termination' ] );


		add_action( App_Const::ACTION_WP_APP_REGISTER_ROUTES, [ $this, 'register_base_wp_app_routes' ] );
		add_action( App_Const::ACTION_WP_API_REGISTER_ROUTES, [ $this, 'register_base_wp_api_routes' ] );

		add_action( App_Const::ACTION_WP_APP_WEB_WORKER, [ $this, 'web_worker' ] );
		add_action( App_Const::ACTION_WP_APP_SETUP_APP, [ $this, 'setup_app' ] );

		add_filter( App_Const::FILTER_WP_APP_MAIN_SERVICE_PROVIDERS, [ $this, 'register_more_providers' ] );

		/** Other hooks */
		if ( $this->is_blade_for_template_available() ) {
			add_filter( 'template_include', [ $this, 'use_blade_to_compile_template' ], 99999 );
		}

		if ( wp_app()->is_wp_app_mode() ) {
			// We want to let WP App work the soonest after WP is fully loaded
			add_action( 'wp_loaded', [ $this, 'process_wp_app_request' ], -9999 );
		}

		if ( wp_app()->is_wp_api_mode() ) {
			add_action( 'init', [ $this, 'process_wp_api_request' ], 999999 );
		}

		add_action( 'wp_login', [ $this, 'login_wp_app_user' ], 10, 2 );
		add_action( 'wp_logout', [ $this, 'logout_wp_app_user' ] );

		add_action( 'admin_print_footer_scripts', [ $this, 'write_setup_wp_app_client_script' ] );
		add_action( 'admin_print_footer_scripts', [ $this, 'write_web_worker_client_script' ] );
		add_action( 'wp_footer', [ $this, 'write_web_worker_client_script' ] );

		add_action( 'admin_head', [ $this, 'handle_admin_head' ] );

		if ( ! wp_app()->is_wp_app_mode() && ! wp_app()->is_wp_api_mode() ) {
			// We want to merge the WP and WP App headers and send at once
			if ( is_admin() ) {
				add_action(
					'admin_init',
					[ $this, 'send_wp_app_headers' ]
				);
			} else {
				add_action(
					'send_headers',
					[ $this, 'send_wp_app_headers' ]
				);
			}
		}

		/** WP CLI */
		add_action( 'cli_init', [ $this, 'register_wp_cli_commands' ] );
	}

	public function setup_app(): void {
		Perform_Setup_WP_App_Job::dispatchSync();
	}

	public function bootstrap_wp_app(): void {
		Bootstrap_WP_App_Job::execute_now();
	}

	public function write_setup_wp_app_client_script(): void {
		Write_Setup_Client_Script_Job::execute_now();
	}

	public function write_web_worker_client_script(): void {
		Write_Web_Worker_Script_Job::execute_now();
	}

	public function register_base_wp_app_routes(): void {
		Register_Base_WP_App_Routes_Job::execute_now();
	}

	public function register_base_wp_api_routes(): void {
		Register_Base_WP_Api_Routes_Job::execute_now();
	}

	public function register_wp_cli_commands(): void {
		WP_CLI::add_command(
			'enpii-base info',
			wp_app_resolve( \Enpii_Base\App\WP_CLI\Enpii_Base_Info_WP_CLI::class )
		);
		WP_CLI::add_command(
			'enpii-base artisan',
			$this->app->make( \Enpii_Base\App\WP_CLI\Enpii_Base_Artisan_WP_CLI::class )
		);
	}

	public function process_wp_app_request(): void {
		Process_WP_App_Request_Job::execute_now();
	}

	public function process_wp_api_request(): void {
		Process_WP_Api_Request_Job::execute_now();
	}

	/**
	 * @throws \Exception
	 */
	public function use_blade_to_compile_template( $template ) {
		/** @var \Illuminate\View\Factory $view */
		$view = wp_app_view();
		// We want to have blade to compile the php file as well
		$view->addExtension( 'php', 'blade' );

		// We catch exception if view is not rendered correctly
		//  exception InvalidArgumentException for view file not found in FileViewFinder
		try {
			$tmp_view = wp_app_view( basename( $template, '.php' ) );
			/** @var \Illuminate\View\View $tmp_view */
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $tmp_view->render();
			$template = false;

		// phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedCatch
		} catch ( InvalidArgumentException $invalid_argument_exception ) {
			// We simply want to do nothing on the InvalidArgumentException
			// 	The reason for it is to let the WP handle the template if
			// 	Blade cannot find the template file
		} catch ( ViewException $view_exception ) {
			if ( ! empty( $view_exception->getPrevious() ) ) {
				if ( ! empty( $view_exception->getPrevious()->getPrevious() ) ) {
					throw $view_exception->getPrevious()->getPrevious();
				}

				throw $view_exception->getPrevious();
			}

			throw $view_exception;
		} catch ( Exception $e ) {
			throw $e;
		}

		return $template;
	}

	public function register_more_providers( $providers ) {
		return Add_More_Providers_Query::execute_now( $providers );
	}

	/**
	 * We want to put all handler for Admin Head here
	 *
	 * @return void
	 * @throws BindingResolutionException
	 */
	public function handle_admin_head() {
		Show_Admin_Notice_From_Flash_Messages_Job::execute_now();
	}

	/**
	 * Actions to be performed on Queue Work polling Ajax
	 * @return void
	 * @throws BindingResolutionException
	 */
	public function web_worker() {
		Perform_Web_Worker_Job::dispatchSync();
	}

	/**
	 * We want to let the request go through Laravel middleware
	 *  including StartSession to have Laravel session working with WP as well
	 * @return void
	 */
	public function build_wp_app_response_via_middleware() {
		if ( ! wp_app()->is_wp_app_mode() && ! wp_app()->is_wp_api_mode() ) {
			/** @var \Enpii_Base\App\Http\Kernel $kernel */
			$kernel = wp_app()->make( \Illuminate\Contracts\Http\Kernel::class );
			$middleware_group = $kernel->getMiddlewareGroups()['web'];

			// We don't want VerifyCsrfToken and SubstituteBindings as
			//  they need Laravel router to work correctly
			$middleware_group = array_flip( $middleware_group );
			unset( $middleware_group[ \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class ] );
			unset( $middleware_group[ \Illuminate\Routing\Middleware\SubstituteBindings::class ] );
			$middleware_group = array_flip( $middleware_group );

			$wp_app_request = wp_app_request();
			/** @var Response $wp_app_response */
			$wp_app_response = $kernel->send_request_through_middleware(
				$wp_app_request,
				$middleware_group,
				function ( $request ) {
					$response = new Response();
					$response->set_request( $request );
					return $response;
				}
			);
			wp_app()->set_response( $wp_app_response );
			wp_app()->set_request( $wp_app_response->get_request() );
		}
	}

	/**
	 * We want to merge WordPress header with Laravel headers and send them to the client
	 * @return void
	 * @throws BindingResolutionException
	 * @throws InvalidArgumentException
	 */
	public function send_wp_app_headers(): void {
		$wp_headers = wp_app()->get_wp_headers();

		/** @var Response $wp_app_response */
		$wp_app_response = wp_app_response();
		foreach ( (array) $wp_headers as $wp_header_key => $wp_header_value ) {
			$wp_app_response->header( $wp_header_key, $wp_header_value );
		}

		$wp_app_response->sendHeaders();
	}

	/**
	 * We want to sync WP logged in user to Laravel User
	 * @return void
	 */
	public function sync_wp_user_to_wp_app_user() {
		if ( ! empty( get_current_user_id() ) && empty( Auth::user() ) ) {
			Login_WP_App_User::execute_now( get_current_user_id() );
		}
	}

	public function login_wp_app_user( $user_login, WP_User $wp_user ) {
		Login_WP_App_User::execute_now( $wp_user->ID );
	}

	public function logout_wp_app_user( $user_id ) {
		Logout_WP_App_User::execute_now();
	}

	/**
	 * We want to terminate the wp_app on shutdown event
	 * @return void
	 * @throws BindingResolutionException
	 * @throws InvalidArgumentException
	 */
	public function perform_wp_app_termination() {
		/** @var \Enpii_Base\App\Http\Kernel $kernel */
		$kernel = wp_app()->make( \Illuminate\Contracts\Http\Kernel::class );
		$kernel->terminate( wp_app_request(), wp_app_response() );
	}

	/**
	 * All hooks created by this plugin should be enrolled here
	 * @return void
	 */
	private function prevent_defaults(): void {
		if ( ! wp_app()->is_wp_app_mode() && ! wp_app()->is_wp_api_mode() ) {
			add_filter(
				'wp_headers',
				// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
				function ( $headers ) {
					wp_app()->set_wp_headers( $headers );
					return [];
				},
				999999,
				1
			);
		}
	}

	/**
	 * All hooks created by this plugin should be enrolled here
	 * @return void
	 */
	private function enroll_self_hooks(): void {
		// For `enpii_base_wp_app_bootstrap`
		//  We add this hook to perform the bootstrap actions needed for WP App
		add_action(
			'after_setup_theme',
			function () {
				do_action( App_Const::ACTION_WP_APP_BOOTSTRAP );
			},
			1000
		);

		// For `enpii_base_wp_app_init`
		//  We want this hook works after all the init steps worked on all plugins
		//  for other plugins can hook to this process
		add_action(
			'init',
			function () {
				do_action( App_Const::ACTION_WP_APP_INIT );
			},
			999999
		);

		if ( ! wp_app()->is_wp_app_mode() && ! wp_app()->is_wp_api_mode() ) {
			// We need to have wp_app() terminated before shutting down WP
			add_action(
				'shutdown',
				function () {
					do_action( App_Const::ACTION_WP_APP_COMPLETE_EXECUTION );
				},
				1
			);
		}
	}

	private function is_blade_for_template_available(): bool {
		// We only want to use Blade
		return ! wp_app()->is_wp_app_mode();
	}
}
