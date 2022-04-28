<?php
declare(strict_types=1);

return [
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
    'id' => 'app-frontend-tests',
];
