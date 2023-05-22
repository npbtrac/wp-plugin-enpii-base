<?php

namespace Enpii_Base\Deps\Illuminate\Routing\Exceptions;

use Enpii_Base\Deps\Symfony\Component\HttpKernel\Exception\HttpException;

class InvalidSignatureException extends HttpException
{
    /**
     * Create a new exception instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(403, 'Invalid signature.');
    }
}
