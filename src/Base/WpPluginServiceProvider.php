<?php
declare(strict_types=1);

namespace Enpiicom\WpPlugin\EnpiiBase\Base;

use Enpiicom\WpPlugin\EnpiiBase\Base\Traits\ConfigTrait;
use Illuminate\Support\ServiceProvider;

/**
 * Class WpPluginServiceProvider
 * @package Enpiicom\WpPlugin\EnpiiBase\Base
 * @property WpApp $app
 */
class WpPluginServiceProvider extends ServiceProvider
{
    use ConfigTrait;

    /**
     * @var string Version of this plugin
     */
    protected $version;

    /**
     * @var string Base path to this plugin
     */
    protected $basePath;

    /**
     * @var string Base url of the folder of this plugin
     */
    protected $baseUrl;
}
