<?php
namespace backend\controllers;

use yii\web\Controller;


/**
 * Site controller
 */
class TaskController extends Controller
{

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}
