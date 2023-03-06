<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpKernel\DataCollector;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Request;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\Response;

/**
 * @author Bart van den Burg <bart@burgov.nl>
 *
 * @final
 */
class AjaxDataCollector extends DataCollector
{
    public function collect(Request $request, Response $response, \Throwable $exception = null)
    {
        // all collecting is done client side
    }

    public function reset()
    {
        // all collecting is done client side
    }

    public function getName(): string
    {
        return 'ajax';
    }
}
