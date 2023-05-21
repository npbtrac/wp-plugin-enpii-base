<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Foundation\WP;

interface WP_Theme_Interface {
	public const PARAM_KEY_THEME_BASE_PATH = 'base_path';
	public const PARAM_KEY_THEME_BASE_URL = 'base_url';
	public const PARAM_KEY_PARENT_THEME_BASE_PATH = 'parent_base_path';
	public const PARAM_KEY_PARENT_THEME_BASE_URL = 'parent_base_url';

	/**
	 * Create a new service provider instance.
	 *
	 * @param  \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Foundation\Application  $app
	 * @return void
	 */
	public function __construct( $app);

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register();

	/**
	 * We want to use this method to register and deregister all hooks and related things to be used in the plugin
	 * @return void
	 */
	public function manipulate_hooks(): void;
}
