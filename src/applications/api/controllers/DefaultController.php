<?php

declare(strict_types = 1);

namespace src\applications\api\controllers;

use yii\web\Controller;
use yii\web\Response;

/**
 * Заглавный контроллер API приложения.
 *
 * @SWG\Swagger(
 *     basePath="/",
 *     produces={"application/json"},
 *     consumes={"application/x-www-form-urlencoded"},
 * @SWG\Info(version="1.0", title="Simple API"),
 * )
 */
class DefaultController extends Controller
{

    /**
     * Публично доступная телеметрия проекта.
     */
    public function actionMain(): Response
    {
        return $this->asJson([
            'currentTime' => time(),
        ]);
    }
}
