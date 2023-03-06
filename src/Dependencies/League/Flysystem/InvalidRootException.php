<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\League\Flysystem;

use RuntimeException;

class InvalidRootException extends RuntimeException implements FilesystemException
{
}
