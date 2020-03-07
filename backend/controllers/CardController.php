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
        $pages = new Pagination(['totalCount' => $cards->count(), 'pageSizeLimit' => [1, 60], 'defaultPageSize' => 20]);
        $model = $cards->offset($pages->offset)->limit($pages->limit)->orderBy(['id' => SORT_DESC])->with('visit')->all();

        return $this->render('index', [
            'model' => $model,
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
        $visits = Visit::find()->where(['card_number' => $this->findModel($id)->number])->with(['photo', 'addressPoint', 'city'])->all();
        $location = AddressPoint::find()->where(['id' => $model->address_point])->with('city')->one();

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
        $addressPoint = Yii::$app->user->identity->address_point;

        $cardModel = new Card();
        $visitModel = new Visit();
        $podologModel = Podolog::find()->where(['address_point' => $addressPoint])->all();
        $location = AddressPoint::find()->where(['id' => $addressPoint])->with('city')->one();

        //найдем последнюю запись, возьмем из нее номер карты
        $card = Card::find()->orderBy(['id' => SORT_DESC])->one();

        //добавим этот номер карты в нашу модель, прибавив 1
        $cardModel->number = (int)$card->number + 1;
        $cardModel->created_at = date('d-m-Y H:m');

        $visitModel->has_come = '0';
        $visitModel->has_come = '0';
        $visitModel->card_number = $cardModel->number;
        $visitModel->address_point = Yii::$app->user->identity->address_point;

        if ($cardModel->load(Yii::$app->request->post()) && $cardModel->save() &&
            $visitModel->load(Yii::$app->request->post()) && $visitModel->save()) {
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
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
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
        $visits = Visit::find()->where(['card_number' => $this->findModel($id)->number])->all();
        foreach ($visits as $visit) {
            $visit->delete();
        }
        $this->findModel($id)->delete();
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
