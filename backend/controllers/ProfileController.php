<?php
/**
 * Created by PhpStorm.
 * User: 4pok
 * Date: 17.06.2020
 * Time: 10:44
 */

namespace backend\controllers;

use common\models\User;
use Yii;
use backend\models\ChangeUserPassword;
use yii\web\Controller;


class ProfileController extends Controller
{

     /**
     * @return string
     */
    public function actionSettings()
    {
        $user = User::find()->where(['id' => Yii::$app->user->identity->getId()])->with('city')->one();

        $model = new ChangeUserPassword();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->change()) {
            Yii::$app->session->setFlash('success', 'Пароль удачно изменен!');
            $model = new ChangeUserPassword();
        }

        return $this->render('settings', [
            'model' => $model,
            'user' => $user
        ]);
    }

}