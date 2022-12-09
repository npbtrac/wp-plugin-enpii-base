<?php

declare(strict_types=1);

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\MimeTypeDetection;

interface ExtensionToMimeTypeMap
{
    public function lookupMimeType(string $extension): ?string;
}
