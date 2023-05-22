<?php

namespace Enpii_Base\Deps\Illuminate\Http\Exceptions;

use Enpii_Base\Deps\Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class PostTooLargeException extends HttpException
{
    /**
     * Create a new "post too large" exception instance.
     *
     * @param  string|null  $message
     * @param  \Throwable|null  $previous
     * @param  array  $headers
     * @param  int  $code
     * @return void
     */
    public function __construct($message = null, Throwable $previous = null, array $headers = [], $code = 0)
    {
        parent::__construct(413, $message, $previous, $headers, $code);
    }
}
