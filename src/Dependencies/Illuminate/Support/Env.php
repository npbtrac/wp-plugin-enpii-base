<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Illuminate\Support;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\Dotenv\Repository\Adapter\EnvConstAdapter;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Dotenv\Repository\Adapter\PutenvAdapter;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Dotenv\Repository\Adapter\ServerConstAdapter;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\Dotenv\Repository\RepositoryBuilder;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\PhpOption\Option;

class Env
{
    /**
     * Indicates if the putenv adapter is enabled.
     *
     * @var bool
     */
    protected static $putenv = true;

    /**
     * The environment repository instance.
     *
     * @var \Enpii\WP_Plugin\Enpii_Base\Dependencies\Dotenv\Repository\RepositoryInterface|null
     */
    protected static $repository;

    /**
     * Enable the putenv adapter.
     *
     * @return void
     */
    public static function enablePutenv()
    {
        static::$putenv = true;
        static::$repository = null;
    }

    /**
     * Disable the putenv adapter.
     *
     * @return void
     */
    public static function disablePutenv()
    {
        static::$putenv = false;
        static::$repository = null;
    }

    /**
     * Get the environment repository instance.
     *
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\Dotenv\Repository\RepositoryInterface
     */
    public static function getRepository()
    {
        if (static::$repository === null) {
            $adapters = array_merge(
                [new EnvConstAdapter, new ServerConstAdapter],
                static::$putenv ? [new PutenvAdapter] : []
            );

            static::$repository = RepositoryBuilder::create()
                ->withReaders($adapters)
                ->withWriters($adapters)
                ->immutable()
                ->make();
        }

        return static::$repository;
    }

    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        return Option::fromValue(static::getRepository()->get($key))
            ->map(function ($value) {
                switch (strtolower($value)) {
                    case 'true':
                    case '(true)':
                        return true;
                    case 'false':
                    case '(false)':
                        return false;
                    case 'empty':
                    case '(empty)':
                        return '';
                    case 'null':
                    case '(null)':
                        return;
                }

                if (preg_match('/\A([\'"])(.*)\1\z/', $value, $matches)) {
                    return $matches[2];
                }

                return $value;
            })
            ->getOrCall(function () use ($default) {
                return value($default);
            });
    }
}