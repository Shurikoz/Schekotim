<?php

namespace frontend\controllers;

use common\models\LoginForm;
use frontend\components\NumericCaptcha;
use frontend\models\ContactForm;
use frontend\models\ReviewForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
//                'class' => 'yii\captcha\CaptchaAction',
                'class' => NumericCaptcha::className(),
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => '«Щекотливая тема» - Студия маникюра, педикюра и подологии. Более 3 лет я работаю в области 
            подологии. Кроме того, выполняю качественный и безопасный для здоровья моих клиентов маникюр и педикюр.
            Постоянно совершенствую свои знания и опыт: посещаю лекции, тренинги, семинары, практикумы ведущих
            специалистов в области подологии, дерматологии-микологии и nail-индустрии.
            Моя главная мотивация в работе – это улыбки и искренняя благодарность моих клиентов, которым я помогла
            избавиться от проблем стоп и ногтей.'
        ]);

        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
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
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => '«Щекотливая тема» - Контакты'
        ]);

        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Спасибо, что написали нам. Мы ответим вам как можно скорее.');
            } else {
                Yii::$app->session->setFlash('error', 'При отправке вашего сообщения произошла ошибка.');
            }
            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
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
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
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
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Displays Manicur page.
     *
     * @return mixed
     */
    public function actionManicur()
    {
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => '«Щекотливая тема» - Маникюр'
        ]);

        return $this->render('manicur');
    }

    /**
     * Displays Pedicur page.
     *
     * @return mixed
     */
    public function actionPedicur()
    {
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => '«Щекотливая тема» - Педикюр'
        ]);
        return $this->render('pedicur');
    }

    /**
     * Displays podolog page.
     *
     * @return mixed
     */
    public function actionPodolog()
    {
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => '«Щекотливая тема» - Подология'
        ]);

        return $this->render('podolog');
    }

    /**
     * Displays tehnolog page.
     *
     * @return mixed
     */
    public function actionTehnolog()
    {
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => '«Щекотливая тема» - Технологии и опыт'
        ]);

        return $this->render('tehnolog');
    }

    /**
     * Displays raboty page.
     *
     * @return mixed
     */
    public function actionRaboty()
    {
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => '«Щекотливая тема» - Наши работы'
        ]);
        return $this->render('raboty');
    }

    /**
     * Displays review page.
     *
     * @return mixed
     */
    public function actionReview()
    {

        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => '«Щекотливая тема» - Отзывы'
        ]);

        $newReview = new ReviewForm();

        $newReview->created_at = date("d-m-y");

        if ($newReview->load(Yii::$app->request->post())) {
            if ($newReview->validate() && $newReview->save(false)) {


                Yii::$app->session->setFlash('success', 'Спасибо за отзыв! После модерации он будет размещен на сайте!');

                $reviewName = $newReview->name;
                $reviewEmail = $newReview->email;
                $reviewRating = $newReview->rating;
                $reviewBody = $newReview->text;
                $reviewMobile = $newReview->mobile;

                //оздание ссылок на публикацию / изменение нового оставленного отзыва
                $linkPublic = 'http://admin.schekotim.ru/review/show?id=' . $newReview->id;
                $linkEdit = 'http://admin.schekotim.ru/review/update?id=' . $newReview->id;

                $newReview->sendNotificationReview(
                    Yii::$app->params['notificationReviewMail'],
                    $reviewName,
                    $reviewEmail,
                    $reviewRating,
                    $reviewBody,
                    $reviewMobile,
                    $linkPublic,
                    $linkEdit
                );

                if ($reviewRating == 1 || $reviewRating == 2) {
                    $newReview->sendReviewClientPositiveNeutral(
                        $reviewName,
                        $reviewEmail,
                        $reviewRating,
                        $reviewBody,
                        $reviewMobile
                    );
                } else {
                    $newReview->sendReviewClientNegative(
                        $reviewName,
                        $reviewEmail,
                        $reviewRating,
                        $reviewBody,
                        $reviewMobile
                    );
                }

                $newReview = new ReviewForm();

            } else {
                Yii::$app->session->setFlash('error', 'Ошибка отправки отзыва! :(');
            }
        }

        $query = ReviewForm::find();
        $totalReviews = $query->where(['active' => '1'])->count();
        $pages = new Pagination(['totalCount' => $totalReviews, 'pageSize' => 10]);
        $reviews = $query->orderBy(['id' => SORT_DESC])
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('review', compact('newReview', 'reviews', 'pages', 'totalReviews'));
    }

    /**
     * Displays obuchenie page.
     *
     * @return mixed
     */
    public function actionObuchenie()
    {
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => '«Щекотливая тема» - Обучение'
        ]);

        return $this->render('obuchenie');
    }

    /**
     * Displays vakansii page.
     *
     * @return mixed
     */
    public function actionVakansii()
    {
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => '«Щекотливая тема» - Вакансии'
        ]);

        return $this->render('vakansii');
    }

}

