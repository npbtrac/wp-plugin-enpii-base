<?php

namespace Enpii_Base\Deps\Illuminate\Http;

use Enpii_Base\Deps\Symfony\Component\HttpFoundation\File\File as SymfonyFile;

class File extends SymfonyFile
{
    use FileHelpers;
}
