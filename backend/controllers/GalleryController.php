<?php

namespace backend\controllers;

use backend\models\Gallery;
use Imagine\Image\Box;
use Yii;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\UploadedFile;

class GalleryController extends Controller
{
    public function actionIndex()
    {
        //категории: 0 - подология, 1 - маникюр, 2- педикюр
        $specialist = Gallery::find()->where(['category' => 0])->all();
        $manicure = Gallery::find()->where(['category' => 1])->all();
        $pedicure = Gallery::find()->where(['category' => 2])->all();

        return $this->render('index', [
            'specialist' => $specialist,
            'manicure' => $manicure,
            'pedicure' => $pedicure,
        ]);
    }

    public function actionUpload()
    {

        $model = new Gallery();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {

                $file = UploadedFile::getInstance($model, 'filename');
                $filename =  time() . md5($file->baseName) . '.' . $file->extension;

                $path = Yii::getAlias('@frontend/web') . '/images/gallery/' . $filename;

                if ($file->saveAs($path)){
                    $photo = Image::getImagine()->open(Yii::getAlias('@frontend/web') . '/images/gallery/' . $filename);
                    $photo->thumbnail(new Box(180, 180))->save(Yii::getAlias('@frontend/web') . '/images/gallery/thumbnail/' . $filename, ['quality' => 80]);

                    Yii::$app->session->setFlash('success', 'Данные сохранены!');
                    $model->filename = $filename;
                    $model->save();
                }
            }
        }

        return $this->render('upload', [
            'model' => $model,
        ]);
    }


    public function actionEdit($id){

        $model = Gallery::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Изменения сохранены!');
            return $this->redirect(['edit', 'id' => $model->id]);

        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }


    public function actionDelete($id){

        $data = Gallery::findOne($id);
        unlink(Yii::getAlias('@frontend/web') . '/images/gallery/' . $data->filename);
        unlink(Yii::getAlias('@frontend/web') . '/images/gallery/thumbnail/' . $data->filename);
        if ($data->delete()){
            Yii::$app->session->setFlash('success', 'Фотография удалена!');
        }
        return $this->redirect(['gallery/index']);
    }

}
