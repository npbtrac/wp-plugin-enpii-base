<?php

declare(strict_types=1);

namespace Enpii_Base\App\Jobs;

use Enpii_Base\Foundation\Bus\Dispatchable_Trait;
use Enpii_Base\Foundation\Shared\Base_Job;
use Illuminate\Support\Facades\Session;

class Show_Admin_Notice_From_Flash_Messages_Job extends Base_Job {
	use Dispatchable_Trait;

	/**
	 * We want to show Admin notice for 4 types of messages: 'error', 'success', 'warning', 'info'
	 *
	 * @return void
	 */
	public function handle() {
		foreach (['error', 'success', 'warning', 'info'] as $type) {
			if (Session::has($type)) {
				wp_admin_notice(
					implode('<br />', Session::get($type)),
					[
						'dismissible' => false,
						'type' => $type,
					]
				);
			}
		}
	}
}
