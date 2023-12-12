<?php

declare(strict_types=1);

namespace Enpii_Base\App\WP;

use Enpii_Base\App\Jobs\Init_WP_App_Bootstrap_Job;
use Enpii_Base\App\Jobs\Process_WP_Api_Request_Job;
use Enpii_Base\App\Jobs\Process_WP_App_Request_Job;
use Enpii_Base\App\Jobs\Register_Base_WP_Api_Routes_Job;
use Enpii_Base\App\Jobs\Register_Base_WP_App_Routes_Job;
use Enpii_Base\App\Jobs\Register_Main_Service_Providers_Job;
use Enpii_Base\App\Jobs\Show_Admin_Notice_From_Flash_Messages_Job;
use Enpii_Base\App\Jobs\Write_Setup_Client_Script_Job;
use Enpii_Base\App\Queries\Add_Telescope_Tinker_Query;
use Enpii_Base\App\Support\App_Const;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Response;
use Enpii_Base\Foundation\WP\WP_Plugin;
use Exception;
use InvalidArgumentException;
use WP_CLI;
use WP_Query;

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
		// We trigger the action when wp_app is registered
		do_action( App_Const::ACTION_WP_APP_REGISTERED );

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

	public function manipulate_hooks(): void {
		/** WP CLI */
		add_action( 'cli_init', [ $this, 'register_wp_cli_commands' ] );

		/** WP App hooks */
		// We want to initialize wp_app bootstrap after plugins loaded
		add_action( App_Const::ACTION_WP_APP_BOOTSTRAP, [ $this, 'bootstrap_wp_app' ], 5 );

		add_action( App_Const::ACTION_WP_APP_REGISTER_ROUTES, [ $this, 'register_base_wp_app_routes' ] );
		add_action( App_Const::ACTION_WP_API_REGISTER_ROUTES, [ $this, 'register_base_wp_api_routes' ] );

		add_filter( App_Const::FILTER_WP_APP_MAIN_SERVICE_PROVIDERS, [ $this, 'register_telescope_tinker' ] );

		/** Other hooks */
		if ( $this->is_blade_for_template_available() ) {
			add_filter( 'template_include', [ $this, 'use_blade_to_compile_template' ], 99999 );
		}

		add_action( 'admin_print_footer_scripts', [ $this, 'write_setup_client_script' ] );

		add_action( 'admin_head', [ $this, 'handle_admin_head' ] );
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

	public function bootstrap_wp_app(): void {
		Init_WP_App_Bootstrap_Job::dispatchSync();
	}

	public function write_setup_client_script(): void {
		Write_Setup_Client_Script_Job::dispatchSync();
	}

	/**
	 * We want to register main Service Providers for the wp_app()
	 * You can remove this handler to replace with the Service Providers you want
	 * @return void
	 * @throws BindingResolutionException
	 * @throws InvalidArgumentException
	 */
	public function register_main_service_providers(): void {
		Register_Main_Service_Providers_Job::dispatchSync();
	}

	public function register_base_wp_app_routes(): void {
		Register_Base_WP_App_Routes_Job::dispatchSync();
	}

	public function register_base_wp_api_routes(): void {
		Register_Base_WP_Api_Routes_Job::dispatchSync();
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
		Process_WP_App_Request_Job::dispatchSync();
	}

	public function wp_api_process_request( $wp ): void {
		Process_WP_Api_Request_Job::dispatchSync();
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

	public function use_blade_to_compile_template( $template ) {
		/** @var \Illuminate\View\Factory $view */
		$view = wp_app_view();
		// We want to have blade to compile the php file as well
		$view->addExtension( 'php', 'blade' );

		/** @var \Illuminate\View\View $wp_app_view */
		// $wp_app_view = wp_app_view(basename($template, '.php'))

		// We catch exception if view is not rendered correctly
		//  exception InvalidArgumentException for view file not found in FileViewFinder
		try {
			$tmp = wp_app_view( basename( $template, '.php' ) );
			echo $tmp;
			$template = false;
		} catch ( InvalidArgumentException $e ) {
		} catch ( Exception $e ) {
			throw $e;
		}

		return $template;
	}

	public function wp_app_complete_execution(): void {
		// We only want to run this
		do_action( App_Const::ACTION_WP_APP_COMPLETE_EXECUTION );

		if ( \function_exists( 'fastcgi_finish_request' ) ) {
			fastcgi_finish_request();
		} elseif ( \function_exists( 'litespeed_finish_request' ) ) {
			litespeed_finish_request();
		} elseif ( ! \in_array( \PHP_SAPI, [ 'cli', 'phpdbg' ], true ) ) {
			Response::closeOutputBuffers( 0, true );
			flush();
		}
	}

	public function register_telescope_tinker( $providers ) {
		return Add_Telescope_Tinker_Query::dispatchSync( $providers );
	}

	/**
	 * We want to put all handler for Admin Head here
	 *
	 * @return void
	 * @throws BindingResolutionException
	 */
	public function handle_admin_head() {
		Show_Admin_Notice_From_Flash_Messages_Job::dispatchSync();
	}

	/**
	 * All hooks created by this plugin should be enrolled here
	 * @return void
	 */
	private function prevent_defaults(): void {
		if ( wp_app()->is_wp_app_mode() || wp_app()->is_wp_api_mode() ) {
			// We want to cancel all headers set by WP
			add_filter(
				'wp_headers',
				function () {
					return [];
				},
				999999
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
			add_action( 'wp', [ $this, 'wp_api_process_request' ], 9999, 1 );
			add_action( 'shutdown', [ $this, 'wp_app_complete_execution' ], 9999, 0 );
		}
	}

	private function is_blade_for_template_available(): bool {
		// We only want to use Blade
		return ! wp_app()->is_wp_app_mode();
	}
}
