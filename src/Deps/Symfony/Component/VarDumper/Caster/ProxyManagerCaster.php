<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii_Base\Deps\Symfony\Component\VarDumper\Caster;

use ProxyManager\Proxy\ProxyInterface;
use Enpii_Base\Deps\Symfony\Component\VarDumper\Cloner\Stub;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @final
 */
class ProxyManagerCaster
{
    public static function castProxy(ProxyInterface $c, array $a, Stub $stub, bool $isNested)
    {
        if ($parent = get_parent_class($c)) {
            $stub->class .= ' - '.$parent;
        }
        $stub->class .= '@proxy';

        return $a;
    }
}
