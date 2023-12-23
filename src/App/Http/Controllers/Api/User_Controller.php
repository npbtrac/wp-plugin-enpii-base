<?php

declare(strict_types=1);

namespace Enpii_Base\App\Http\Controllers\Api;

use Enpii_Base\App\Models\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Enpii_Base\Foundation\Http\Base_Controller;
use Illuminate\Http\Request;

class User_Controller extends Base_Controller {
	public function info( Request $request ): JsonResponse {
		$user = $request->user();
		wp_set_current_user( $user->ID );
		$wp_user = wp_get_current_user();
		unset( $wp_user->data->user_pass, $wp_user->data->user_activation_key );

		return wp_app_response()->json(
			[
				'data' => [
					'user' => $user,
					'wp_user' => wp_get_current_user(),
				],
			]
		);
	}
}
