<?php

namespace Enpii_Base\Deps\Dotenv\Loader;

use Enpii_Base\Deps\Dotenv\Repository\RepositoryInterface;

interface LoaderInterface
{
    /**
     * Load the given environment file content into the repository.
     *
     * @param \Enpii_Base\Deps\Dotenv\Repository\RepositoryInterface $repository
     * @param string                                 $content
     *
     * @throws \Enpii_Base\Deps\Dotenv\Exception\InvalidFileException
     *
     * @return array<string,string|null>
     */
    public function load(RepositoryInterface $repository, $content);
}
