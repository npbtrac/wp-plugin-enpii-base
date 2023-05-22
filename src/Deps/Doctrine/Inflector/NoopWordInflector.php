<?php

declare(strict_types=1);

namespace Enpii_Base\Deps\Doctrine\Inflector;

class NoopWordInflector implements WordInflector
{
    public function inflect(string $word): string
    {
        return $word;
    }
}
