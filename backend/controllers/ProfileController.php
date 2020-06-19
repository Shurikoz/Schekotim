<?php
/**
 * Created by PhpStorm.
 * User: 4pok
 * Date: 17.06.2020
 * Time: 10:44
 */

namespace backend\controllers;
use yii\web\Controller;


class ProfileController extends Controller
{

    /**
     * @return string
     */
    public function actionNotification()
    {
        return $this->render('notifications');
    }


    /**
     * @return string
     */
    public function actionSettings()
    {
        return $this->render('settings');
    }
}