<?php

declare(strict_types=1);

namespace Enpii_Base\App\Jobs;

use Enpii_Base\Foundation\Bus\Dispatchable_Trait;
use Enpii_Base\Foundation\Shared\Base_Job;
use PHPUnit\Framework\ExpectationFailedException;
use Exception;

class Write_Setup_Client_Script_Job extends Base_Job {
	use Dispatchable_Trait;

	/**
	 * We write client script to send ajax request to the setup url on the screen right after
	 *  the plugin is activated
	 *
	 * @return void
	 * @throws ExpectationFailedException
	 * @throws Exception
	 */
	public function handle(): void {
		/** @var \WP_Screen $current_screen */
		global $current_screen;

		if ( is_admin() && $current_screen->id === 'plugins' && $current_screen->parent_file === 'plugins.php' && ! empty( $_GET['activate'] ) ) {
			$setup_url = esc_url( home_url() . '/' . enpii_base_get_wp_app_prefix() . '' . '/wp-admin/admin/setup?force_app_running_in_console=1' );

			echo <<<SCRIPT
			<script type="text/javascript">
				var enpii_base_setup_url = '$setup_url';
				if (typeof(jQuery) !== 'undefined') {
					jQuery.ajax({
						url: enpii_base_setup_url,
						  method: "GET"
					});
				} else {
					const response = fetch(enpii_base_setup_url);
				}
			</script>
SCRIPT;
		}
	}
}
