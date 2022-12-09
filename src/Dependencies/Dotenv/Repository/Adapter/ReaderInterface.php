<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Repository\Adapter;

interface ReaderInterface extends AvailabilityInterface
{
    /**
     * Get an environment variable, if it exists.
     *
     * @param non-empty-string $name
     *
     * @return \Enpii\Wp_Plugin\Enpii_Base\Dependencies\PhpOption\Option<string|null>
     */
    public function get($name);
}
