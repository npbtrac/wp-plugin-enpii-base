<?php

namespace Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\View\Engines;

use Enpii\Wp_Plugin\Enpii_Base\Dependencies\Illuminate\Contracts\View\Engine;

class FileEngine implements Engine
{
    /**
     * Get the evaluated contents of the view.
     *
     * @param  string  $path
     * @param  array  $data
     * @return string
     */
    public function get($path, array $data = [])
    {
        return file_get_contents($path);
    }
}
