<?php
$applicationPath = dirname(__DIR__);
return [
    'basePath' => $applicationPath,
    'layoutPath' => "{$applicationPath}/views",
    'id' => 'app-frontend',
    'bootstrap' => ['log'],
    'controllerNamespace' => "src\\applications\\frontend\\controllers",
    'components' => [
        'urlManager' => [
            'rules' => require __DIR__.'/routes.php',
        ],
        'user' => [
            'enableAutoLogin' => true,
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'enableCookieValidation' => true,
            'enableCsrfValidation' => false,
            'cookieValidationKey' => getenv('APPLICATION_SECRET'),
        ],
        'assetManager' => [
            'bundles' => [
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => false,
                ],
            ],
        ],
    ],
];
