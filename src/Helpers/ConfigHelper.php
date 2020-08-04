<?php


namespace Enpiicom\WpPlugin\EnpiiBase\Helpers;


use Enpiicom\WpPlugin\EnpiiBase\Base\WpApp;
use Illuminate\Config\Repository;

class ConfigHelper
{
    public static function setPluginConfig($config, array $arrKeyValue): array
    {
        if (empty($config['app'])) {
            $config['app'] = [
            ];
        }

        if (empty($config['app']['plugins'])) {
            $config['app']['plugins'] = [];
        }
        $config['app']['plugins'] = ArrayHelper::merge($config['app']['plugins'], $arrKeyValue);

        return $config;
    }

    public static function getWpAppPluginConfig($classname)
    {
        /** @var Repository $config */
        $config = WpApp::getInstance()->make('config');

        return $config->get('app.plugins.'.$classname);
    }
}