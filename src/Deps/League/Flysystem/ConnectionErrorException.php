<?php

namespace Enpii_Base\Deps\League\Flysystem;

use ErrorException;

class ConnectionErrorException extends ErrorException implements FilesystemException
{
}
