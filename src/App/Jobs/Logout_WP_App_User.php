<?php

namespace Enpii_Base\App\Jobs;

use Enpii_Base\Foundation\Shared\Base_Job;
use Enpii_Base\Foundation\Support\Executable_Trait;
use Illuminate\Support\Facades\Auth;

class Logout_WP_App_User extends Base_Job {
	use Executable_Trait;

	public function handle() {
		/** @var \Illuminate\Auth\SessionGuard $auth */
		$auth = wp_app_auth();
		dev_error_log( 'before_logout', $auth->getSession() );
		Auth::logoutCurrentDevice();
		wp_app_session()->save();
		dev_error_log( 'after_logout', $auth->getSession() );
	}
}
