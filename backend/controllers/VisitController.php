<?php

namespace backend\controllers;

use backend\models\AddressPoint;
use backend\models\Card;
use backend\models\Podolog;
use backend\models\Problem;
use backend\models\Visit;
use backend\models\VisitSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * VisitController implements the CRUD actions for Visit model.
 */
class VisitController extends Controller
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
     * Lists all Visit models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VisitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Visit model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Visit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $post = Yii::$app->request->post();
        $model = new Visit();

        //получим id точки из аккаунта текущего пользователя
        $addressPoint = Yii::$app->user->identity->address_point_id;

        $location = AddressPoint::find()->where(['id' => $addressPoint])->with('city')->one();
        $podolog = Podolog::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
//        $card = Card::find()->where(['number' => $model->card_number])->one();
        $problem = Problem::find()->all();
        $model->edit = 1;
        $model->timestamp = time();
        if ($model->load($post) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Данные сохранены!');
            return $this->redirect(['card/view', 'id' => Yii::$app->request->get('id')]);
        }
        return $this->render('create', [
            'model' => $model,
            'location' => $location,
            'podolog' => $podolog,
            'problem' => $problem,
        ]);
    }

    /**
     *
     * @param integer $id
     * @return mixed
     * action смены статуса визита пациента что он пришел
     * @throws NotFoundHttpException
     */
    public function actionCome($id, $card)
    {
        $model = $this->findModel($id);
        $card = Card::find()->where(['number' => $card])->one();
        $model->has_come = 1;
        $model->save();
        Yii::$app->session->setFlash('success', 'Посещение зафиксировано!');
        return $this->redirect(['/card/view', 'id' => $card->id]);
    }


    /**
     * Updates an existing Visit model.
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
     * Deletes an existing Visit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id, $card)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Посещение удалено!');
        return $this->redirect(['/card/view', 'id' => $card]);
    }

    /**
     * Finds the Visit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Visit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Visit::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
