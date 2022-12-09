<?php

declare(strict_types=1);

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Doctrine\Inflector\Rules;

final class Substitution
{
    /** @var Word */
    private $from;

    /** @var Word */
    private $to;

    public function __construct(Word $from, Word $to)
    {
        $this->from = $from;
        $this->to   = $to;
    }

    public function getFrom(): Word
    {
        return $this->from;
    }

    public function getTo(): Word
    {
        return $this->to;
    }
}
