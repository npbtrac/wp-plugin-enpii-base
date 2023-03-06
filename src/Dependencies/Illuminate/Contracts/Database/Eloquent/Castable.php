<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Database\Eloquent;

interface Castable
{
    /**
     * Get the name of the caster class to use when casting from / to this cast target.
     *
     * @return string|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Database\Eloquent\CastsAttributes|\Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes
     */
    public static function castUsing();
}
