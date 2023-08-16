<?php

declare(strict_types=1);

namespace Enpii_Base\App\WP;

use Enpii_Base\App\Commands\Register_Base_WP_Api_Routes_Job_Command;
use Enpii_Base\App\Commands\Register_Base_WP_App_Routes_Job_Command;
use Enpii_Base\App\Commands\Register_Main_Service_Providers_Job_Command;
use Enpii_Base\App\Jobs\Init_WP_App_Bootstrap_Job;
use Enpii_Base\App\Jobs\Process_WP_App_Request_Job;
use Enpii_Base\App\Jobs\Register_Base_WP_Api_Routes_Job;
use Enpii_Base\App\Jobs\Register_Base_WP_App_Routes_Job;
use Enpii_Base\App\Jobs\Register_Main_Service_Providers_Job;
use Enpii_Base\Deps\Illuminate\Contracts\Container\BindingResolutionException;
use Enpii_Base\Deps\Illuminate\Http\Response;
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

		// We want to create hooks for this plugin here
		$this->enroll_self_hooks();

		// We want to handle the hooks first
		$this->manipulate_hooks();

		// We trigger the action when wp_app loaded
		do_action( 'enpii_base_wp_app_loaded' );
	}

	public function manipulate_hooks(): void {
		// WP CLI
		add_action( 'cli_init', [ $this, 'register_wp_cli_commands' ] );

		// WP App hooks

		// We want to initialize wp_app bootstrap after plugins loaded
		add_action( 'enpii_base_wp_app_bootstrap', [ $this, 'bootstrap_wp_app' ], 5 );

		// We want to start processing wp-app requests after all plugins and theme loaded
		add_action( 'enpii_base_wp_app_init', [ $this, 'register_main_service_providers' ] );

		add_action( 'enpii_base_wp_app_register_routes', [ $this, 'register_base_wp_app_routes' ] );
		add_action( 'enpii_base_wp_api_register_routes', [ $this, 'register_base_wp_api_routes' ] );

		// Other hooks
		if ($this->is_blade_for_template_available()) {
			add_filter( 'template_include', [ $this, 'use_blade_to_compile_template' ], 99999);
		}
	}

	public function bootstrap_wp_app(): void {
		Init_WP_App_Bootstrap_Job::dispatchSync();
	}

	/**
	 * We want to register main Service Providers for the wp_app()
	 * You can remove this handler to replace with the Service Providers you want
	 * @return void
	 * @throws BindingResolutionException
	 * @throws InvalidArgumentException
	 */
	public function register_main_service_providers(): void {
		$providers = [
			\Enpii_Base\App\Providers\View_Service_Provider::class,
			\Enpii_Base\App\Providers\Route_Service_Provider::class,
			\Enpii_Base\App\Providers\Filesystem_Service_Provider::class,
			\Enpii_Base\App\Providers\Cache_Service_Provider::class,
			\Enpii_Base\App\Providers\Artisan_Service_Provider::class,
			\Enpii_Base\App\Providers\Queue_Service_Provider::class,
			\Enpii_Base\App\Providers\Database_Service_Provider::class,
			\Enpii_Base\App\Providers\Composer_Service_Provider::class,
			\Enpii_Base\App\Providers\Migration_Service_Provider::class,
		];
		Register_Main_Service_Providers_Job::dispatchSync([
			'providers' => $providers,
		]);
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
			wp_app_resolve(\Enpii_Base\App\WP_CLI\Enpii_Base_Info_WP_CLI::class)
		);
		WP_CLI::add_command(
			'enpii-base prepare-folders',
			$this->app->make(\Enpii_Base\App\WP_CLI\Enpii_Base_Prepare_Folders_WP_CLI::class)
		);
		WP_CLI::add_command(
			'enpii-base artisan',
			$this->app->make(\Enpii_Base\App\WP_CLI\Enpii_Base_Artisan_WP_CLI::class)
		);
	}

	/**
	 * We place 'enpii_base_wp_app_bootstrap' to bootstrap neccessary things for wp-app
	 * @return void
	 */
	public function wp_app_bootstrap(): void {
		do_action( 'enpii_base_wp_app_bootstrap' );
	}

	/**
	 * We place 'enpii_base_wp_app_init' action here to initialize everything on wp-app
	 * @return void
	 */
	public function wp_app_init(): void {
		do_action( 'enpii_base_wp_app_init' );
	}

	/**
	 * We put the action 'enpii_base_wp_app_parse_request' here for the parse request step of wp-app
	 * 	and return false to exit on WordPress parse request method
	 * @return bool
	 */
	public function wp_app_parse_request(): bool {
		do_action( 'enpii_base_wp_app_parse_request' );

		return false;
	}

	/**
	 * We put the action 'enpii_base_wp_app_do_main_query' here for other actions
	 * 	and return false to skip the main query execution
	 * @param mixed $request
	 * @param WP_Query $query
	 * @return mixed
	 */
	public function skip_wp_main_query( $request, $query ) {
		/** @var WP_Query $query */
		if( $query->is_main_query() && ! $query->is_admin ) {
			do_action( 'enpii_base_wp_app_do_wp_main_query', $request, $query );

			return false;
		}

		return $request;
	}

	public function wp_app_render_content($wp): void {
		Process_WP_App_Request_Job::dispatchSync();
	}

	/**
	 * @return mixed
	 */
	public function skip_wp_template_include( $template ) {
		do_action( 'enpii_base_wp_app_render_wp_template', $template );

		return false;
	}

	/**
	 * We want to skip using wp theme for APIs
	 * 	and add an action 'enpii_base_wp_app_skip_use_wp_theme' for further actions
	 * @return mixed
	 */
	public function skip_use_wp_theme() {
		do_action( 'enpii_base_wp_app_skip_use_wp_theme' );

		return false;
	}

	public function use_blade_to_compile_template( $template) {
		/** @var \Enpii_Base\Deps\Illuminate\View\Factory $view */
		$view = wp_app_view();
		// We want to have blade to compile the php file as well
		$view->addExtension('php', 'blade');

		/** @var \Enpii_Base\Deps\Illuminate\View\View $wp_app_view */
		// $wp_app_view = wp_app_view(basename($template, '.php'))

		// We catch exception if view is not rendered correctly
		// 	exception InvalidArgumentException for view file not found in FileViewFinder
		try {
			$tmp = wp_app_view(basename($template, '.php'));
			// dev_dump($blade_compiler->getCompiledPath());
			echo $tmp;
			$template = false;
		} catch (InvalidArgumentException $e) {
		} catch (Exception $e) {
			throw $e;
		}

		return $template;
	}

	public function wp_app_complete_execution(): void {
		// We only want to run this
		do_action( 'enpii_base_wp_app_complete_execution' );

		if (\function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        } elseif (\function_exists('litespeed_finish_request')) {
            litespeed_finish_request();
        } elseif (!\in_array(\PHP_SAPI, ['cli', 'phpdbg'], true)) {
            Response::closeOutputBuffers(0, true);
            flush();
        }
	}

	public function get_views_path() {
		return $this->get_base_path() . DIR_SEP . 'resources' . DIR_SEP . 'views';
	}

	/**
	 * All hooks created by this plugin should be enrolled here
	 * @return void
	 */
	private function enroll_self_hooks(): void {
		// For `enpii_base_wp_app_bootstrap`
		add_action( 'plugins_loaded', [ $this, 'wp_app_bootstrap' ], 5 );

		// For `enpii_base_wp_app_init`
		add_action( 'init', [$this, 'wp_app_init'], 9999 );

		if (wp_app()->is_wp_app_mode() || wp_app()->is_wp_api_mode()) {
			add_filter( 'do_parse_request', [$this, 'wp_app_parse_request'], 9999, 0 );
			add_filter( 'posts_request', [$this, 'skip_wp_main_query'], 9999, 2 );
		}

		if (wp_app()->is_wp_app_mode()) {
			add_action( 'template_redirect', [$this, 'wp_app_render_content'], 9999, 1 );
			add_filter( 'template_include', [$this, 'skip_wp_template_include'], 9999, 1 );
			add_action( 'shutdown', [$this, 'wp_app_complete_execution'], 9999, 0 );
		}

		if (wp_app()->is_wp_api_mode()) {
			add_filter( 'wp_using_themes', [$this, 'skip_use_wp_theme'], 9999, 0 );
			add_action( 'wp', [$this, 'wp_app_render_content'], 9999, 1 );
			add_action( 'shutdown', [$this, 'wp_app_complete_execution'], 9999, 0 );
		}
	}

	private function is_blade_for_template_available(): bool {
		// We only want to use Blade
		return !wp_app()->is_wp_app_mode();
	}
}
