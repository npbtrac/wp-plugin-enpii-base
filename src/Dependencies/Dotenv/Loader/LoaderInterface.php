<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Loader;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Repository\RepositoryInterface;

interface LoaderInterface
{
    /**
     * Load the given environment file content into the repository.
     *
     * @param \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Repository\RepositoryInterface $repository
     * @param string                                 $content
     *
     * @throws \Enpii\Wp_Plugin\Enpii_Base\Dependencies\Dotenv\Exception\InvalidFileException
     *
     * @return array<string,string|null>
     */
    public function load(RepositoryInterface $repository, $content);
}
