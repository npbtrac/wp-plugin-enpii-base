<?php declare(strict_types=1);

/*
 * This file is part of the Enpii\Wp_Plugin\Enpii_Base\Dependencies\Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Monolog;

use ArrayAccess;

/**
 * Enpii\Wp_Plugin\Enpii_Base\Dependencies\Monolog log record interface for forward compatibility with Enpii\Wp_Plugin\Enpii_Base\Dependencies\Monolog 3.0
 *
 * This is just present in Enpii\Wp_Plugin\Enpii_Base\Dependencies\Monolog 2.4+ to allow interoperable code to be written against
 * both versions by type-hinting arguments as `array|\Enpii\Wp_Plugin\Enpii_Base\Dependencies\Monolog\LogRecord $record`
 *
 * Do not rely on this interface for other purposes, and do not implement it.
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 * @template-extends \ArrayAccess<'message'|'level'|'context'|'level_name'|'channel'|'datetime'|'extra'|'formatted', mixed>
 * @phpstan-import-type Record from Logger
 */
interface LogRecord extends \ArrayAccess
{
    /**
     * @phpstan-return Record
     */
    public function toArray(): array;
}
