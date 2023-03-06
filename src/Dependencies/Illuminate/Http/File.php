<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Http;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Symfony\Component\HttpFoundation\File\File as SymfonyFile;

class File extends SymfonyFile
{
    use FileHelpers;
}
