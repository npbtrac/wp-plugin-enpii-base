<?php

declare(strict_types=1);

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Doctrine\Inflector;

interface WordInflector
{
    public function inflect(string $word): string;
}
