<?php
/**
 * Created by PhpStorm.
 * User: 4pok
 * Date: 16.02.2020
 * Time: 21:02
 */

namespace backend\controllers;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class CardController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }



    public function actionIndex()
    {
        if (!Yii::$app->user->can('admin')){
            new ForbiddenHttpException("доступ запрещен");
        }

        return $this->render('index');
    }
}