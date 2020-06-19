<?php

namespace backend\controllers;

use backend\models\Card;
use backend\models\Photo;
use backend\models\Podolog;
use backend\models\Problem;
use backend\models\Visit;
use backend\models\VisitSearch;
use kartik\mpdf\Pdf;
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
    public function actionMissed()
    {
        $model = Visit::find()->where(['has_come' => '2'])->all();
        return $this->render('missed', [
            'model' => $model
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
        $addressPoint = Yii::$app->user->identity->address_point;
        $podolog = Podolog::find()->where(['user_id' => Yii::$app->user->identity->id])->one();

        $card = Card::find()->where(['number' => Yii::$app->request->get('number')])->one();

        //присвоим некоторые стандартные значения
        //для первого посещения
        $model->has_come = 1;
        $model->edit = 1; //возможность редактирования - 1 можно, 0 запрещено
        $model->timestamp = time() + 60 * 60 * 24 * 2; // 2 суток на редактирование
        $model->visit_time = date('H:i:s');
        $model->visit_date = date('Y-m-d');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $photoBefore->before = UploadedFile::getInstances($photoBefore, 'before');
            $photoAfter->after = UploadedFile::getInstances($photoAfter, 'after');

            $photoBefore->uploadBefore(
                $model->id,
                $model->address_point,
                Yii::$app->request->get('card_number'),
                $model->visit_date
            );
            $photoAfter->uploadAfter(
                $model->id,
                $model->address_point,
                Yii::$app->request->get('card_number'),
                $model->visit_date
            );
            Yii::$app->session->setFlash('success', 'Данные сохранены!');
            return $this->redirect(['card/view', 'number' => Yii::$app->request->get('number')]);
        }
        return $this->render('createFirst', [
            'card' => $card,
            'model' => $model,
            'photoBefore' => $photoBefore,
            'photoAfter' => $photoAfter,
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

        $card = Card::find()->where(['number' => Yii::$app->request->get('number')])->one();

        //получим id точки из аккаунта текущего пользователя
        $addressPoint = Yii::$app->user->identity->address_point;
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
            return $this->redirect(['card/view', 'number' => Yii::$app->request->get('number')]);
        }
        return $this->render('createSecond', [
            'card' => $card,
            'model' => $model,
            'podolog' => $podolog,
            'problem' => $this->findProblem(),
        ]);
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
        $addPhotoBefore = new Photo();
        $addPhotoAfter = new Photo();

        $photoBefore = Photo::find()->where(['visit_id' => $model->id, 'made' => 'before'])->all();
        $photoAfter = Photo::find()->where(['visit_id' => $model->id, 'made' => 'after'])->all();
        $podolog = Podolog::find()->where(['id' => $model->podolog_id])->one();
        $card = Card::find()->where(['number' => $model->card_number])->one();

        $model->visit_time = date('H:i');
        $model->visit_date = date('Y-m-d');

        $model->card_number = $card->number;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $addPhotoBefore->before = UploadedFile::getInstances($addPhotoBefore, 'before');
            $addPhotoAfter->after = UploadedFile::getInstances($addPhotoAfter, 'after');

            $addPhotoBefore->uploadBefore(
                $model->id,
                Yii::$app->request->get('number'),
                $model->visit_date
            );
            $addPhotoAfter->uploadAfter(
                $model->id,
                Yii::$app->request->get('number'),
                $model->visit_date
            );

            Yii::$app->session->setFlash('success', 'Данные сохранены!');

            return $this->redirect(['card/view', 'number' => $card->number]);
        }
        return $this->render('update', [
            'card' => $card,
            'model' => $model,
            'podolog' => $podolog,
            'problem' => $this->findProblem(),
            'photoBefore' => $photoBefore,
            'photoAfter' => $photoAfter,
            'addPhotoBefore' => $addPhotoBefore,
            'addPhotoAfter' => $addPhotoAfter

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
        $result = $this->redirect(['/card/view', 'number' => $card]);

        //достанем то что записано в дате будущего визита и перезапишем
        $next_visit_from = $model->next_visit_from;
        $next_visit_by = $model->next_visit_by;

        if ($resolve == true) {
            $model->resolve = 1;
            $model->next_visit_from = $next_visit_from;
            $model->next_visit_by = $next_visit_by;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Проблема #' . $model->id . ' помечена решенной!');
                return $result;
            }
        } else if ($resolve == false) {
            $model->resolve = 0;
            if ($model->save()) {
                Yii::$app->session->setFlash('info', 'Проблема #' . $model->id . ' помечена как нерешенная.');
                return $result;
            }
        }
        Yii::$app->session->setFlash('danger', 'Ошибка отметки проблемы!');
        return $result;
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

        //удалим все фотографии посещения
        $dir = Yii::getAlias('@webroot/upload/photo/') . $id;
        chmod($dir, 0777);
        $this->delPhoto($dir);

        Yii::$app->session->setFlash('success', 'Посещение удалено!');
        return $this->redirect(['/card/view', 'number' => $card]);
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

        $addPhotoBefore = new Photo();
        $addPhotoAfter = new Photo();

        $photo = Photo::findOne($id);
        $dirUrl = Yii::getAlias('@webroot' . $photo->url);
        $dirThumb = Yii::getAlias('@webroot' . $photo->thumbnail);
        if ($photo->delete()) {
            chmod($dirUrl, 0777);
            chmod($dirThumb, 0777);
            unlink($dirUrl);
            unlink($dirThumb);
        }

        return $this->renderAjax('/photo/photo', [
            'photoBefore' => $photoBefore,
            'photoAfter' => $photoAfter,
            'addPhotoBefore' => $addPhotoBefore,
            'addPhotoAfter' => $addPhotoAfter
        ]);
    }

    /**
     * @param $id
     * @param $card
     * @return array|mixed
     * @throws NotFoundHttpException
     * @var TYPE_NAME $postId
     */
    public function actionSetPodolog($id, $number){
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            $postId = (int)$post['Visit']['podolog_id'];
            $model->podolog_id = $postId;
        }
        $podolog = Podolog::find()->where(['id' => $postId])->one();
        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'Подолог в посещении <b>#' . $model->id . '</b> изменен на <b>' . $podolog->name . '</b>');
            return Yii::$app->response->redirect(['card/view', 'number' => $number]);
        } else {
            Yii::$app->session->setFlash('danger', 'Данные не сохранены!');
            return Yii::$app->response->redirect(['card/view', 'number' => $number]);
        }
    }

    /**
     * @return mixed
     * @throws \Mpdf\MpdfException
     * @throws \setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException
     * @throws \setasign\Fpdi\PdfParser\PdfParserException
     * @throws \setasign\Fpdi\PdfParser\Type\PdfTypeException
     * @throws \yii\base\InvalidConfigException
     * @throws NotFoundHttpException
     */
    public function actionPrintPdf($id, $card_id) {

        // get your HTML raw content without any layouts or scripts
        $visit = $this->findModel($id);
        $card = Card::find()->where(['id' => $card_id])->one();
        $podolog = Podolog::find()->where(['id' => $visit->podolog_id])->one();

        $content = $this->renderPartial('_pdfView', [
            'visit' => $visit,
            'card' => $card,
            'podolog' => $podolog
            ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
//            'cssInline' => '.kv-heading-1{font-size:18px}',
            'cssInline' => '.pdfBody{font-family: "phenomena";}',
            // set mPDF properties on the fly
            'options' => [
                'title' => 'Центр подологии «Щекотливая тема»',
                'showWatermarkImage' => true,
                ],
            // call mPDF methods on the fly
            'methods' => [
//                'SetHeader'=>['Центр подологии «Щекотливая тема» / ' . date('d.m.Y')],
                'SetWatermarkImage' => ['./images/blank.png'],
//                'SetFooter'=>['{PAGENO}'],
                'SetFooter'=>['Центр подологии «Щекотливая тема» / ' . date('d.m.Y')],
            ]
        ]);
        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    /**
     * функция для удаления фотографий посещения
     * @param $dir
     */
    protected function delPhoto($dir)
    {
        $folders = ['/temp', '/before', '/after', '/thumbBefore', '/thumbAfter'];
        foreach ($folders as $folder) {
            if (file_exists($dir . $folder . '/')) {
                foreach (glob($dir . $folder . '/*') as $file) {
                    unlink($file);
                }
            }
            rmdir($dir . $folder);
        }
        rmdir($dir);
    }
}
