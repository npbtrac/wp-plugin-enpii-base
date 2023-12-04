<?php

declare(strict_types=1);

namespace Enpii_Base\Foundation\WP;

interface WP_Plugin_Interface {
	public const PARAM_KEY_PLUGIN_SLUG = 'plugin_slug';
	public const PARAM_KEY_PLUGIN_BASE_PATH = 'base_path';
	public const PARAM_KEY_PLUGIN_BASE_URL = 'base_url';

	/**
	 * We want to use this method to register and deregister all hooks and related things to be used in the plugin
	 * @return void
	 */
	public function manipulate_hooks(): void;

	/**
	 * The plugin should have a human readable name
	 * @return string
	 */
	public function get_name(): string;

	/**
	 * The plugin should have a version for being tracked
	 * @return string
	 */
	public function get_version(): string;

	/**
	 * The plugin should have a text domain
	 * @return string
	 */
	public function get_text_domain(): string;
}
