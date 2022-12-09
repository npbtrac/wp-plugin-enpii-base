<?php

/**
 * This file is part of the Enpii\Wp_Plugin\Enpii_Base\Dependencies\Carbon package.
 *
 * (c) Brian Nesbitt <brian@nesbot.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Carbon\Traits;

use Closure;

/**
 * Trait ToStringFormat.
 *
 * Handle global format customization for string cast of the object.
 */
trait ToStringFormat
{
    /**
     * Format to use for __toString method when type juggling occurs.
     *
     * @var string|Closure|null
     */
    protected static $toStringFormat;

    /**
     * Reset the format used to the default when type juggling a Enpii\Wp_Plugin\Enpii_Base\Dependencies\Carbon instance to a string
     *
     * @return void
     */
    public static function resetToStringFormat()
    {
        static::setToStringFormat(null);
    }

    /**
     * @param string|Closure|null $format
     *
     * @return void
     *
     * @deprecated To avoid conflict between different third-party libraries, static setters should not be used.
     *             You should rather let Enpii\Wp_Plugin\Enpii_Base\Dependencies\Carbon object being cast to string with DEFAULT_TO_STRING_FORMAT, and
     *             use other method or custom format passed to format() method if you need to dump another string
     *             format.
     *
     * Set the default format used when type juggling a Enpii\Wp_Plugin\Enpii_Base\Dependencies\Carbon instance to a string.
     */
    public static function setToStringFormat($format)
    {
        static::$toStringFormat = $format;
    }
}