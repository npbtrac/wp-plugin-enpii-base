<?php

declare(strict_types=1);

namespace Enpii_Base\App\Http\Controllers\Api;

use Enpii_Base\App\Models\User;
use Enpii_Base\App\Queries\Get_WP_App_Info;
use Enpii_Base\App\Support\App_Const;
use Symfony\Component\HttpFoundation\JsonResponse;
use Enpii_Base\Foundation\Http\Base_Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\PersonalAccessTokenFactory;

class Main_Controller extends Base_Controller {
	public function home(): JsonResponse {
		return wp_app_response()->json(
			[
				'message' => 'Welcome to WP App API',
			]
		);
	}

	public function wp_admin(): JsonResponse {
		$data = Get_WP_App_Info::execute_now();
		if ( ! empty( wp_get_current_user() ) ) {
			$data['current_logged_in_user'] = wp_get_current_user();
		}

		return wp_app_response()->json(
			[
				'message' => 'WP App API Info',
				'data'    => $data,
			]
		);
	}

	public function queue_work() {
		do_action( App_Const::ACTION_WP_APP_QUEUE_WORK );

		return wp_app_response()->json(
			[
				'message' => 'Queue executed',
			]
		);
	}

	public function user_login( FormRequest $request ): JsonResponse {
		$username = $request->get( 'username' );
		$password = $request->get( 'password' );
		/** @var \WP_User $wp_user */
		$wp_user = wp_authenticate_username_password( null, $username, $password );

		if ( ! empty( $wp_user->data ) ) {
			$user = new User( (array) $wp_user->data );
			return wp_app_response()->json(
				[
					'data' => [
						'user' => $user,
						'personal_access' => $user->personal_access_by_request(),
					],
				]
			);
		}

		return wp_app_response()->json(
			[
				'message' => 'failed',
			],
			401
		);
	}
}
