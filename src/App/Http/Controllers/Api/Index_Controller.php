<?php

declare(strict_types=1);

namespace Enpii_Base\App\Http\Controllers\Api;

use Enpii_Base\Deps\Symfony\Component\HttpFoundation\JsonResponse;
use Enpii_Base\Foundation\Http\Base_Controller;

class Index_Controller extends Base_Controller {
	public function home(): JsonResponse {
		return wp_app_response()->json([
            'message' => 'Welcome to WP App API',
        ]);
	}

	public function info(): JsonResponse {
		$data = [
			'wp_version' => get_bloginfo('version'),
			'enpii_base_version' => ENPII_BASE_PLUGIN_VERSION,
		];
		if (!empty(wp_get_current_user( ))) {
			$data['current_logged_in_user'] = wp_get_current_user( );
		}
		return wp_app_response()->json([
			'message' => 'WP App API Info',
            'data' => $data,
        ]);
	}
}
