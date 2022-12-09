<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Support;

interface DeferringDisplayableValue
{
    /**
     * Resolve the displayable value that the class is deferring.
     *
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Support\Htmlable|string
     */
    public function resolveDisplayableValue();
}
