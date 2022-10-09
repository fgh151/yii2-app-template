<?php

/**
 * Основной файл конфигурации проекта.
 *
 * @noinspection PhpIncludeInspection
 * @noinspection PhpFullyQualifiedNameUsageInspection
 */

declare(strict_types = 1);

$basePath = dirname(__DIR__);

$config = [
    'id' => 'project',
    'layout' => 'layouts/main',
    'basePath' => "{$basePath}/src",
    'runtimePath' => "{$basePath}/runtime",
    'params' => require "{$basePath}/config/params.php",
    'vendorPath' => dirname(__DIR__).'/vendor',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'charset' => 'utf8',
            'username' => getenv('DATABASE_USER'),
            'password' => getenv('DATABASE_PASS'),
            'enableSchemaCache' => true,
            'schemaCache' => 'cache',
            'schemaCacheDuration' => 3600,
            'dsn' => sprintf('pgsql:host=%s;dbname=%s;port=%d',
                getenv('DATABASE_HOST'),
                getenv('DATABASE_NAME'),
                getenv('DATABASE_PORT'),
            ),
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'user' => [
            'class' => \yii\web\User::class,
            'identityClass' => \src\models\User::class,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
        ],
        'mailer' => [
            'class' => \yii\swiftmailer\Mailer::class,
            'viewPath' => "{$basePath}/src/emails/views",
            'htmlLayout' => '../layout.php',
            'enableSwiftMailerLogging' => true,
            'transport' => [
                'class' => Swift_SmtpTransport::class,
                'encryption' => getenv('SMTP_ENCRYPTION'),
                'host' => getenv('SMTP_HOST'),
                'port' => getenv('SMTP_PORT'),
                'username' => getenv('SMTP_USER'),
                'password' => getenv('SMTP_PASS'),
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => [getenv('NOREPLY_EMAIL') => getenv('NOREPLY_EMAIL_NAME')],
            ],
        ],
        'log' => [
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning', 'info'],
                    'logVars' => [],
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'sourceLanguage' => 'unexpected',
                    'basePath' => "{$basePath}/src/messages",
                ],
            ],
        ],
    ],
];

// Конфигурация консольного приложения окончена.
if (YII_CONSOLE_APPLICATION) {
    unset(
        $config['components']['urlManager'],
        $config['components']['errorHandler'],
    );

    return \yii\helpers\ArrayHelper::merge($config, [
        'controllerNamespace' => 'src\\commands',
        'aliases' => [
            '@src' => dirname(__FILE__, 2).'/src',
        ],
        'components' => [
            'user' => [
                'enableSession' => false,
            ],
        ],
    ]);
}

// Определяем текущее, в рамках текущего запроса, приложение.
[$currentApplicationCode, $currentApplicationHost]
    = explode('.', $_SERVER['HTTP_HOST'], 2);

// По-молчанию, используется приложение frontend.
if (false === in_array($currentApplicationCode, ['api', 'admin'], true)) {
    $currentApplicationCode = 'frontend';
    $currentApplicationHost = $_SERVER['HTTP_HOST'];
}

// Запоминаем базовый домен приложения для дальнейшего использования.
defined('CFG_APPLICATION_HOST') || define('CFG_APPLICATION_HOST', $currentApplicationHost);

return \yii\helpers\ArrayHelper::merge($config,
    require "{$basePath}/src/applications/{$currentApplicationCode}/config/config.php"
);
