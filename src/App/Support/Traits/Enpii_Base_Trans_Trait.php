<?php

declare(strict_types=1);

namespace Enpii_Base\App\Support\Traits;

use Enpii_Base\App\WP\Enpii_Base_WP_Plugin;

trait Enpii_Base_Trans_Trait {
	// phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
	public function _t( $untranslated_text ) {
		return Enpii_Base_WP_Plugin::wp_app_instance()->_t( $untranslated_text );
	}
}
