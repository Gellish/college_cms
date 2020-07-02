<?php


$config = [
    'id' => 'EduSec',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'installation/index',
    'components' => [
		'request' => [
			'cookieValidationKey' => 'JDqkJaMgIITAKcsJY6yvLQdM9jf7WghX',
		],
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'user' => [
			'identityClass' => 'app\models\User',
			'enableAutoLogin' => false,
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
    ],
];


return $config;
