<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\Dotenv\Repository\Adapter;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\PhpOption\None;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\PhpOption\Some;

class ServerConstAdapter implements AvailabilityInterface, ReaderInterface, WriterInterface
{
    /**
     * Determines if the adapter is supported.
     *
     * @return bool
     */
    public function isSupported()
    {
        return true;
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
        if (!array_key_exists($name, $_SERVER)) {
            return None::create();
        }

        $value = $_SERVER[$name];

        if (is_scalar($value)) {
            /** @var \Enpii\WP_Plugin\Enpii_Base\Dependencies\PhpOption\Option<string|null> */
            return Some::create((string) $value);
        }

        if (null === $value) {
            /** @var \Enpii\WP_Plugin\Enpii_Base\Dependencies\PhpOption\Option<string|null> */
            return Some::create(null);
        }

        return None::create();
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
        $_SERVER[$name] = $value;
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
        unset($_SERVER[$name]);
    }
}
