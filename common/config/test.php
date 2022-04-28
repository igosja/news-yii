<?php
declare(strict_types=1);

use common\models\User as DbUser;
use yii\web\User as WebUser;

return [
    'basePath' => dirname(__DIR__),
    'components' => [
        'user' => [
            'class' => WebUser::class,
            'identityClass' => DbUser::class,
        ],
    ],
    'id' => 'app-common-tests',
];
