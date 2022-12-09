<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Queue;

use InvalidArgumentException;

class InvalidPayloadException extends InvalidArgumentException
{
    /**
     * Create a new exception instance.
     *
     * @param  string|null  $message
     * @return void
     */
    public function __construct($message = null)
    {
        parent::__construct($message ?: json_last_error());
    }
}