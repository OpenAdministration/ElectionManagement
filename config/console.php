<?php

use yii\gii\Module;

if(file_exists(__DIR__ . '/names.php') && file_exists(__DIR__ . '/secrets.php')){
    [$id, $name, $params] = require __DIR__ . '/names.php';
    $secrets = require  __DIR__ . '/secrets.php';
}else{
    [$id, $name, $params] = require __DIR__ . '/names.sample.php';
    $secrets = require  __DIR__ . '/secrets.sample.php';
}


$config = [
    'id' => $id . '-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $secrets['db'] ?? [],
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => Module::class,
    ];
}

return $config;
