<?php

namespace Enpii_Base\Deps\Dotenv\Repository\Adapter;

interface ReaderInterface extends AvailabilityInterface
{
    /**
     * Get an environment variable, if it exists.
     *
     * @param non-empty-string $name
     *
     * @return \Enpii_Base\Deps\PhpOption\Option<string|null>
     */
    public function get($name);
}
