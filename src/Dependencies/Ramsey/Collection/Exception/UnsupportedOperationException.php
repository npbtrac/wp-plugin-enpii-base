<?php

/**
 * This file is part of the ramsey/collection library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Ben Ramsey <ben@benramsey.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Ramsey\Collection\Exception;

/**
 * Thrown to indicate that the requested operation is not supported.
 */
class UnsupportedOperationException extends \RuntimeException
{
}