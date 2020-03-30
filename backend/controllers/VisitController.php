<?php

namespace backend\controllers;

use backend\models\AddressPoint;
use backend\models\Photo;
use backend\models\Podolog;
use backend\models\Problem;
use backend\models\Visit;
use backend\models\VisitSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

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
     * создание нового фактического посещения
     * Creates a new Visit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateFirst()
    {
        $model = new Visit();
        $photoBefore = new Photo();
        $photoAfter = new Photo();

        //получим id точки из аккаунта текущего пользователя
        $addressPoint = Yii::$app->user->identity->address_point_id;
        $location = AddressPoint::find()->where(['id' => $addressPoint])->with('city')->one();
        $podolog = Podolog::find()->where(['user_id' => Yii::$app->user->identity->id])->one();

        //присвоим некоторые стандартные значения
        //для первого посещения
        $model->has_come = 1;
        $model->edit = 1; //возможность редактирования - 1 можно, 0 запрещено
        $model->timestamp = time() + 60 * 60 * 24 * 2; // 2 суток на редактирование
        $model->visit_time = date('H:m:i');
        $model->visit_date = date('Y-m-d');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $photoBefore->before = UploadedFile::getInstances($photoBefore, 'before');
            $photoAfter->after = UploadedFile::getInstances($photoAfter, 'after');

            $photoBefore->uploadBefore(
                $model->id,
                $location->address_point,
                Yii::$app->request->get('card_number'),
                $model->visit_date
            );
            $photoAfter->uploadAfter(
                $model->id,
                $location->address_point,
                Yii::$app->request->get('card_number'),
                $model->visit_date
            );

            Yii::$app->session->setFlash('success', 'Данные сохранены!');
            return $this->redirect(['card/view', 'id' => Yii::$app->request->get('id')]);
        }
        return $this->render('createFirst', [
            'model' => $model,
            'photoBefore' => $photoBefore,
            'photoAfter' => $photoAfter,
            'location' => $location,
            'podolog' => $podolog,
            'problem' => $this->findProblem(),
        ]);
    }

    /**
     * создание нового будущего посещения на основе выбранного
     * Creates a new Visit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCreateSecond($id, $card)
    {
        $modelFirst = $this->findModel($id);

        $model = new Visit();
        $model->setAttributes($modelFirst->attributes);

        //получим id точки из аккаунта текущего пользователя
        $addressPoint = Yii::$app->user->identity->address_point_id;
        $location = AddressPoint::find()->where(['id' => $addressPoint])->with('city')->one();
        $podolog = Podolog::find()->where(['user_id' => Yii::$app->user->identity->id])->one();

        //присвоим некоторые стандартные значения
        //для первого посещения
        $model->has_come = 0;
        $model->edit = 1; //возможность редактирования - 1 можно, 0 запрещено
        //$model->timestamp = time() + 60 * 60 * 24 * 2; // 2 суток на редактирование
        $model->visit_time = null;
        $model->visit_date = null;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            print_r($modelSecond);die;
            Yii::$app->session->setFlash('success', 'Данные сохранены!');
            return $this->redirect(['card/view', 'id' => Yii::$app->request->get('card')]);
        }
        return $this->render('createSecond', [
            'model' => $model,
            'location' => $location,
            'podolog' => $podolog,
            'problem' => $this->findProblem(),
        ]);
    }

    /**
     *Отметка что пациент пришел
     * @param integer $id
     * @param $card
     * @return mixed
     * action смены статуса визита пациента что он пришел
     * @throws NotFoundHttpException
     */
    public function actionCome($id, $card)
    {
        $model = $this->findModel($id);
        $result = $this->redirect(['/card/view', 'id' => $card]);
        $model->has_come = 1;
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Посещение зафиксировано!');
            return $result;
        }
    }

    /**
     * Отметка о решении проблемы
     * @param integer $id
     * @param $card
     * @param $resolve
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCompleted($id, $card, $resolve)
    {
        $model = $this->findModel($id);
        $result = $this->redirect(['/card/view', 'id' => $card]);

        //достанем то что записано в дате будущего визита и перезапишем
        $next_visit_from = $model->next_visit_from;
        $next_visit_by = $model->next_visit_by;

        if ($resolve == true) {
            $model->resolve = 1;
            $model->next_visit_from = $next_visit_from;
            $model->next_visit_by = $next_visit_by;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Проблема помечена решенной!');
                return $result;
            }
        } else if ($resolve == false) {
            $model->resolve = 0;
            if ($model->save()) {
                Yii::$app->session->setFlash('info', 'Проблема помечена как нерешенная.');
                return $result;
            }
        }
        Yii::$app->session->setFlash('danger', 'Ошибка отметки проблемы!');
        return $result;
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
        $onePhoto = new Photo();
        $photoBefore = Photo::find()->where(['visit_id' => $model->id, 'made' => 'before'])->all();
        $photoAfter = Photo::find()->where(['visit_id' => $model->id, 'made' => 'after'])->all();
        $addressPoint = Yii::$app->user->identity->address_point_id;
        $location = AddressPoint::find()->where(['id' => $addressPoint])->with('city')->one();
        $podolog = Podolog::find()->where(['user_id' => Yii::$app->user->identity->id])->one();

        $model->visit_time = date('H:m:i');
        $model->visit_date = date('Y-m-d');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['card/view', 'id' => Yii::$app->request->get('card')]);
        }
        return $this->render('update', [
            'model' => $model,
            'location' => $location,
            'podolog' => $podolog,
            'problem' => $this->findProblem(),
            'photoBefore' => $photoBefore,
            'photoAfter' => $photoAfter
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
        $model = $this->findModel($id);
        $modelPhoto = Photo::find()->where(['visit_id' => $model->id])->all();
        $model->delete();
        foreach ($modelPhoto as $item) {
            $item->delete();
        }

        //TODO дописать удаление папки с файлами при переносе на хостинг
//        $dir = Yii::getAlias('@webroot/upload/photo/') . $id;
//        chmod($dir, 0777);
//        unlink($dir);

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

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    protected function findProblem()
    {
        $problem = Problem::find()->all();
        return $problem;
    }

    /**
     * функция получения "рыбы" для форм в добавлении нового посещения
     * @return string
     */
    public function actionReceive($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $problem = Problem::find()->where(['id' => $id])->one();
            return $problem;
        }
    }

    public function actionAddPhoto($visitId, $cardId)
    {
        $photo = new Photo();
        $visit = Visit::findOne($visitId);

        $photoBefore = Photo::find()->where(['visit_id' => $visitId, 'made' => 'before'])->all();
        $photoAfter = Photo::find()->where(['visit_id' => $visitId, 'made' => 'after'])->all();

        $addressPoint = Yii::$app->user->identity->address_point_id;
        $location = AddressPoint::find()->where(['id' => $addressPoint])->with('city')->one();

        if (Yii::$app->request->isAjax) {


            $photo->onePhotoBefore = $_FILES['img'];


            $photo->uploadOnephotobefore(
                $visitId,
                $location->address_point,
                $cardId,
                $visit->visit_date
            );
            return $this->renderAjax('/photo/photo', [
                'photoBefore' => $photoBefore,
                'photoAfter' => $photoAfter,
                'onePhotoBefore' => new Photo(),
                'onePhotoAfter' => new Photo()
            ]);
        }
    }

    /**
     * @param $id
     * @return string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeletePhoto($id)
    {

        $photoBefore = Photo::find()->where(['visit_id' => $id, 'made' => 'before'])->all();
        $photoAfter = Photo::find()->where(['visit_id' => $id, 'made' => 'after'])->all();

        Photo::findOne($id)->delete();

        return $this->renderAjax('/photo/photo', [
            'photoBefore' => $photoBefore,
            'photoAfter' => $photoAfter,
            'onePhotoBefore' => new Photo(),
            'onePhotoAfter' => new Photo()
        ]);
    }

}
