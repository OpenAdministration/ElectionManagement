<?php

use yii\i18n\PhpMessageSource;
use yii\web\ErrorAction;
use yii\debug\Module;
use yii\log\FileTarget;
use yii\swiftmailer\Mailer;
use yii\caching\FileCache;

if(file_exists(__DIR__ . '/names.php') && file_exists(__DIR__ . '/secrets.php')){
    [$id, $name, $params, $defaultLang] = require __DIR__ . '/names.php';
    $secrets = require  __DIR__ . '/secrets.php';
}else{
    [$id, $name, $params, $defaultLang] = require __DIR__ . '/names.sample.php';
    $secrets = require  __DIR__ . '/secrets.sample.php';
    define('START_INSTALLER', true);
}

$config = [
    'id' => $id,
    'name' => $name,
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => $defaultLang,
    'aliases' => [
        '@bower' => '@vendor/bower',
        '@npm'   => '@vendor/npm',
    ],

    'components' => [
        'request' => [
            'cookieValidationKey' => $secrets['cookieValidationKey'] ?? '',
        ],
        'cache' => [
            'class' => FileCache::class,
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'mailer' => [
            'class' => Mailer::class,
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $secrets['db'] ?? [],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                //enter routing rules here
            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@app/locale',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app/error' => 'error.php', // ?
                    ],
                ],
            ],
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => Module::class,
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => \yii\gii\Module::class,
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
