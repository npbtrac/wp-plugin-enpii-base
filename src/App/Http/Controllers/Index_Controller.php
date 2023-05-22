<?php

declare(strict_types=1);

namespace Enpii_Base\App\Http\Controllers;

use Enpii_Base\App\WP\Enpii_Base_WP_Plugin;

class Index_Controller extends \Enpii_Base\Deps\Illuminate\Routing\Controller {
	public function home() {
		$slug = wp_app(Enpii_Base_WP_Plugin::class)->get_plugin_slug();
		// return wp_app_view( $slug . '::index/home' );
		return wp_app_view( 'index' );
	}
}
