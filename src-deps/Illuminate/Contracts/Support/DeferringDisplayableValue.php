<?php

namespace Enpii_Base\Deps\Illuminate\Contracts\Support;

interface DeferringDisplayableValue
{
    /**
     * Resolve the displayable value that the class is deferring.
     *
     * @return \Enpii_Base\Deps\Illuminate\Contracts\Support\Htmlable|string
     */
    public function resolveDisplayableValue();
}
