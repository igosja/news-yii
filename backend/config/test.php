<?php
declare(strict_types=1);

return [
    'id' => 'app-backend-tests',
    'components' => [
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'request' => [
            'cookieValidationKey' => 'test',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];
