<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\Flysystem;

use ErrorException;

class ConnectionErrorException extends ErrorException implements FilesystemException
{
}
