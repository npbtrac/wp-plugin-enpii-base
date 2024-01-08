<?php

namespace Enpii_Base\App\Jobs;

use Enpii_Base\App\Models\User;
use Enpii_Base\Foundation\Shared\Base_Job;
use Enpii_Base\Foundation\Support\Executable_Trait;
use Illuminate\Support\Facades\Auth;

class Login_WP_App_User extends Base_Job {
	use Executable_Trait;

	protected $user;

	public function __construct( $user_id ) {
		$this->user = User::findOrFail( $user_id );
	}

	public function handle() {
		Auth::login( $this->user );
	}
}
