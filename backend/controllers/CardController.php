<?php

namespace backend\controllers;

use backend\models\AddressPoint;
use backend\models\Card;
use backend\models\CardSearch;
use backend\models\City;
use backend\models\Podolog;
use backend\models\Visit;
use Yii;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;

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
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Card models.
     * @return mixed
     */
    public function actionIndex()
    {
        $cards = Card::find();
        $searchModel = new CardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $pages = new Pagination(['totalCount' => $dataProvider->getTotalCount(), 'pageSizeLimit' => [1, 60], 'defaultPageSize' => 20]);
        $city = ArrayHelper::map(City::find()->all(), 'id', 'name');
        $addressPoint = ArrayHelper::map(AddressPoint::find()->where(['city_id' => Yii::$app->request->get("CardSearch")["city"]])->all(), 'address_point', 'address_point');
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
        $model = Card::find()->where(['number' => $number])->one();

        $visits = Visit::find()->where(['card_number' => $number])->with(['photo', 'problem'])->all();

        $addressPoint = Yii::$app->user->identity->address_point;
        $podologModel = Podolog::find()->where(['address_point' => $addressPoint])->all();

        //пройдемся по посещениям, если пациент не пришел до указанного времени, сделаем отметку
        foreach ($visits as $visit) {
            if ($visit->next_visit_from != null && $visit->next_visit_by != null){
                if (strtotime($visit->next_visit_by) < time()) {
                    $visit->has_come = 2;
                    $visit->visit_date = null;
                    $visit->visit_time = null;
                    $visit->save();
                }
            }
        }
        return $this->render('view', [
            'model' => $model,
            'visits' => $visits,
            'podologModel' => $podologModel
        ]);
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

        $addressPoint = Yii::$app->user->identity->address_point;
        $city = Yii::$app->user->identity->city;

        if (Yii::$app->user->can('admin')){
            $podologModel = Podolog::find()->all();
        } else {
            $podologModel = Podolog::find()->where(['address_point' => $addressPoint])->all();
        }
        $cityModel = City::find()->all();

        $cardModel = new Card();

        //найдем последнюю запись, возьмем из нее номер карты
        $card = Card::find()->orderBy(['id' => SORT_DESC])->one();

        //добавим этот номер карты в нашу модель, прибавив 1
        //сделаем проверку на случай, если карт еще нет
        if ($card != null){
            $cardModel->number = (int)$card->number + 1;
        } else {
            $cardModel->number = 1;
        }

        $cardModel->created_at = date('Y-m-d');
        $visitModel = new Visit();

        if (!Yii::$app->user->can('admin')){
            // 0 - ожидает посещения, 1 - пришел, 2 - не пришел
            $visitModel->has_come = '1';
            $visitModel->timestamp = time() + 60 * 60 * 24 * 2; // 2 суток на редактирование
            $visitModel->next_visit_from = date('Y-m-d');
            $visitModel->visit_time = date("H:i");
            $visitModel->card_number = $cardModel->number;
            $visitModel->city = $city;
            $visitModel->address_point = $addressPoint;
            $visitModel->visit_time = date('H:i');
            $visitModel->visit_date = date('Y-m-d');

            if ($cardModel->load($post) && $cardModel->save() &&
                $visitModel->load($post) && $visitModel->save()) {
                Yii::$app->session->setFlash('success', 'Карта создана!');
                return $this->redirect(['view', 'number' => $cardModel->number]);
            }
        } else {
            if ($cardModel->load($post)) {
                $c = City::find()->where(['id' => $post["Card"]["city"]])->one();
                $ap = AddressPoint::find()->where(['id' => $post["Card"]["address_point"]])->one();
                $cardModel->city = $c->name;
                $cardModel->address_point = $ap->address_point;

                if ($cardModel->save()) {
                    Yii::$app->session->setFlash('success', 'Карта создана!');
                    return $this->redirect(['view', 'number' => $cardModel->number]);
                }
            }

        }
        return $this->render('create', [
            'cardModel' => $cardModel,
            'visitModel' => $visitModel,
            'podologModel' => $podologModel,
            'cityModel' => $cityModel
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
        $cardModel = Card::find()->where(['number' => $number])->one();
        if ($cardModel->load(Yii::$app->request->post()) && $cardModel->save()) {
            Yii::$app->session->setFlash('success', 'Изменения сохранены!');
        }
        return $this->render('update', [
            'cardModel' => $cardModel
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
                $this->delPhoto($dir);
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
    public function actionGetPodolog($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $addressPoint = AddressPoint::find()->where(['id' => $id])->one();
            $podolog = Podolog::find()->where(['address_point' => $addressPoint->address_point])->all();
            return $podolog;
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

    /**
     * функция для удаления фотографий посещения
     * @param $dir
     */
    protected function delPhoto($dir)
    {
        $folders = ['/temp', '/before', '/after', '/thumbBefore', '/thumbAfter'];
        foreach ($folders as $folder) {
            if (file_exists($dir . $folder . '/')) {
                foreach (glob($dir . $folder . '/*') as $file) {
                    unlink($file);
                }
            }
            rmdir($dir . $folder);
        }
        rmdir($dir);
    }

}
