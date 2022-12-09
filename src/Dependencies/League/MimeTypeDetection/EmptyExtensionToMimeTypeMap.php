<?php

declare(strict_types=1);

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\MimeTypeDetection;

class EmptyExtensionToMimeTypeMap implements ExtensionToMimeTypeMap
{
    public function lookupMimeType(string $extension): ?string
    {
        return null;
    }
}
