<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Store;

interface StoreInterface
{
    /**
     * Read the content of the environment file(s).
     *
     * @throws \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Exception\InvalidPathException
     *
     * @return string
     */
    public function read();
}
