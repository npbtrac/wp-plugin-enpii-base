<?php


namespace Enpii\Wp\EnpiiBase\Yii2\Base;


interface WpPluginInterface {
	/**
	 * A method to initialize every thing to be used in a plugin
	 *
	 * @return void
	 */
	public function init_plugin();
}
