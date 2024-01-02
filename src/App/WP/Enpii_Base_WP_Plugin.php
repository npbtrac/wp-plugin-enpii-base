<?php

declare(strict_types=1);

namespace Enpii_Base\App\WP;

use Enpii_Base\App\Http\Response;
use Enpii_Base\App\Jobs\Conclude_WP_App_Request_Job;
use Enpii_Base\App\Jobs\Init_WP_App_Bootstrap_Job;
use Enpii_Base\App\Jobs\Login_WP_App_User;
use Enpii_Base\App\Jobs\Logout_WP_App_User;
use Enpii_Base\App\Jobs\Perform_Queue_Work_Job;
use Enpii_Base\App\Jobs\Perform_Setup_WP_App_Job;
use Enpii_Base\App\Jobs\Process_WP_Api_Request_Job;
use Enpii_Base\App\Jobs\Process_WP_App_Request_Job;
use Enpii_Base\App\Jobs\Register_Base_WP_Api_Routes_Job;
use Enpii_Base\App\Jobs\Register_Base_WP_App_Routes_Job;
use Enpii_Base\App\Jobs\Show_Admin_Notice_From_Flash_Messages_Job;
use Enpii_Base\App\Jobs\Write_Queue_Work_Script_Job;
use Enpii_Base\App\Jobs\Write_Setup_Client_Script_Job;
use Enpii_Base\App\Queries\Add_More_Providers_Query;
use Enpii_Base\App\Support\App_Const;
use Illuminate\Contracts\Container\BindingResolutionException;
use Enpii_Base\Foundation\WP\WP_Plugin;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;
use WP_CLI;
use WP_Query;
use WP_User;

/**
 * @package Enpii_Base\App\WP
 */
final class Enpii_Base_WP_Plugin extends WP_Plugin {
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		// We need to ensure all needed properties are set
		$this->validate_needed_properties();

		// We want to stop some default actions of WordPress
		$this->prevent_defaults();

		// We want to create hooks for this plugin here
		$this->enroll_self_hooks();

		parent::register();
	}

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

	public function manipulate_hooks(): void {
		/** WP CLI */
		add_action( 'cli_init', [ $this, 'register_wp_cli_commands' ] );

		/** WP App hooks */
		// We want to initialize wp_app bootstrap after plugins loaded
		add_action( App_Const::ACTION_WP_APP_BOOTSTRAP, [ $this, 'bootstrap_wp_app' ], 5 );
		add_action( App_Const::ACTION_WP_APP_INIT, [ $this, 'build_wp_app_response_via_middleware' ], 5 );
		add_action( App_Const::ACTION_WP_APP_INIT, [ $this, 'sync_wp_user_to_wp_app_user' ] );
		add_action( 'wp_login', [ $this, 'login_wp_app_user' ], 10, 2 );
		add_action( 'wp_logout', [ $this, 'logout_wp_app_user' ] );

		add_action( App_Const::ACTION_WP_APP_REGISTER_ROUTES, [ $this, 'register_base_wp_app_routes' ] );
		add_action( App_Const::ACTION_WP_API_REGISTER_ROUTES, [ $this, 'register_base_wp_api_routes' ] );
		add_action( App_Const::ACTION_WP_APP_QUEUE_WORK, [ $this, 'queue_work' ] );
		add_action( App_Const::ACTION_WP_APP_SETUP_APP, [ $this, 'setup_app' ] );

		add_filter( App_Const::FILTER_WP_APP_MAIN_SERVICE_PROVIDERS, [ $this, 'register_more_providers' ] );

		/** Other hooks */
		if ( $this->is_blade_for_template_available() ) {
			add_filter( 'template_include', [ $this, 'use_blade_to_compile_template' ], 99999 );
		}

		add_action( 'admin_print_footer_scripts', [ $this, 'write_setup_wp_app_client_script' ] );
		add_action( 'admin_print_footer_scripts', [ $this, 'write_queue_work_client_script' ] );
		add_action( 'wp_footer', [ $this, 'write_queue_work_client_script' ] );

		add_action( 'admin_head', [ $this, 'handle_admin_head' ] );

		if ( defined( 'WP_APP_PASSPORT_ENABLED' ) && WP_APP_PASSPORT_ENABLED ) {
			add_action( 'show_user_profile', [ $this, 'add_client_app_fields' ] );
			add_action( 'edit_user_profile', [ $this, 'add_client_app_fields' ] );
		}

		add_filter(
			'wp_headers',
			function ( $headers ) {
				$headers['X-Test'] = 'A test header';

				return $headers;
			}
		);

		if ( ! wp_app()->is_wp_app_mode() && ! wp_app()->is_wp_api_mode() ) {
			// We need to have wp_app() terminated before shutting down WP
			add_action(
				'shutdown',
				[ $this, 'perform_wp_app_termination' ],
				9999
			);

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
	}

	public function setup_app(): void {
		Perform_Setup_WP_App_Job::dispatchSync();
	}

	public function bootstrap_wp_app(): void {
		Init_WP_App_Bootstrap_Job::execute_now();
	}

	public function write_setup_wp_app_client_script(): void {
		Write_Setup_Client_Script_Job::execute_now();
	}

	public function write_queue_work_client_script(): void {
		Write_Queue_Work_Script_Job::execute_now();
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
			'enpii-base prepare-folders',
			$this->app->make( \Enpii_Base\App\WP_CLI\Enpii_Base_Prepare_Folders_WP_CLI::class )
		);
		WP_CLI::add_command(
			'enpii-base artisan',
			$this->app->make( \Enpii_Base\App\WP_CLI\Enpii_Base_Artisan_WP_CLI::class )
		);
	}

	/**
	 * We place 'enpii_base_wp_app_bootstrap' to bootstrap neccessary things for wp-app
	 * @return void
	 */
	public function wp_app_bootstrap(): void {
		do_action( App_Const::ACTION_WP_APP_BOOTSTRAP );
	}

	/**
	 * We place 'enpii_base_wp_app_init' action here to initialize everything on wp-app
	 * @return void
	 */
	public function wp_app_init(): void {
		do_action( App_Const::ACTION_WP_APP_INIT );
	}

	/**
	 * We put the action 'enpii_base_wp_app_parse_request' here for the parse request step of wp-app
	 *  and return false to exit on WordPress parse request method
	 * @return bool
	 */
	public function wp_app_parse_request(): bool {
		do_action( App_Const::ACTION_WP_APP_PARSE_REQUEST );

		return false;
	}

	/**
	 * We put the action 'enpii_base_wp_app_do_main_query' here for other actions
	 *  and return false to skip the main query execution
	 * @param mixed $request
	 * @param WP_Query $query
	 * @return mixed
	 */
	public function skip_wp_main_query( $request, $query ) {
		/** @var WP_Query $query */
		if ( $query->is_main_query() && ! $query->is_admin ) {
			do_action( App_Const::ACTION_WP_APP_DO_WP_MAIN_QUERY, $request, $query );

			return false;
		}

		return $request;
	}

	public function wp_app_render_content( $wp ): void {
		Process_WP_App_Request_Job::execute_now();
	}

	public function wp_api_process_request( $wp ): void {
		Process_WP_Api_Request_Job::execute_now();
	}

	/**
	 * @return mixed
	 */
	public function skip_wp_template_include( $template ) {
		do_action( App_Const::ACTION_WP_APP_RENDER_WP_TEMPLATE, $template );

		return false;
	}

	/**
	 * We want to skip using wp theme for APIs
	 *  and add an action 'enpii_base_wp_app_skip_use_wp_theme' for further actions
	 * @return mixed
	 */
	public function skip_use_wp_theme() {
		do_action( App_Const::ACTION_WP_APP_SKIP_USE_WP_THEME );

		return false;
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
			$tmp = wp_app_view( basename( $template, '.php' ) );
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $tmp;
			$template = false;

			// We simply want to do nothing on the InvalidArgumentException
		// phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedCatch
		} catch ( InvalidArgumentException $invalid_argument_exception ) {
		} catch ( Exception $e ) {
			throw $e;
		}

		return $template;
	}

	public function wp_app_complete_execution(): void {
		Conclude_WP_App_Request_Job::execute_now();
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
	public function queue_work() {
		Perform_Queue_Work_Job::dispatchSync();
	}

	/**
	 * Generate HTML fields for profile page
	 * @return void
	 */
	public function add_client_app_fields( $user ) {
		// We ignore the escape rule becase we handle that in the view file
		// @codingStandardsIgnoreStart WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $this->view(
			'admin/users/client-app-fields',
			[
				'user' => $user,
				'wp_plugin' => $this,
			]
		);
		// @codingStandardsIgnoreEnd
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

			$wp_app_request = wp_app_request();
			/** @var Response $wp_app_response */
			$wp_app_response = $kernel->send_request_through_middleware(
				$wp_app_request,
				[
					\Illuminate\Cookie\Middleware\EncryptCookies::class,
					\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
					\Illuminate\Session\Middleware\StartSession::class,
					\Illuminate\View\Middleware\ShareErrorsFromSession::class,
				],
				function ( $request ) {
					$response = new Response();
					$response->set_request( $request );
					return $response;
				}
			);
			wp_app()->bind(
				ResponseFactory::class,
				// phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
				function ( $app ) use ( $wp_app_response ) {
					return $wp_app_response;
				}
			);
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
		dev_error_log( 'logout_wp_app_user', $user_id, Auth::getSession() );
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

	/**
	 * All hooks created by this plugin should be enrolled here
	 * @return void
	 */
	private function enroll_self_hooks(): void {
		// For `enpii_base_wp_app_bootstrap`
		//  We add this hook to perform the bootstrap actions needed for WP App
		add_action( 'after_setup_theme', [ $this, 'wp_app_bootstrap' ], 5 );

		// For `enpii_base_wp_app_init`
		//  We want this hook works after all the init steps worked on all plugins
		//  for other plugins can hook to this process
		add_action( 'init', [ $this, 'wp_app_init' ], 999999 );

		if ( wp_app()->is_wp_app_mode() || wp_app()->is_wp_api_mode() ) {
			add_filter( 'do_parse_request', [ $this, 'wp_app_parse_request' ], 9999, 0 );
			add_filter( 'posts_request', [ $this, 'skip_wp_main_query' ], 9999, 2 );
		}

		if ( wp_app()->is_wp_app_mode() ) {
			add_action( 'template_redirect', [ $this, 'wp_app_render_content' ], 9999, 1 );
			add_filter( 'template_include', [ $this, 'skip_wp_template_include' ], 9999, 1 );
			add_action( 'shutdown', [ $this, 'wp_app_complete_execution' ], 9999, 0 );
		}

		if ( wp_app()->is_wp_api_mode() ) {
			add_filter( 'wp_using_themes', [ $this, 'skip_use_wp_theme' ], 9999, 0 );
			add_action( 'wp_loaded', [ $this, 'wp_api_process_request' ], 9999, 1 );
		}
	}

	private function is_blade_for_template_available(): bool {
		// We only want to use Blade
		return ! wp_app()->is_wp_app_mode();
	}
}
