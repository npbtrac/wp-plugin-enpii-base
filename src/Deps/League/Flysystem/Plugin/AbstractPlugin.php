<?php

namespace Enpii_Base\Deps\League\Flysystem\Plugin;

use Enpii_Base\Deps\League\Flysystem\FilesystemInterface;
use Enpii_Base\Deps\League\Flysystem\PluginInterface;

abstract class AbstractPlugin implements PluginInterface
{
    /**
     * @var FilesystemInterface
     */
    protected $filesystem;

    /**
     * Set the Filesystem object.
     *
     * @param FilesystemInterface $filesystem
     */
    public function setFilesystem(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }
}
