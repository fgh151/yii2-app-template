<?php

namespace src\commands;

use yii\console\Controller;

class HelloController extends Controller
{

    public function actionIndex()
    {
        echo 'hello world!';
        \Yii::$app->end();
    }

}