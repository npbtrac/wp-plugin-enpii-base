<?php

declare(strict_types=1);

namespace Enpii_Base\App\Jobs;

use Enpii_Base\Foundation\Shared\Base_Job;
use Enpii_Base\Foundation\Support\Executable_Trait;
use Illuminate\Contracts\Container\BindingResolutionException;
use PHPUnit\Framework\ExpectationFailedException;
use Exception;

class Write_Web_Worker_Script_Job extends Base_Job {
	use Executable_Trait;

	/**
	 * Write a js to have periodly ajax request to handle the queue
	 *
	 * @return void
	 * @throws BindingResolutionException
	 * @throws ExpectationFailedException
	 * @throws Exception
	 */
	public function handle(): void {
		// We want to add the trailing slash to avoid the redirect in WP webserver rule
		$web_worker_url = esc_js( wp_app_route_wp_url( 'wp-api::web-worker' ) . '/' );

		// We want to have an interval that works every 5 mins (300 000 miliseconds)
		//  to perform the web worker (queue, scheduler worker) execution
		$script = <<<SCRIPT
		<script type="text/javascript">
			var enpii_base_web_worker_url = '$web_worker_url';
			function ajax_request_to_web_worker() {
				if (typeof(jQuery) !== 'undefined') {
					jQuery.ajax({
						url: enpii_base_web_worker_url,
						method: "POST"
					});
				} else {
					const response = fetch(enpii_base_web_worker_url);
				}
			}
			var ajax_request_to_web_worker_interval = window.setInterval(function(){
				ajax_request_to_web_worker();
			}, 7*60*1000);
			window.setTimeout(function() {
				ajax_request_to_web_worker();
			}, 1000);
		</script>
SCRIPT;

		// We suppress phpcs rule here because we escape the variable already
		//  the rest of the script are static text
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $script;
	}
}
