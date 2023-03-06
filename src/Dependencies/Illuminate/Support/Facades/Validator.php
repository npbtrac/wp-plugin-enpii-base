<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support\Facades;

/**
 * @method static \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\Validation\Validator make(array $data, array $rules, array $messages = [], array $customAttributes = [])
 * @method static void extend(string $rule, \Closure|string $extension, string $message = null)
 * @method static void extendImplicit(string $rule, \Closure|string $extension, string $message = null)
 * @method static void replacer(string $rule, \Closure|string $replacer)
 *
 * @see \Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Validation\Factory
 */
class Validator extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'validator';
    }
}
