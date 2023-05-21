<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\League\Plates\Extension;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\Plates\Engine;

/**
 * A common interface for extensions.
 */
interface ExtensionInterface
{
    public function register(Engine $engine);
}
