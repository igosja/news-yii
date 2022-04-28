<?php
declare(strict_types=1);

use yii\gii\Module as GiiModule;
use yii\debug\Module as DebugModule;

$config = [
    'components' => [
        'request' => [
            'cookieValidationKey' => '',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'allowedIPs' => ['*'],
        'class' => DebugModule::class,
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => GiiModule::class,
    ];
}

return $config;
