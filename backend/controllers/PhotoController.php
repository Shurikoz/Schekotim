<?php

namespace backend\controllers;

use backend\models\Photo;
use backend\models\Visit;
use backend\models\VisitSearch;
use Yii;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PhotoVisitController implements the CRUD actions for PhotoVisit model.
 */
class PhotoController extends Controller
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
     * Lists all PhotoVisit models.
     * @return mixed
     */
    public function actionIndex()
    {
        $visits = Visit::find();
        $pages = new Pagination(['totalCount' => $visits->count(), 'pageSizeLimit' => [1, 60], 'defaultPageSize' => 20]);
        $model = $visits->offset($pages->offset)->limit($pages->limit)->orderBy(['id' => SORT_DESC])->with('photo')->all();

        return $this->render('index', [
            'model' => $model,
            'pages' => $pages
        ]);
    }

    public function actionUsed($id)
    {
        $visit = Visit::find()->where(['id' => $id])->one();
        if ($visit->used_photo == '1') {
            Yii::$app->session->setFlash('warning', 'Фотографии уже помечены как использованные!');
        } else {
            $visit->used_photo = '1';
            $visit->save();
            Yii::$app->session->setFlash('success', 'Фотографии помечены как использованные!');
        }
        return $this->redirect(['index']);

    }

    /**
     * Displays a single PhotoVisit model.
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
     * Creates a new PhotoVisit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Photo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PhotoVisit model.
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
     * Deletes an existing PhotoVisit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PhotoVisit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Photo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Photo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param $id
     * @return \yii\console\Response|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDownload($id) {
        $image = Photo::findOne(['id' => $id]);
        if ($image === null) {
            throw new NotFoundHttpException('Фото не найдено');
        }
        return Yii::$app->response->sendFile(Yii::getAlias('@backend/web' . $image->url));
    }

}
