<?php

declare(strict_types=1);

namespace Enpii_Base\App\Jobs;

use Enpii_Base\Foundation\Bus\Dispatchable_Trait;
use Enpii_Base\Foundation\Shared\Base_Job;
use Enpii_Base\Foundation\WP\WP_Plugin_Interface;

class Show_Admin_Notice_And_Disable_Plugin_Job extends Base_Job {
	use Dispatchable_Trait;

	/**
	 * @var \Enpii_Base\Foundation\WP\WP_Plugin
	 */
	protected $plugin;
	protected $extra_messages;

	public function __construct(WP_Plugin_Interface $plugin, array $extra_messages = [])
	{
		$this->plugin = $plugin;
		$this->extra_messages = $extra_messages;
	}

	public function handle() {
		if (!class_exists(WooCommerce::class)) {
			$messages = $this->extra_messages;
			$messages[] = sprintf(
				__('Plugin <strong>%s</strong> is disabled.', $this->plugin->get_text_domain()),
				$this->plugin->get_name(). ' ' . $this->plugin->get_version()
			);
			wp_admin_notice(
				$this->build_html_messages($messages),
				[
					'dismissible' => false,
					'type' => 'warning',
				]
			);

			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			deactivate_plugins( $this->plugin->get_plugin_basename() );

			return;
		}
	}

	protected function build_html_messages(array $messages): string {
		return implode('<br />', $messages);
	}
}
