<?php

namespace Enpii\WP_Plugin\Enpii_Base\Dependencies\League\Flysystem\Plugin;

use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\Flysystem\FilesystemInterface;
use Enpii\WP_Plugin\Enpii_Base\Dependencies\League\Flysystem\PluginInterface;

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