<?php
declare(strict_types=1);

namespace Enpiicom\WpPlugin\EnpiiBase\Base;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;

class WpApp extends Application
{
    public function registerPlugins()
    {
        /** @var Repository $config */
        $config = $this->make('config');
        $configPlugins = $config->get('app.plugins');

        if (!empty($configPlugins)) {
            foreach ((array)$configPlugins as $pluginClass => $pluginConfig) {
                $this->register(new $pluginClass($this));
            }
        }
    }
}
