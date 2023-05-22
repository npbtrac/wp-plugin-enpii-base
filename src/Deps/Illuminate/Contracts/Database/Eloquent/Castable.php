<?php

namespace Enpii_Base\Deps\Illuminate\Contracts\Database\Eloquent;

interface Castable
{
    /**
     * Get the name of the caster class to use when casting from / to this cast target.
     *
     * @return string|\Enpii_Base\Deps\Illuminate\Contracts\Database\Eloquent\CastsAttributes|\Enpii_Base\Deps\Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes
     */
    public static function castUsing();
}
