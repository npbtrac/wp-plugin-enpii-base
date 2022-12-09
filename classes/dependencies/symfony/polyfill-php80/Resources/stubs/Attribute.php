<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

#[NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_Attribute(Attribute::TARGET_CLASS)]
final class NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_NpWpNPB_Attribute
{
    public const TARGET_CLASS = 1;
    public const TARGET_FUNCTION = 2;
    public const TARGET_METHOD = 4;
    public const TARGET_PROPERTY = 8;
    public const TARGET_CLASS_CONSTANT = 16;
    public const TARGET_PARAMETER = 32;
    public const TARGET_ALL = 63;
    public const IS_REPEATABLE = 64;

    /** @var int */
    public $flags;

    public function __construct(int $flags = self::TARGET_ALL)
    {
        $this->flags = $flags;
    }
}
