<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Dotenv\Repository\Adapter;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\PhpOption\Option;

class PutenvAdapter implements AvailabilityInterface, ReaderInterface, WriterInterface
{
    /**
     * Determines if the adapter is supported.
     *
     * @return bool
     */
    public function isSupported()
    {
        return function_exists('getenv') && function_exists('putenv');
    }

    /**
     * Get an environment variable, if it exists.
     *
     * @param non-empty-string $name
     *
     * @return \Enpii\WP_Plugin\Enpii_Base\Dependencies\PhpOption\Option<string|null>
     */
    public function get($name)
    {
        /** @var \Enpii\WP_Plugin\Enpii_Base\Dependencies\PhpOption\Option<string|null> */
        return Option::fromValue(getenv($name), false);
    }

    /**
     * Set an environment variable.
     *
     * @param non-empty-string $name
     * @param string|null      $value
     *
     * @return void
     */
    public function set($name, $value = null)
    {
        putenv("$name=$value");
    }

    /**
     * Clear an environment variable.
     *
     * @param non-empty-string $name
     *
     * @return void
     */
    public function clear($name)
    {
        putenv($name);
    }
}