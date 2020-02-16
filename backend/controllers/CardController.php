<?php
/**
 * Created by PhpStorm.
 * User: 4pok
 * Date: 16.02.2020
 * Time: 21:02
 */

namespace backend\controllers;
use yii\web\Controller;

class CardController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}