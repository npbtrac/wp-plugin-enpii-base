<?php

namespace Enpii_Base\Deps\Dotenv\Store;

interface StoreInterface
{
    /**
     * Read the content of the environment file(s).
     *
     * @throws \Enpii_Base\Deps\Dotenv\Exception\InvalidPathException
     *
     * @return string
     */
    public function read();
}
