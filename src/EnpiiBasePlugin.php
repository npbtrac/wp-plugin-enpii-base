<?php


namespace Enpiicom\WpPlugin\EnpiiBase;


use Enpiicom\WpPlugin\EnpiiBase\Base\WpPluginServiceProvider;
use Enpiicom\WpPlugin\EnpiiBase\Helpers\ConfigHelper;

class EnpiiBasePlugin extends WpPluginServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $config = ConfigHelper::getWpAppPluginConfig(get_called_class());
        $this->bindConfig($config);
        $this->registerHooks();
    }

    public function registerHooks()
    {

    }
}
