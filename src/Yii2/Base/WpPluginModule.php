<?php


namespace Enpii\Wp\EnpiiBase\Yii2\Base;


use yii\base\Module;

abstract class WpPluginModule extends Module implements WpPluginInterface {
	public $text_domain = 'default';
}
