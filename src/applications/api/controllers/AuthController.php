<?php

declare(strict_types = 1);

namespace src\applications\api\controllers;

use http\Exception\InvalidArgumentException;
use src\models\LoginForm;
use src\models\User;
use yii\rest\Controller;
use yii\web\NotAcceptableHttpException;
use yii\web\UserEvent;

/**
 * Функционал авторизации.
 */
class AuthController extends Controller
{
    /**
     * {@inheritDoc}
     */
    public function behaviors(): array
    {
        return array_merge_recursive(parent::behaviors(), [
            'authenticator' => [
                'except' => ['login'],
            ],
        ]);
    }

    /**
     * Авторизация пользователя.
     *
     */
    public function actionLogin()
    {
        $form = new LoginForm();
        if ($form->hasErrors()) {
            throw new NotAcceptableHttpException();
        }

        $user = User::find()
            ->where(['status' => User::STATUS_ACTIVE, 'email' => $form->username])
            ->one();

        if ($user === null || false === $user->validatePassword($form->password)) {
            throw new NotAcceptableHttpException();
        }

        return [
            'token' => $user->generateAuthKey(),
        ];
    }

    /**
     * Завершение сеанса пользователя.
     *
     */
    public function actionLogout()
    {
        $webuser = \Yii::$app->getUser();
        // Сбрасываем токен пользователя только после штатного завершения сеанса.
        $webuser->on(\yii\web\User::EVENT_AFTER_LOGOUT, static function (UserEvent $event) {
            assert($event->identity instanceof User);
            assert($event->sender instanceof \yii\web\User);

            if (false === $event->identity->generateAuthKey()) {
                throw new InvalidArgumentException();
            }
        });

        if (false === $webuser->logout()) {
            throw new NotAcceptableHttpException($webuser);
        }

    }
}
