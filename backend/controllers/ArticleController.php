<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleImage;
use backend\models\ArticleSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();
        $model->created_at = time();
        $articleImage = new ArticleImage();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            print_r(json_encode(Yii::$app->request->post()["Article"]["tags"]));die;
            if ($model->mainPhoto != null) {
                $model->mainPhoto = UploadedFile::getInstance($model, 'mainPhoto');
                $model->uploadPhoto($model->id, $model);
            }
            $articleImage->secondPhoto = UploadedFile::getInstances($articleImage, 'secondPhoto');
//            var_dump($articleImage);die;
            $articleImage->uploadPhotos($model->id);

            return $this->redirect('index');
        }
        return $this->render('create', [
            'model' => $model,
            'articleImage' => $articleImage
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->mainPhoto != null) {
                $model->mainPhoto = UploadedFile::getInstance($model, 'mainPhoto');
                $model->uploadPhoto($id, $model);
            }
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $article = $this->findModel($id);
        $article->delete();
        $dir = Yii::getAlias('@frontend/web/');
        if ($article->image) {
            unlink($dir . $article->image);
            rmdir($dir . 'upload/articles/' . $id . '/main');
        }
        //очистим папку от старых изображений
        foreach (glob($dir . 'upload/articles/' . $id . '/gallery/*') as $file) {
            unlink($file);
        }
        rmdir($dir . 'upload/articles/' . $id . '/gallery');
        $articleImage = ArticleImage::find()->where(['article_id' => $id])->all();
        foreach ($articleImage as $item) {
            $item->delete();
        }
        rmdir($dir . 'upload/articles/' . $id);


        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @throws NotFoundHttpException
     */
    public function actionDeletePhoto($id) {
        $model = $this->findModel($id);
        $dir = Yii::getAlias('@frontend/web/');
        if ($model->image) {
            unlink($dir . $model->image);
        }
        $model->image = null;
        $model->save(false);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPublic($id)
    {
        $article = $this->findModel($id);
        $article->status = 1;
        if ($article->save()) {
            Yii::$app->session->setFlash('success', 'Статья <b>' . $article->title . '</b> опубликована!');
        } else {
            Yii::$app->session->setFlash('danger', 'Произошла ошибка!');
        }

        return $this->redirect(['article/index']);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUnpublic($id)
    {
        $article = $this->findModel($id);
        $article->status = 0;
        if ($article->save()) {
            Yii::$app->session->setFlash('warning', 'Статья <b>' . $article->title . '</b> снята с публикации!');
        } else {
            Yii::$app->session->setFlash('danger', 'Произошла ошибка!');
        }
        return $this->redirect(['article/index']);

    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
