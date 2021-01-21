<?php

$applicationPath = dirname(__DIR__);
return [
    'basePath' => $applicationPath,
    'id' => 'app-admin',
    'bootstrap' => ['log'],
    'controllerNamespace' => "src\\applications\\api\\controllers",
    'components' => [
        'urlManager' => [
            'rules' => require __DIR__.'/routes.php',
        ],
        'user' => [
            'enableAutoLogin' => true,
        ],
        'response' => [
            'format' => \yii\web\Response::FORMAT_JSON,
        ],
        'request' => [
            // Отключаем проверку cookies на предмет их подделки, так как данное приложение не должно их использовать.
            'enableCookieValidation' => false,
            // Отключаем проверки CSRF (Cross-Site Request Forgery), так как работаем в stateless режиме.
            'enableCsrfCookie' => false,
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class,
            ],
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
    ],
];
