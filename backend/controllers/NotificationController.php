<?php
namespace backend\controllers;

use yii\web\Controller;


/**
 * Site controller
 */
class NotificationController extends Controller
{

    /**
     * @return string
     */
    public function actionNotification()
    {
        $result = '123';
        return $this->render('index', [
            'result' => $result,
        ]);
    }
    /**
     * @return string
     */
    public function actionNotif()
    {
        $result = rand(1, 99);
        return $this->render('index', [
            'result' => $result,
        ]);
    }

}
