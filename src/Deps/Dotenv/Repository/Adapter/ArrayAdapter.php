<?php

namespace Enpii_Base\Deps\Dotenv\Repository\Adapter;

use Enpii_Base\Deps\PhpOption\None;
use Enpii_Base\Deps\PhpOption\Some;

class ArrayAdapter implements AvailabilityInterface, ReaderInterface, WriterInterface
{
    /**
     * The variables and their values.
     *
     * @var array<non-empty-string,string|null>
     */
    private $variables = [];

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
     * @return \Enpii_Base\Deps\PhpOption\Option<string|null>
     */
    public function get($name)
    {
        if (!array_key_exists($name, $this->variables)) {
            return None::create();
        }

        return Some::create($this->variables[$name]);
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
        $this->variables[$name] = $value;
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
        unset($this->variables[$name]);
    }
}