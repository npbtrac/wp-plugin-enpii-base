<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Container;

use Exception;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Psr\Container\NotFoundExceptionInterface;

class EntryNotFoundException extends Exception implements NotFoundExceptionInterface
{
    //
}
