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

$wp_upload_dir = wp_upload_dir();

/** @var WP_Theme $wp_theme */
$wp_theme      = wp_get_theme();
//dump( $wp_theme );
//die();

$config = [
	'id'         => 'wp-app',
	'basePath'   => dirname( __DIR__ ),
	'bootstrap'  => [],
	'aliases'    => [
		'@bower' => '@vendor/bower-asset',
		'@npm'   => '@vendor/npm-asset',
	],
	'controllerMap' => [
		// declares "account" controller using a class name
		'site' => [
			'class'                => \Enpii\Wp\EnpiiBase\Controllers\SiteController::class,
			'enableCsrfValidation' => false,
		],
	],
	'components' => [
		// We need to define request component for making Form working
		'request' => [
			'enableCookieValidation' => true,
			'enableCsrfValidation' => true,
			'cookieValidationKey' => AUTH_KEY,
		],
		'assetManager' => [
			'basePath' => $wp_upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'assets',
			'baseUrl'  => $wp_upload_dir['baseurl'] . '/assets',
			'bundles'  => [
				// you can override AssetBundle configs here
			],
		],
		'db' => [
			'__class' => yii\db\Connection::class,
			'dsn' => 'mysql:host='.DB_HOST.';dbname='.DB_NAME,
			'username' => DB_USER,
			'password' => DB_PASSWORD,
			'charset' => DB_CHARSET,
			'tablePrefix' => DB_TABLE_PREFIX,

			// Schema cache options (for production environment)
			//'enableSchemaCache' => true,
			//'schemaCacheDuration' => 60,
			//'schemaCache' => 'cache',
		],
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'enableStrictParsing' => true,
			'baseUrl' => 'wp-app',
//			'normalizer' => [
//				'class' => 'yii\web\UrlNormalizer',
//				// use temporary redirection instead of permanent for debugging
//				'action' => \yii\web\UrlNormalizer::ACTION_REDIRECT_TEMPORARY,
//			],
			'rules' => [
				[
					'pattern' => 'wp-app',
					'route' => 'site/index',
				],
				[
					'pattern' => 'wp-app',
					'route' => 'site/index',
					'suffix' => '/',
				],

			],
		],
//		'view'         => [
//			'theme' => $wp_theme->get_stylesheet(),
//		]
	],
];

return $config;
