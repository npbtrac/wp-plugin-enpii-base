<?php

namespace Enpii_Base\Deps\Illuminate\Database\Eloquent;

interface Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Enpii_Base\Deps\Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model);
}
