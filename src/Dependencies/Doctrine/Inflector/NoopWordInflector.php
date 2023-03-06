<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Doctrine\Inflector;

class NoopWordInflector implements WordInflector
{
    public function inflect(string $word): string
    {
        return $word;
    }
}
