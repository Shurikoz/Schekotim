<?php
namespace backend\controllers;

use backend\models\Support;
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

    /**
     * @return string
     */
    public function actionSupport()
    {
        $model = Support::find()->joinWith('user')->all();
        return $this->render('support', [
            'model' => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionTutorial()
    {
        return $this->render('tutorial');
    }

}