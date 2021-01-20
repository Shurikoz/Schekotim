<?php

namespace backend\controllers;

use backend\models\AddressPoint;
use backend\models\Card;
use backend\models\CardSearch;
use backend\models\City;
use backend\models\Photo;
use backend\models\Specialist;
use backend\models\Visit;
use backend\models\VisitCardSearch;
use common\models\User;
use Yii;
use yii\data\Pagination;
use yii\filters\RateLimiter;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CardController implements the CRUD actions for Card model.
 */
class CardController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        parent::behaviors();
        return [

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'rateLimiter' => [
                'class' => RateLimiter::className(),
                'errorMessage' => 'Превышен интервал запросов к системе. Повторите запрос или <a href="">обновите</a> страницу через несколько секунд.'
            ],
        ];
    }

    /**
     * Lists all Card models.
     * @return mixed
     */
    public function actionIndex()
    {
        $cards = Card::find()->with('city', 'address_point')->all();
        $searchModel = new CardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $pages = new Pagination(['totalCount' => $dataProvider->getTotalCount(), 'pageSizeLimit' => [1, 60], 'defaultPageSize' => 20]);
        $city = ArrayHelper::map(City::find()->all(), 'id', 'name');
        $addressPoint = ArrayHelper::map(AddressPoint::find()->where(['city_id' => Yii::$app->request->get("CardSearch")["city_id"]])->all(), 'id', 'address_point');

        return $this->render('index', [
            'pages' => $pages,
            'cards' => $cards,
            'city' => $city,
            'addressPoint' => $addressPoint,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Card model.
     * @param $number
     * @return mixed
     */
    public function actionView($number)
    {
        $searchModel = new VisitCardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $number);
        $model = Card::find()->where(['number' => $number])->with('city', 'address_point')->one();
        $visits = Visit::find()->where(['card_number' => $number])->with(['photo', 'problem', 'city'])->all();
        $pages = new Pagination(['totalCount' => $dataProvider->getTotalCount(), 'pageSizeLimit' => [1, 60], 'defaultPageSize' => 20]);
        $specialistModel = Specialist::find()->where(['address_point_id' => Yii::$app->user->identity->address_point_id])->all();

        //пройдемся по посещениям, если пациент не пришел до указанного времени, сделаем отметку
        (new Visit())->checkVisit($visits);

        if ($model) {
            return $this->render('view', [
                'pages' => $pages,
                'model' => $model,
                'visits' => $visits,
                'specialistModel' => $specialistModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('error');
        }
    }

    /**
     * Creates a new Card model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //получим что пришло через POST
        $post = Yii::$app->request->post();

        $user = User::find()->where(['id' => Yii::$app->user->identity->getId()])->with('city', 'address_point')->one();

        $specialistModel = Specialist::find()->all();
        $specialistList = ArrayHelper::map($specialistModel, 'id', 'name');
        $cardModel = new Card();
        //найдем последнюю запись, возьмем из нее номер карты
        $card = Card::find()->orderBy(['id' => SORT_DESC])->one();

        //добавим этот номер карты в нашу модель, прибавив 1
        //сделаем проверку на случай, если карт еще нет
        if ($card != null) {
            $cardModel->number = (int)$card->number + 1;
        } else {
            $cardModel->number = 1;
        }
        $cardModel->created_at = time();
        if ($cardModel->load($post)) {
            if ($cardModel->save()) {
                Yii::$app->session->setFlash('success', 'Карта создана!');
                return $this->redirect(['view', 'number' => $cardModel->number]);
            }
        }
        return $this->render('create', [
            'user' => $user,
            'cardModel' => $cardModel,
            'specialistList' => $specialistList
        ]);
    }

    /**
     * Updates an existing Card model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($number)
    {
        $user = User::find()->where(['id' => Yii::$app->user->identity->getId()])->with('city', 'address_point')->one();
        $cardModel = Card::find()->where(['number' => $number])->one();
        if ($cardModel->load(Yii::$app->request->post()) && $cardModel->save()) {
            Yii::$app->session->setFlash('success', 'Изменения сохранены!');
        }
        return $this->render('update', [
            'cardModel' => $cardModel,
            'user' => $user,
        ]);
    }

    /**
     * Deletes an existing Card model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($number)
    {
        $cardModel = Card::find()->where(['number' => $number])->one();
        $visits = Visit::find()->where(['card_number' => $cardModel->number])->joinWith('photo')->all();
        foreach ($visits as $visit) {
            foreach ($visit->photo as $item) {
                $item->delete();
            }
            //удалим все фотографии посещения
            $dir = Yii::getAlias('@webroot/upload/photo/') . $visit->id;
            if (file_exists($dir)){
                chmod($dir, 0777);
                Photo::delPhoto($dir);
            }
            $visit->delete();
        }

        $cardModel->delete();
        Yii::$app->session->setFlash('success', 'Карта удалена!');
        return $this->redirect(['card/index']);
    }

    /**
     * @param $id
     * @return array|bool|\yii\db\ActiveRecord[]
     */
    public function actionGetSpecialist($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $addressPoint = AddressPoint::find()->where(['id' => $id])->one();
            $specialist = Specialist::find()->where(['address_point' => $addressPoint->address_point])->all();
            return $specialist;
        }
        return false;
    }

    /**
     * @param $s
     * @param $n
     * @param $mn
     * @return array|bool|\yii\db\ActiveRecord[]
     */
    public function actionCheckCard($n, $mn, $bd){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $card = Card::find()->where(['name' => $n, 'middle_name' => $mn, 'birthday' => $bd])->all();
                return $card;
        }
    }

    /**
     * Finds the Card model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Card the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Card::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Запрашиваемая страница не существует.');
    }

}
