<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Symfony\Component\Console\NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_Attribute;

/**
 * Service tag to autoconfigure commands.
 */
#[\NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_Attribute(\NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_Attribute::TARGET_CLASS)]
class AsCommand
{
    public function __construct(
        public string $name,
        public ?string $description = null,
        array $aliases = [],
        bool $hidden = false,
    ) {
        if (!$hidden && !$aliases) {
            return;
        }

        $name = explode('|', $name);
        $name = array_merge($name, $aliases);

        if ($hidden && '' !== $name[0]) {
            array_unshift($name, '');
        }

        $this->name = implode('|', $name);
    }
}
