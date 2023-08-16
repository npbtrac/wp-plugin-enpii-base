<?php

namespace Enpii_Base\Deps\League\Plates\Extension;

use Enpii_Base\Deps\League\Plates\Engine;

/**
 * A common interface for extensions.
 */
interface ExtensionInterface
{
    public function register(Engine $engine);
}
