<?php

declare(strict_types = 1);

use yii\web\Application;

define('YII_CONSOLE_APPLICATION', false);

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../config/bootstrap.php';
require __DIR__.'/../vendor/yiisoft/yii2/Yii.php';

/* @noinspection PhpUnhandledExceptionInspection */
(new Application(require __DIR__.'/../config/config.php'))
    ->run();