<?php
/**
 * Created by PhpStorm.
 * User: 4pok
 * Date: 17.06.2020
 * Time: 10:48
 */

namespace backend\controllers;

use backend\models\AddressPoint;
use backend\models\Podolog;
use backend\models\UserEdit;
use common\models\User;
use backend\models\City;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use backend\models\SignupUser;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{

    /**
     * @return string
     */
    public function actionIndex()
    {
        //получим всех пользователей кроме администратора
        $model = User::find()->where(['not in', 'username', 'admin'])->with('city', 'address_point')->all();

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
     * @throws \Exception
     */
    public function actionEdit($id)
    {
        $post = Yii::$app->request->post();
        $allRoles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
        $podolog = new Podolog();

        //исключим из списка административную роль
        unset($allRoles['admin']);

        $user = UserEdit::findOne(['id' => $id]);
        $role = array_keys(Yii::$app->authManager->getRolesByUser($user->id));
        $userRole = Yii::$app->authManager->getRole($role)->name;
        $cityList = ArrayHelper::map(City::find()->all(), 'id', 'name');
        $addressPointList  = ArrayHelper::map(AddressPoint::find()->all(), 'id', 'address_point');

        if ($user->load($post)) {
            $auth = Yii::$app->authManager;
            if (Yii::$app->getRequest()->post()["role"]){
                $role = $auth->getRole(Yii::$app->getRequest()->post()["role"]);
                $auth->revokeAll($id);
                $auth->assign($role, $id);
            } else {
                $auth->revokeAll($id);
            }
            $user->updated_at = time();
                if ($user->save()){

                    //если выбрали роль подолога, то создадим запись в таблице списка подологов
                    $delPodolog = Podolog::find()->where(['user_id' => $user->getId()])->one();
                    if (Yii::$app->getRequest()->post()["role"] == 'podolog' && !$delPodolog){
                        $podolog->user_id = $user->getId();
                        $podolog->address_point_id = $user->address_point_id;
                        $podolog->name = $user->name;
                        $podolog->save();
                    } else {
                        if ($delPodolog){
                            $delPodolog->delete();
                        }
                    }

                    Yii::$app->session->setFlash('success', 'Изменения пользователя <b>' . $user->username . '</b> сохранены!');
                    $model = User::find()->where(['not in', 'username', 'admin'])->with('city', 'address_point')->all();
                    return $this->render('index', [
                        'model' => $model,
                    ]);
                }

        }

        return $this->render('edit', [
            'user' => $user,
            'city' => $cityList,
            'addressPoint' => $addressPointList,
            'allRoles' => $allRoles,
            'userRole' => $userRole,
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
        if ($user->save()) {
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
        if ($user->save()) {
            Yii::$app->session->setFlash('success', 'Пользователь <b>' . $user->username . '</b> разблокирован!');
        } else {
            Yii::$app->session->setFlash('danger', 'Произошла ошибка!');
        }
        return $this->redirect(['user/index', 'model' => $model]);

    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionSignup()
    {
        $roles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
        //исключим из списка административную роль
        unset($roles['admin']);
        $model = new SignupUser();
        $city = City::find()->all();
        $cityList = ArrayHelper::map($city, 'id', 'name');
        $podolog = new Podolog();
        if ($model->load(Yii::$app->getRequest()->post())) {

            if ($user = $model->signup()) {
                if (Yii::$app->getRequest()->post()["role"]){
                    if (Yii::$app->getRequest()->post()["role"] == 'podolog'){
                        $podolog->user_id = $user->getId();
                        $podolog->address_point_id = $model->address_point;
                        $podolog->name = $model->name;
                        $podolog->save();
                    }
                    $auth = Yii::$app->authManager;
                    $authorRole = $auth->getRole(Yii::$app->getRequest()->post()["role"]);
                    $auth->assign($authorRole, $user->getId());
                    Yii::$app->session->setFlash('success', 'Пользователь <b>' . $user->username . '</b> создан!');
                } else {
                    Yii::$app->session->setFlash('success', 'Пользователь <b>' . $user->username . '</b> создан! Назначьте ему права доступа!');
                }

            }
        }

        return $this->render('signup', [
            'model' => $model,
            'city' => $cityList,
            'roles' => $roles,
            'podolog' => $podolog,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()){
            $role = array_keys(Yii::$app->authManager->getRolesByUser($id));
            $userRole = Yii::$app->authManager->getRole($role)->name;
            $podolog = Podolog::find()->where(['user_id' => $id])->one();
            if ($userRole == 'podolog' && $podolog){
                $podolog->delete();
            }
            Yii::$app->authManager->revokeAll($id);
            Yii::$app->session->setFlash('success', 'Пользователь #' . $model->username . ' удален!');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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