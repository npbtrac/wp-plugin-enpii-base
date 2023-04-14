<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Foundation\Shared\Interfaces;

interface Query_Handler_Inferface {
	/**
	 * The method is to handle the action
	 */
	public function handle( Query_Interface $query );
}
