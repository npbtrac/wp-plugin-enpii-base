<?php

use Enpii\Wp\EnpiiBase\Components\Acf;

$text_domain = 'enpii';

$base_path = dirname( __DIR__ );

// Second param needs to be the __FILE__ of the bootstrap file for plugin, on base folder of plugin
// In this case, current file is in the sub-folder so we need to use __DIR__ to get correct URL
$base_url = plugins_url( null, __DIR__ );

$config = [
	'basePath'    => $base_path,
	'base_path'   => $base_path,
	'base_url'    => $base_url,
	'components'  => [
		Acf::class => [
			'__class'     => Acf::class,
			'text_domain' => $text_domain,
		],
	],
	'text_domain' => $text_domain,
];

return $config;
