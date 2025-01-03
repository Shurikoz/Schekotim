<?php

namespace frontend\controllers;

use backend\models\Article;
use backend\models\ArticleImage;
use backend\models\Gallery;
use backend\models\Price;
use backend\models\Registry;
use backend\models\Stock;
use frontend\components\NumericCaptcha;
use frontend\models\ContactForm;
use frontend\models\ReviewForm;
use Imagine\Image\Box;
use Yii;
use yii\base\InvalidArgumentException;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\imagine\Image;
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
//        $this->view->registerMetaTag([
//            'name' => 'description',
//            'content' => '«Щекотливая тема» - Центр маникюра, педикюра и подологии.'
//        ]);

        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
//    public function actionLogin()
//    {
//        if (!Yii::$app->user->isGuest) {
//            return $this->goHome();
//        }
//
//        $model = new LoginForm();
//        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->goBack();
//        } else {
//            $model->password = '';
//
//            return $this->render('login', [
//                'model' => $model,
//            ]);
//        }
//    }

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
    public function actionContacts()
    {
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => '«Щекотливая тема» - Контакты'
        ]);

        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['marketingEmail'])) {
                Yii::$app->session->setFlash('success', 'Спасибо, что написали нам. Мы ответим вам как можно скорее.');
            } else {
                Yii::$app->session->setFlash('error', 'При отправке вашего сообщения произошла ошибка.');
            }
            return $this->refresh();
        } else {
            return $this->render('contacts', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
//    public function actionSignup()
//    {
//        $model = new SignupForm();
//        if ($model->load(Yii::$app->request->post())) {
//            if ($user = $model->signup()) {
//                if (Yii::$app->getUser()->login($user)) {
//                    return $this->goHome();
//                }
//            }
//        }
//
//        return $this->render('signup', [
//            'model' => $model,
//        ]);
//    }

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
     * Displays podolog page.
     *
     * @return mixed
     */
    public function actionServices()
    {
        $model = Price::find()->one();
        return $this->render('services', [
            'model' => $model,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionCertificates()
    {
        return $this->render('certificates');
    }

    /**
     * @return mixed
     */
    public function actionRegistry()
    {
        $model = Registry::find()->all();
        return $this->render('registry', [
            'model' => $model,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionArticles()
    {
        $model = Article::find()->where(['status' => 1])->orderBy(['created_at' => SORT_DESC]);
        $pages = new Pagination(['totalCount' => $model->count(), 'pageSize' => 6, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $articles = $model->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('articles', [
            'articles' => $articles,
            'pages' => $pages,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function actionArticle($id)
    {
        $model = Article::find()->where(['id' => $id])->with('articleImage')->one();
        if ($model) {
            Article::findOne($id)->countViewArticle();
            return $this->render('article', [
                'model' => $model,
            ]);
        } else {
            return $this->goHome();
        }

    }

    public function actionFranchise()
    {
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => '«Щекотливая тема» - Франшиза'
        ]);
        return $this->render('franchise');
    }

    /**
     * Displays raboty page.
     *
     * @return mixed
     */
    public function actionWork()
    {
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => '«Щекотливая тема» - Наши работы'
        ]);

        $podolog = Gallery::find()->where(['category' => 0])->all();
        $manicure = Gallery::find()->where(['category' => 1])->all();
        $pedicure = Gallery::find()->where(['category' => 2])->all();

        return $this->render('work', [
            'podolog' => $podolog,
            'manicure' => $manicure,
            'pedicure' => $pedicure,
        ]);
    }

    /**
     * Displays review page.
     *
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function actionReview()
    {
        $this->view->registerJsFile('js/jquery-11.0.min.js');
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => '«Щекотливая тема» - Отзывы'
        ]);


        $newReview = new ReviewForm();
        $newReview->created_at = date("d-m-y");
        if ($newReview->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($newReview, 'image');
            if ($file) {
                $filename = time() . '_' . uniqid() . '.' . $file->extension;
                $path = Yii::getAlias('@frontend/web') . '/images/reviews/' . $filename;
                $newReview->image = $filename;
            }
            if ($newReview->validate() && $newReview->save(false)) {

                Yii::$app->session->setFlash('success', 'Спасибо за отзыв! После модерации он будет размещен на сайте!');

                if ($file && $file->saveAs($path)) {
                    Image::resize($path, 800, 1000)->save(Yii::getAlias('@frontend/web') . '/images/reviews/' . $filename, ['quality' => 80]);
                    $photo = Image::getImagine()->open(Yii::getAlias('@frontend/web') . '/images/reviews/' . $filename);
                    $photo->thumbnail(new Box(180, 180))->save(Yii::getAlias('@frontend/web') . '/images/reviews/thumbnail/' . $filename, ['quality' => 80]);
                } else {
                    $filename = '';
                }

                $reviewName = $newReview->name;
                $reviewEmail = $newReview->email;
                $reviewRating = $newReview->rating;
                $reviewBody = $newReview->text;
                $reviewMobile = $newReview->mobile;

                //создание ссылок на публикацию / изменение нового оставленного отзыва
                $linkPublic = 'http://lk.schekotim.ru/review/show?id=' . $newReview->id;
                $linkEdit = 'http://lk.schekotim.ru/review/update?id=' . $newReview->id;

                $newReview->sendNotificationReview(
                    Yii::$app->params['notificationReviewMail'],
                    Yii::$app->params['trofimovaNatEmail'],
                    $reviewName,
                    $reviewEmail,
                    $reviewRating,
                    $reviewBody,
                    $reviewMobile,
                    $linkPublic,
                    $linkEdit,
                    $filename
                );

                if ($reviewRating == 1 || $reviewRating == 2) {
                    $newReview->sendReviewClientPositiveNeutral($reviewName, $reviewEmail, $reviewRating, $reviewBody, $reviewMobile, $filename);
                } else {
                    $newReview->sendReviewClientNegative($reviewName, $reviewEmail, $reviewRating, $reviewBody, $reviewMobile, $filename);
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
        $pages->pageSizeParam = false;
        return $this->render('review', compact('newReview', 'reviews', 'pages', 'totalReviews'));
    }

    /**
     * Displays obuchenie page.
     *
     * @return mixed
     */
    public function actionTraining()
    {
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => '«Щекотливая тема» - Обучение'
        ]);

        return $this->render('training');
    }

    /**
     * Displays vacancy page.
     *
     * @return mixed
     */
    public function actionVacancy()
    {
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => '«Щекотливая тема» - Вакансии'
        ]);

        return $this->render('vacancy');
    }

    /**
     * Displays vakansii page.
     *
     * @return mixed
     */
    public function actionStock()
    {
        (new Stock())->checkPublicStock();
        $model = Stock::find()->where(['public' => 1])->all();
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => '«Щекотливая тема» - Акции и скидки'
        ]);
        return $this->render('stock' , [
                'model' => $model
            ]);
    }

}

