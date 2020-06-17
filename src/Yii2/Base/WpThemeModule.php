<?php


namespace Enpii\Wp\EnpiiBase\Yii2\Base;


use yii\base\Module;

abstract class WpThemeModule extends Module implements WpThemeInterface {
	public $text_domain = 'default';
}
