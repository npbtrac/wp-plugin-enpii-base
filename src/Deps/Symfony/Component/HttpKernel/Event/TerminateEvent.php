<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enpii_Base\Deps\Symfony\Component\HttpKernel\Event;

use Enpii_Base\Deps\Symfony\Component\HttpFoundation\Request;
use Enpii_Base\Deps\Symfony\Component\HttpFoundation\Response;
use Enpii_Base\Deps\Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Allows to execute logic after a response was sent.
 *
 * Since it's only triggered on main requests, the `getRequestType()` method
 * will always return the value of `HttpKernelInterface::MAIN_REQUEST`.
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
final class TerminateEvent extends KernelEvent
{
    private $response;

    public function __construct(HttpKernelInterface $kernel, Request $request, Response $response)
    {
        parent::__construct($kernel, $request, HttpKernelInterface::MAIN_REQUEST);

        $this->response = $response;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}
