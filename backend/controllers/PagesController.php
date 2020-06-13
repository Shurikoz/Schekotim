<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Price;

class PagesController extends Controller
{

    /**
     * @return string
     */
    public function actionPrice()
    {
        $post = Yii::$app->request->post();
        $model = Price::find()->one();
        if ($model->load($post)){
            if ($model->save()){
                Yii::$app->session->setFlash('success', 'Прайс-лист сохранён!');
            } else {
                Yii::$app->session->setFlash('danger', 'Данные не сохранены!');
            }
        }
        return $this->render('price', [
            'model' => $model,
        ]);
    }
}