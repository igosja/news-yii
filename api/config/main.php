<?php
declare(strict_types=1);

use common\models\db\User;
use yii\log\DbTarget;
use yii\rest\UrlRule;
use yii\web\JsonParser;
use yii\web\JsonResponseFormatter;
use yii\web\Response;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
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
            'traceLevel' => YII_DEBUG ? 3 : 0,
        ],
        'request' => [
            'baseUrl' => '/api',
            'parsers' => [
                'application/json' => JsonParser::class,
            ]
        ],
        'response' => [
            'formatters' => [
                Response::FORMAT_JSON => [
                    'class' => JsonResponseFormatter::class,
                    'prettyPrint' => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'rules' => [
                [
                    'class' => UrlRule::class,
                    'controller' => 'category',
                    'only' => ['index'],
                ],
                [
                    'class' => UrlRule::class,
                    'controller' => 'comment',
                    'only' => ['index', 'create'],
                ],
                [
                    'class' => UrlRule::class,
                    'controller' => 'language',
                    'only' => ['index'],
                ],
                [
                    'class' => UrlRule::class,
                    'controller' => 'post',
                    'only' => ['index', 'view'],
                    'extraPatterns' => [
                        'GET,HEAD {url}' => 'view',
                    ],
                    'tokens' => [
                        '{url}' => '<url>',
                    ],
                ],
            ],
            'showScriptName' => false,
        ],
        'user' => [
            'enableAutoLogin' => false,
            'identityClass' => User::class,
        ],
    ],
    'controllerNamespace' => 'api\controllers',
    'id' => 'app-api',
    'params' => $params,
    'timeZone' => 'Europe/Kiev',
];
