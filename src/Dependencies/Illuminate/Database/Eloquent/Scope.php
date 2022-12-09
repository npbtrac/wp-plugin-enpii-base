<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Eloquent;

interface Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model);
}
