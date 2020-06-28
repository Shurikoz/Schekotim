<?php

namespace backend\controllers;

use Yii;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\ReviewForm;
use backend\models\ReviewSearch;


/**
 * ReviewController implements the CRUD actions for ReviewForm model.
 */
class ReviewController extends Controller
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
     * Lists all ReviewForm models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = ReviewForm::find()->all();
        $searchModel = new ReviewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['id' => SORT_DESC]];

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReviewForm model.
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
     * Creates a new ReviewForm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ReviewForm();
        $model->created_at = date("d-m-y");

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ReviewForm model.
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
     * Deletes an existing ReviewForm model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->image != '') {
            FileHelper::unlink(Yii::getAlias('@frontend') . '/web/images/reviews/' . $model->image);
            FileHelper::unlink(Yii::getAlias('@frontend') . '/web/images/reviews/thumbnail/' . $model->image);
        }
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the ReviewForm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Review the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReviewForm::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Updates an existing ReviewForm model.
     * Публикация отзыва
     */

    public function actionShow($id)
    {
        $model = ReviewForm::findOne($id);
        if ($model->active == 0){
            $model->active = '1';

            $model->sendReviewClientPublic(
                $model->name,
                $model->email,
                $model->rating,
                $model->text,
                $model->mobile,
                $model->image
            );

            Yii::$app->session->setFlash('success', 'Отзыв опубликован! (ID ' . $id . ')');
        } else {
            Yii::$app->session->setFlash('error', 'Отзыв уже опубликован!');
        }
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Updates an existing ReviewForm model.
     * Снятие отзыва с публикации
     */
    public function actionHide($id)
    {
        $model = ReviewForm::findOne($id);
        if ($model->active == 1){
            $model->active = 0;
            Yii::$app->session->setFlash('success', 'Отзыв снят с публикации!');
        } else {
            Yii::$app->session->setFlash('error', 'Отзыв не опубликован!');
        }
        $model->save();

        return $this->redirect(['index']);
    }

}
