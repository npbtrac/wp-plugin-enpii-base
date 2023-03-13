<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Libs\Interfaces;

interface WP_Plugin_Interface {
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
