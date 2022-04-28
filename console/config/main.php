<?php
declare(strict_types=1);

use yii\console\controllers\FixtureController;
use yii\log\DbTarget;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => DbTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => FixtureController::class,
            'namespace' => 'common\fixtures',
          ],
    ],
    'controllerNamespace' => 'console\controllers',
    'id' => 'app-console',
    'params' => $params,
];
