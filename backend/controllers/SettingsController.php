<?php

namespace backend\controllers;

use yii\web\Controller;

class SettingsController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', [

        ]);
    }

    public function actionAddress()
    {
        return $this->render('address', [

        ]);
    }

}
