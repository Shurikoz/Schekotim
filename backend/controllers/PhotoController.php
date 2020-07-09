<?php

namespace backend\controllers;

use backend\models\Photo;
use backend\models\PhotoSearch;
use backend\models\Problem;
use backend\models\Visit;
use backend\models\VisitSearch;
use Yii;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;

/**
 * PhotoVisitController implements the CRUD actions for PhotoVisit model.
 */
class PhotoController extends Controller
{

    /**
     * Lists all PhotoVisit models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PhotoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $pages = new Pagination(['totalCount' => $dataProvider->getTotalCount(), 'pageSizeLimit' => [1, 40], 'defaultPageSize' => 10]);

        $filter = (new Photo())->getFilter();

        $problem = ArrayHelper::map(Problem::find()->all(), 'id', 'name');

        return $this->render('index', [
            'pages' => $pages,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'problem' => $problem,
            'filter' => $filter,
        ]);
    }

    public function actionUsed($id)
    {
        $visit = Visit::find()->where(['id' => $id])->one();

        if ($visit->used_photo == 1) {
            Yii::$app->session->setFlash('warning', 'Фотографии уже помечены как использованные!');
        } else {
            $visit->used_photo = 1;
            if ($visit->save(false)){
                Yii::$app->session->setFlash('success', 'Посещение №' . $visit->id . ' помечено как использованное!');
            } else {
                Yii::$app->session->setFlash('error', 'Что-то пошло не так...');
            }
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
    public function actionDownload($id, $type) {
        $image = Photo::findOne(['id' => $id]);
        if ($image === null) {
            throw new NotFoundHttpException('Фото не найдено');
        }
        if ($type == 'processed'){
            return Yii::$app->response->sendFile(Yii::getAlias('@backend/web' . $image->url));
        } elseif ($type == 'original'){
            return Yii::$app->response->sendFile(Yii::getAlias('@backend/web' . $image->original));
        }
    }

}
