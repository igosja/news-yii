<?php
declare(strict_types=1);

use common\models\db\User;
use yii\grid\GridView;
use yii\log\DbTarget;
use yii\redis\Session;
use yii\widgets\LinkPager;

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
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
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
            'baseUrl' => '',
            'csrfParam' => '_csrf-frontend',
        ],
        'session' => [
            'class' => Session::class,
            'name' => 'ezubukhqon',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'rules' => [
                '' => 'site/index',
                'captcha' => 'site/captcha',
                'contact' => 'site/contact',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'post/category/<category_id>' => 'post/index',
                'post/rating/<url>/<value>' => 'post/rating',
                'post/<url>' => 'post/view',
                'request-password-reset' => 'site/request-password-reset',
                'resend-verification-email' => 'site/resend-verification-email',
                'reset-password' => 'site/reset-password',
                'signup' => 'site/signup',
                'verify-email' => 'site/verify-email',
                '<controller:\w+>' => '<controller>/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
            ],
            'showScriptName' => false,
        ],
        'user' => [
            'enableAutoLogin' => true,
            'identityClass' => User::class,
            'identityCookie' => ['name' => 'brynouxwgj', 'httpOnly' => true],
        ],
    ],
    'container' => [
        'definitions' => [
            GridView::class => [
                'options' => ['class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive'],
                'tableOptions' => ['class' => 'table table-bordered table-hover'],
                'pager' => [
                    'class' => LinkPager::class,
                ],
            ],
        ],
    ],
    'controllerNamespace' => 'frontend\controllers',
    'id' => 'app-frontend',
    'name' => Yii::t('app', 'News'),
    'params' => $params,
    'timeZone' => 'Europe/Kiev',
];
