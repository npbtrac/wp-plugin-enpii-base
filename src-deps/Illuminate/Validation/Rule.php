<?php

namespace Enpii_Base\Deps\Illuminate\Validation;

use Enpii_Base\Deps\Illuminate\Contracts\Support\Arrayable;
use Enpii_Base\Deps\Illuminate\Support\Traits\Macroable;
use Enpii_Base\Deps\Illuminate\Validation\Rules\Dimensions;
use Enpii_Base\Deps\Illuminate\Validation\Rules\Exists;
use Enpii_Base\Deps\Illuminate\Validation\Rules\In;
use Enpii_Base\Deps\Illuminate\Validation\Rules\NotIn;
use Enpii_Base\Deps\Illuminate\Validation\Rules\RequiredIf;
use Enpii_Base\Deps\Illuminate\Validation\Rules\Unique;

class Rule
{
    use Macroable;

    /**
     * Get a dimensions constraint builder instance.
     *
     * @param  array  $constraints
     * @return \Enpii_Base\Deps\Illuminate\Validation\Rules\Dimensions
     */
    public static function dimensions(array $constraints = [])
    {
        return new Dimensions($constraints);
    }

    /**
     * Get an exists constraint builder instance.
     *
     * @param  string  $table
     * @param  string  $column
     * @return \Enpii_Base\Deps\Illuminate\Validation\Rules\Exists
     */
    public static function exists($table, $column = 'NULL')
    {
        return new Exists($table, $column);
    }

    /**
     * Get an in constraint builder instance.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Contracts\Support\Arrayable|array|string  $values
     * @return \Enpii_Base\Deps\Illuminate\Validation\Rules\In
     */
    public static function in($values)
    {
        if ($values instanceof Arrayable) {
            $values = $values->toArray();
        }

        return new In(is_array($values) ? $values : func_get_args());
    }

    /**
     * Get a not_in constraint builder instance.
     *
     * @param  \Enpii_Base\Deps\Illuminate\Contracts\Support\Arrayable|array|string  $values
     * @return \Enpii_Base\Deps\Illuminate\Validation\Rules\NotIn
     */
    public static function notIn($values)
    {
        if ($values instanceof Arrayable) {
            $values = $values->toArray();
        }

        return new NotIn(is_array($values) ? $values : func_get_args());
    }

    /**
     * Get a required_if constraint builder instance.
     *
     * @param  callable|bool  $callback
     * @return \Enpii_Base\Deps\Illuminate\Validation\Rules\RequiredIf
     */
    public static function requiredIf($callback)
    {
        return new RequiredIf($callback);
    }

    /**
     * Get a unique constraint builder instance.
     *
     * @param  string  $table
     * @param  string  $column
     * @return \Enpii_Base\Deps\Illuminate\Validation\Rules\Unique
     */
    public static function unique($table, $column = 'NULL')
    {
        return new Unique($table, $column);
    }
}
