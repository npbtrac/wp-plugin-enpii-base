<?php

use yii\caching\FileCache;
use yii\swiftmailer\Mailer;

$config = [
	'id'         => 'enpii-base',
	'basePath'   => dirname( __DIR__ ),
	'bootstrap'  => [ 'log' ],
	'aliases'    => [
		'@bower' => '@vendor/bower-asset',
		'@npm'   => '@vendor/npm-asset',
	],
	'components' => [
		'cache'        => [
			'class' => FileCache::class,
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'mailer'       => [
			'class'            => Mailer::class,

			// send all mails to a file by default. You have to set
			// 'useFileTransport' to false and configure a transport
			// for the mailer to send real emails.
			'useFileTransport' => true,
		],
		'log'          => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets'    => [
				[
					'class'  => 'yii\log\FileTarget',
					'levels' => [ 'error', 'warning' ],
				],
			],
		],
	],
];

if ( YII_ENV_DEV ) {
// configuration adjustments for 'dev' environment
	$config['bootstrap'][]      = 'debug';
	$config['modules']['debug'] = [
		'class' => 'yii\debug\Module',
// uncomment the following to add your IP if you are not connecting from localhost.
//'allowedIPs' => ['127.0.0.1', '::1'],
	];

	$config['bootstrap'][]    = 'gii';
	$config['modules']['gii'] = [
		'class' => 'yii\gii\Module',
// uncomment the following to add your IP if you are not connecting from localhost.
//'allowedIPs' => ['127.0.0.1', '::1'],
	];
}

$config = [
	'id'         => 'wp-app',
	'basePath'   => dirname( __DIR__ ),
	'bootstrap'  => [],
	'aliases'    => [
		'@bower' => '@vendor/bower-asset',
		'@npm'   => '@vendor/npm-asset',
	],
	'components' => [
	],
];

return $config;
