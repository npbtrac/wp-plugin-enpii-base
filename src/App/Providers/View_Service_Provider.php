<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\App\Providers;

use Enpii\WP_Plugin\Enpii_Base\App\WP\Enpii_Base_WP_Plugin;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Container\BindingResolutionException;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\View\ViewServiceProvider;

class View_Service_Provider extends ViewServiceProvider {

	public function boot() {
		wp_app_config(
			[
				'view' => apply_filters(
					'enpii_base_wp_app_view_config',
					[
						'paths'    => $this->generate_view_storage_paths(),
						'compiled' => $this->generate_view_compiled_path(),
					]
				),
			]
		);
	}

	/**
	 * The Paths to store the views files
	 *
	 * @return array
	 */
	protected function generate_view_storage_paths(): array {
		// die(wp_app()->make(Enpii_Base_WP_Plugin::class)->get_base_path());
		// We want to use the child theme and the template as the main views paths
		return [
			get_stylesheet_directory() . DIR_SEP . 'resources' . DIR_SEP . 'views',
			get_template_directory() . DIR_SEP . 'resources' . DIR_SEP . 'views',
			wp_app( Enpii_Base_WP_Plugin::class )->get_base_path() . DIR_SEP . 'resources' . DIR_SEP . 'views',
		];
	}

	/**
	 * The view complided path to store compiled files
	 *
	 * @return string
	 * @throws BindingResolutionException
	 */
	protected function generate_view_compiled_path(): string {
		return realpath( wp_app_storage_path( 'framework/views' ) );
	}
}
