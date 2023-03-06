<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\EventDispatcher\NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_Attribute;

/**
 * Service tag to autoconfigure event listeners.
 *
 * @author Alexander M. Turek <me@derrabus.de>
 */
#[\NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_Attribute(\NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_Attribute::TARGET_CLASS | \NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_Attribute::TARGET_METHOD | \NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_Attribute::IS_REPEATABLE)]
class AsEventListener
{
    public function __construct(
        public ?string $event = null,
        public ?string $method = null,
        public int $priority = 0,
        public ?string $dispatcher = null,
    ) {
    }
}
