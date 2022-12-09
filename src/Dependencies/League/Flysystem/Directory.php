<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\League\Flysystem;

/**
 * @deprecated
 */
class Directory extends Handler
{
    /**
     * Delete the directory.
     *
     * @return bool
     */
    public function delete()
    {
        return $this->filesystem->deleteDir($this->path);
    }

    /**
     * List the directory contents.
     *
     * @param bool $recursive
     *
     * @return array|bool directory contents or false
     */
    public function getContents($recursive = false)
    {
        return $this->filesystem->listContents($this->path, $recursive);
    }
}
