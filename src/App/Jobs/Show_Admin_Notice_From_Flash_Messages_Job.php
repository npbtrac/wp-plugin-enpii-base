<?php

declare(strict_types=1);

namespace Enpii_Base\App\Jobs;

use Enpii_Base\Foundation\Shared\Base_Job;
use Enpii_Base\Foundation\Support\Executable_Trait;
use Illuminate\Support\Facades\Session;

class Show_Admin_Notice_From_Flash_Messages_Job extends Base_Job {
	use Executable_Trait;

	/**
	 * We want to show Admin notice for 4 types of messages: 'error', 'success', 'warning', 'info'
	 *
	 * @return void
	 */
	public function handle() {
		$flash_keys = [ 'admin-error', 'admin-success', 'admin-info', 'admin-caution' ];
		foreach ( $flash_keys as $type ) {
			if ( Session::has( $type ) && ! empty( Session::get( $type ) ) ) {
				$display_type = str_replace( 'admin-', '', $type );
				wp_admin_notice(
					$this->build_html_messages( (array) Session::get( $type ) ),
					[
						'dismissible' => true,
						'type' => ( $display_type === 'caution' ? 'warning' : $display_type ),
					]
				);
				Session::forget( $type );
			}
		}
		Session::save();
	}

	protected function build_html_messages( array $messages ): string {
		$extracted_messages = [];
		array_walk_recursive(
			$messages,
			function ( $value ) use ( &$extracted_messages ) {
				$extracted_messages[] = $value;
			}
		);

		return implode( '<br />', $extracted_messages );
	}
}
