<?php

declare(strict_types=1);

namespace Enpii_Base\Deps\League\MimeTypeDetection;

interface ExtensionToMimeTypeMap
{
    public function lookupMimeType(string $extension): ?string;
}
