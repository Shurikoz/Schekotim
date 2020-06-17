<?php
namespace backend\controllers;

use backend\models\AddressPoint;
use backend\models\City;
use backend\models\PasswordResetRequestForm;
use backend\models\ResetPasswordForm;
use backend\models\SignupUser;
use backend\models\Support;
use common\models\LoginForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\UploadedFile;


/**
 * Site controller
 */
class SiteController extends Controller
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays review page.
     *
     * @return mixed
     */
    public function actionReview()
    {
        return $this->render('review');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return string
     */
    public function actionSupport()
    {
        $post = Yii::$app->request->post();
        $model = new Support();

        if ($model->load($post)) {
            $model->user_id = Yii::$app->user->identity->getId();
            $model->date = date('d.m.Y');
            $model->time = date('H:i');
            if ($model->save()) {
                $model->file = UploadedFile::getInstance($model, 'file');
                if ($model->file) {
                    $model->upload($model);
                }
                Yii::$app->session->setFlash('success', 'Обращение зарегистрировано!');
                $model = new Support();
            } else {
                Yii::$app->session->setFlash('danger', 'Ошибка отправки формы!');
            }
        }
        return $this->render('support', [
            'model' => $model,
        ]);
    }

    public function actionPolicy()
    {
        return $this->render('policy');
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте свою электронную почту для дальнейших инструкций!');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'К сожалению, мы не можем сбросить пароль для указанного адреса электронной почты!');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Новый пароль сохранен!');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Signup new user
     * @return string
     */
    public function actionSignup()
    {
        $model = new SignupUser();
        $city = City::find()->all();
        if ($model->load(Yii::$app->getRequest()->post())) {
            if ($user = $model->signup()) {
                Yii::$app->session->setFlash('success', 'Пользователь <b>' . $user->username . '</b> создан! Назначьте ему права доступа.');
            }
        }

        return $this->render('signup', [
            'model' => $model,
            'city' => $city,
        ]);
    }

    public function actionGetAddressPoint($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $addressPoint = AddressPoint::find()->where(['city_id' => $id])->all();
            return $addressPoint;
        }
        return false;
    }
}
