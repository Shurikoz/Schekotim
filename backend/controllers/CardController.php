<?php

namespace backend\controllers;

use backend\models\AddressPoint;
use backend\models\Card;
use backend\models\CardSearch;
use backend\models\Photo;
use backend\models\Podolog;
use backend\models\Visit;
use Yii;
use yii\data\Pagination;
use yii\filters\VerbFilter;
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

        return $this->render('index', [
            'pages' => $pages,
            'cards' => $cards,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Card model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $visits = Visit::find()->where(['card_number' => $this->findModel($id)->number])->with(['photo', 'addressPoint', 'city', 'problem'])->all();
        $location = AddressPoint::find()->where(['id' => $model->address_point_id])->with('city')->one();

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
            'location' => $location,
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

        //получим id точки из аккаунта текущего пользователя
        $addressPoint = Yii::$app->user->identity->address_point_id;

        $cardModel = new Card();
        $visitModel = new Visit();
        $podologModel = Podolog::find()->where(['address_point_id' => $addressPoint])->all();
        $location = AddressPoint::find()->where(['id' => $addressPoint])->with('city')->one();

        //найдем последнюю запись, возьмем из нее номер карты
        $card = Card::find()->orderBy(['id' => SORT_DESC])->one();

        //добавим этот номер карты в нашу модель, прибавив 1
        $cardModel->number = (int)$card->number + 1;
        $cardModel->created_at = date('d-m-Y H:m');

        // 0 - ожидает посещения, 1 - пришел, 2 - не пришел
        $visitModel->has_come = '1';
        $visitModel->timestamp = time() + 60 * 60 * 24 * 2; // 2 суток на редактирование
        $visitModel->next_visit_from = date('Y-m-d');
        $visitModel->visit_time = date('H:i:s');
        $visitModel->card_number = $cardModel->number;
        $visitModel->city_id = $location->city->id;
        $visitModel->address_point_id = $addressPoint;
        $visitModel->podolog_id = $post->podolog;
        $visitModel->visit_time = date('H:m:i');
        $visitModel->visit_date = date('Y-m-d');

        if ($cardModel->load($post) && $cardModel->save() &&
            $visitModel->load($post) && $visitModel->save()) {
            Yii::$app->session->setFlash('success', 'Карта создана!');
            return $this->redirect(['view', 'id' => $cardModel->id]);
        }

        return $this->render('create', [
            'cardModel' => $cardModel,
            'visitModel' => $visitModel,
            'podologModel' => $podologModel,
            'location' => $location
        ]);
    }

    /**
     * Updates an existing Card model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $cardModel = $this->findModel($id);
//return '<pre>' . print_r($cardModel) . '</pre>';
        if ($cardModel->load(Yii::$app->request->post()) && $cardModel->save()) {
            Yii::$app->session->setFlash('success', 'Изменения сохранены!');
            return $this->redirect(['view', 'id' => $cardModel->id]);
        }

        return $this->render('update', [
            'cardModel' => $cardModel,
            'visitModel' => $visitModel,
            'podologModel' => $podologModel,
            'location' => $location
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
    public function actionDelete($id)
    {
//        $card_number = Card::find()->where(['number' => $this->findModel($id)->number])->one();
        $visits = Visit::find()->where(['card_number' => $this->findModel($id)->number])->joinWith('photo')->all();

        foreach ($visits as $visit) {
            foreach ($visit->photo as $item) {
                $item->delete();
            }
        }

        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Карта удалена!');
        return $this->redirect(['index']);
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
