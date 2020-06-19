<?php
/**
 * Created by PhpStorm.
 * User: 4pok
 * Date: 17.06.2020
 * Time: 10:48
 */

namespace backend\controllers;
use common\models\User;
use yii\web\Controller;
use Yii;

class UserController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        //получим всех пользователей кроме администратора
        $model = $this->getUsers();

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionView($id)
    {
        $model = User::findOne(['id' => $id]);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionEdit($id)
    {
        $model = User::findOne(['id' => $id]);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionBlock($id)
    {
        //получим всех пользователей кроме администратора
        $model = $this->getUsers();

        $user = User::findOne(['id' => $id]);
        $user->status = User::STATUS_DELETED;
        if ($user->save()){
            Yii::$app->session->setFlash('warning', 'Пользователь <b>' . $user->username . '</b> заблокирован!');
        } else {
            Yii::$app->session->setFlash('danger', 'Произошла ошибка!');
        }

        return $this->redirect(['user/index', 'model' => $model]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionUnblock($id)
    {
        //получим всех пользователей кроме администратора
        $model = $this->getUsers();

        $user = User::findOne(['id' => $id]);
        $user->status = User::STATUS_ACTIVE;
        if ($user->save()){
            Yii::$app->session->setFlash('success', 'Пользователь <b>' . $user->username . '</b> разблокирован!');
        } else {
            Yii::$app->session->setFlash('danger', 'Произошла ошибка!');
        }
        return $this->redirect(['user/index', 'model' => $model]);

    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    private function getUsers()
    {
        $model = User::find()->where(['not in', 'username', 'admin'])->all();
        return $model;
    }

}