<?php

namespace backend\controllers;

use backend\models\Stock;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * StockController implements the CRUD actions for Stock model.
 */
class StockController extends Controller
{

    /**
     * Lists all Stock models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = Stock::find()->all();

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Stock model.
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
     * Creates a new Stock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = Stock::find()->all();
        $stock = new Stock();

        if ($stock->load(Yii::$app->request->post()) && $stock->save()) {
            if ($stock->file != null) {
                $stock->file = UploadedFile::getInstance($stock, 'file');
                $stock->upload($stock->id, $stock);
            }
            Yii::$app->session->setFlash('success', 'Акция создана!');
            return $this->redirect(['index', 'model' => $model]);
        }
        return $this->render('create', [
            'model' => $stock,
        ]);
    }

    /**
     * Updates an existing Stock model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = Stock::find()->all();
        $stock = $this->findModel($id);
        if ($stock->load(Yii::$app->request->post()) && $stock->save()) {
            if ($stock->file != null) {
                $stock->file = UploadedFile::getInstance($stock, 'file');
                $stock->upload($id, $stock);
            }
            Yii::$app->session->setFlash('success', 'Акция сохранена!');
            return $this->redirect(['index', 'model' => $model]);
        }
        return $this->render('update', [
            'model' => $stock,
        ]);
    }

    /**
     * Deletes an existing Stock model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        $dir = Yii::getAlias('@frontend/web/');
        if ($model->image) {
            unlink($dir . $model->image);
            rmdir($dir . 'upload/stock/' . $id);
        }
        Yii::$app->session->setFlash('success', 'Акция удалена!');
        $model = Stock::find()->all();
        return $this->render('index', [
            'model' => $model
        ]);
    }

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
     * Finds the Stock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stock::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
