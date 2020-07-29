<?php

namespace backend\controllers;

use backend\models\Card;
use backend\models\Photo;
use backend\models\Specialist;
use backend\models\Problem;
use backend\models\Visit;
use backend\models\VisitPlannedSearch;
use backend\models\VisitSearch;
use common\models\User;
use kartik\mpdf\Pdf;
use Mpdf\Config\ConfigVariables;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\data\Pagination;
use Mpdf\Config\FontVariables;


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
        $searchModel = new VisitSearch();
        //has_come: 0 - ожидание, 1 - пришел, 2 - не пришел
        $model = Visit::find()->where(['has_come' => '2'])->with('card', 'city', 'address_point')->all();
        return $this->render('missed', [
            'searchModel' => $searchModel,
            'model' => $model
        ]);
    }

    /**
     * @return string
     */
    public function actionPlanned()
    {
        $searchModel = new VisitPlannedSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $pages = new Pagination(['totalCount' => $dataProvider->getTotalCount(), 'pageSizeLimit' => [1, 60], 'defaultPageSize' => 20]);
        //пройдемся по посещениям, если пациент не пришел до указанного времени, сделаем отметку

        $check = new Visit();
        $check->checkVisit($dataProvider->getModels());

        return $this->render('planned', [
            'pages' => $pages,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @return string
     */
    public function actionNophotos(){
        $visit = Visit::find()->where(['has_come' => 1])->with('photo', 'card')->all();
        $photo = Photo::find()->all();

        return $this->render('nophotos', [
            'visit' => $visit,
            'photo' => $photo,
        ]);

    }

    /**
     * создание нового фактического посещения
     * Creates a new Visit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $post = Yii::$app->request->post();

        $user = User::find()->where(['id' => Yii::$app->user->identity->getId()])->with('city', 'address_point')->one();

        $cardNumber = Yii::$app->request->get('number');
        $visit = Visit::find()->where(['card_number' => $cardNumber])->orderBy(['number' => SORT_DESC])->one();

        $model = new Visit();
        $secondVisit = new Visit();

        $photoBefore = new Photo();
        $photoAfter = new Photo();
        $photoDermatolog = new Photo();

        $specialist = Specialist::find()->where(['user_id' => Yii::$app->user->identity->id])->one();

        $specialistModel = Specialist::find()->where(['address_point_id' => $user->address_point_id])->all();

        $card = Card::find()->where(['number' => $cardNumber])->one();

        //присвоим некоторые стандартные значения для первого посещения
        //has_come: 0 - ожидание, 1 - пришел, 2 - не пришел
        $model->has_come = 1;
        $model->edit = 1; //возможность редактирования - 1 можно, 0 запрещено
        $model->timestamp = time() + 60 * 60 * 24 * 2; // 2 суток на редактирование
        $model->visit_date = time();

        if ($visit != null) {
            $model->number = (int)$visit->number + 1;
        } else {
            $model->number = 1;
        }

        if ($model->load($post) && $secondVisit->load($post)) {
                if ($secondVisit->next_visit_from && $secondVisit->next_visit_by) {
                    $secondVisit->next_visit_from = strtotime($secondVisit->next_visit_from);
                    $secondVisit->next_visit_by = strtotime($secondVisit->next_visit_by);
                    $secondVisit->timestamp = $secondVisit->next_visit_by + 60 * 60 * 11;
                    $secondVisit->planned = 1;
                }

            $model->next_visit_from = null;
            $model->next_visit_by = null;

            if ($model->save()) {
                if ($secondVisit->next_visit_from && $secondVisit->next_visit_by) {
                    $second = Visit::find()->where(['card_number' => $cardNumber])->orderBy(['number' => SORT_DESC])->one();
                    $secondVisit->number = (int)$second->number + 1;
                    $secondVisit->save();
                    $model->has_second_visit = $secondVisit->id;
                    $model->save();
                }

                if (Yii::$app->user->can('podolog')){
                    $photoBefore->before = UploadedFile::getInstances($photoBefore, 'before');
                    $photoAfter->after = UploadedFile::getInstances($photoAfter, 'after');
                    $photoBefore->uploadBefore($model->id, Yii::$app->request->get('number'), date('d.m.Y', $model->visit_date));
                    $photoAfter->uploadAfter($model->id, Yii::$app->request->get('number'), date('d.m.Y', $model->visit_date));
                } elseif (Yii::$app->user->can('dermatolog')) {
                    $photoDermatolog->dermatolog = UploadedFile::getInstances($photoDermatolog, 'dermatolog');
                    $photoDermatolog->uploadDermatolog($model->id, Yii::$app->request->get('number'), date('d.m.Y', $model->visit_date));
                }

                Yii::$app->session->setFlash('success', 'Данные сохранены!');
                return $this->redirect(['card/view', 'number' => $cardNumber]);
            }

        }
        return $this->render('create', [
            'user' => $user,
            'card' => $card,
            'model' => $model,
            'secondVisit' => $secondVisit,
            'photoBefore' => $photoBefore,
            'photoAfter' => $photoAfter,
            'photoDermatolog' => $photoDermatolog,
            'specialist' => $specialist,
            'problem' => $this->findProblem(),
            'specialistModel' => $specialistModel,
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

        $post = Yii::$app->request->post();

        $model = Visit::find()->where(['id' => $id])->with('city', 'address_point', 'specialist')->one();
        $addPhotoBefore = new Photo();
        $addPhotoAfter = new Photo();
        $addPhotoDermatolog = new Photo();
        $secondVisit = new Visit();
        $card = Card::find()->where(['number' => $model->card_number])->one();

        // проверка на разрешение редактирования посещения
        if (!Visit::checkSuccessChange($model)){
            Yii::$app->session->setFlash('danger', 'Вам не разрешено редактировать это посещение!');
            return $this->redirect(['card/view', 'number' => $card->number]);
        }

        $photoBefore = Photo::find()->where(['visit_id' => $model->id, 'made' => 'before'])->all();
        $photoAfter = Photo::find()->where(['visit_id' => $model->id, 'made' => 'after'])->all();
        $photoDermatolog = Photo::find()->where(['visit_id' => $model->id, 'made' => 'dermatolog'])->all();
        $specialist = Specialist::find()->where(['id' => $model->specialist_id])->one();

        $lastVisit = Visit::find()->where(['card_number' => $model->card_number])->orderBy(['number' => SORT_DESC])->one();

            if ($model->load($post) && $secondVisit->load($post)) {
                if ($secondVisit->next_visit_from && $secondVisit->next_visit_by) {
                    $secondVisit->number = (int)$lastVisit->number + 1;
                    $secondVisit->next_visit_from = strtotime($secondVisit->next_visit_from);
                    $secondVisit->next_visit_by = strtotime($secondVisit->next_visit_by);
                    $secondVisit->timestamp = $secondVisit->next_visit_by + 60 * 60 * 11;
                    $secondVisit->planned = 1;
                    $secondVisit->has_come = 0;
                    $secondVisit->save();
                }

                if ($model->has_come == 1 && $model->visit_date == null) {
                    $model->visit_date = time();
                }
                $model->card_number = $card->number;
                $model->planned = 0;
                $model->next_visit_from = null;
                $model->next_visit_by = null;

            if ($model->save()) {
                $model->has_second_visit = $secondVisit->id;
                $model->save();

                if ($model->specialist->profession == 'podolog'){

                    $addPhotoBefore->before = UploadedFile::getInstances($addPhotoBefore, 'before');
                    $addPhotoAfter->after = UploadedFile::getInstances($addPhotoAfter, 'after');

                    $addPhotoBefore->uploadBefore($model->id, Yii::$app->request->get('number'), date('d.m.Y', $model->visit_date));
                    $addPhotoAfter->uploadAfter($model->id, Yii::$app->request->get('number'), date('d.m.Y', $model->visit_date));

                } elseif ($model->specialist->profession == 'dermatolog') {
                    $addPhotoDermatolog->dermatolog = UploadedFile::getInstances($addPhotoDermatolog, 'dermatolog');
                    $addPhotoDermatolog->uploadDermatolog($model->id, Yii::$app->request->get('number'), date('d.m.Y', $model->visit_date));
                }

                Yii::$app->session->setFlash('success', 'Данные визита <b>#' . $model->id . '</b> сохранены!');
                return $this->redirect(['card/view', 'number' => $card->number]);
            }

        }
        return $this->render('update', [
            'card' => $card,
            'model' => $model,
            'secondVisit' => $secondVisit,
            'specialist' => $specialist,
            'problem' => $this->findProblem(),
            'photoBefore' => $photoBefore,
            'photoAfter' => $photoAfter,
            'addPhotoBefore' => $addPhotoBefore,
            'addPhotoAfter' => $addPhotoAfter,
            'photoDermatolog' => $photoDermatolog,
            'addPhotoDermatolog' => $addPhotoDermatolog,
        ]);
    }

    /**
     * Updates an existing Visit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCopy($id)
    {
        $post = Yii::$app->request->post();

        $model = Visit::find()->where(['id' => $id])->with('city', 'address_point')->one();
        $copyVisit = new Visit();
//        $specialist = Specialist::find()->where(['id' => $model->specialist_id])->one();
        $specialist = Specialist::find()->where(['user_id' => Yii::$app->user->getId()])->one();

        $card = Card::find()->where(['number' => $model->card_number])->one();
        $lastVisit = Visit::find()->where(['card_number' => $model->card_number])->orderBy(['number' => SORT_DESC])->one();

        if ($copyVisit->load($post)) {
            $copyVisit->number = (int)$lastVisit->number + 1;
            $copyVisit->timestamp = time() + 60 * 60 * 24 * 2; // 2 суток на редактирование
            $copyVisit->visit_date = null;
            $copyVisit->card_number = $card->number;
            $copyVisit->planned = 0;
            $copyVisit->next_visit_from = null;
            $copyVisit->next_visit_by = null;

            if ($copyVisit->save()) {
                Yii::$app->session->setFlash('success', 'Создана копия визита <b>#' . $model->id . '</b> под номером  <b>#' . $copyVisit->id . '</b>!');
                return $this->redirect(['card/view', 'number' => $card->number]);
            }

        }
        return $this->render('copy', [
            'card' => $card,
            'model' => $model,
            'copyVisit' => $copyVisit,
            'specialist' => $specialist,
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
        if (is_dir($dir)) {
            chmod($dir, 0777);
            Photo::DelPhoto($dir);
        }


        Yii::$app->session->setFlash('success', 'Посещение удалено!');
        return $this->redirect(['/card/view', 'number' => $card]);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    protected function findProblem()
    {
        $problem = Problem::find()->orderBy(['number' => SORT_ASC])->all();
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
        $photoDermatolog = Photo::find()->where(['visit_id' => $id, 'made' => 'dermatolog'])->all();

        $addPhotoBefore = new Photo();
        $addPhotoAfter = new Photo();
        $addPhotoDermatolog = new Photo();
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
            'photoDermatolog' => $photoDermatolog,
            'addPhotoBefore' => $addPhotoBefore,
            'addPhotoAfter' => $addPhotoAfter,
            'addPhotoDermatolog' => $addPhotoDermatolog,
        ]);
    }

    /**
     * @param $id
     * @param $card
     * @return array|mixed
     * @throws NotFoundHttpException
     * @var TYPE_NAME $postId
     */
    public function actionSetspecialist($id, $number){
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            $postId = (int)$post['Visit']['specialist_id'];
            $model->specialist_id = $postId;
        }
        $specialist = Specialist::find()->where(['id' => $postId])->one();
        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'Подолог в посещении <b>#' . $model->id . '</b> изменен на <b>' . $specialist->name . '</b>');
            return Yii::$app->response->redirect(['card/view', 'number' => $number]);
        } else {
            Yii::$app->session->setFlash('danger', 'Данные не сохранены!');
            return Yii::$app->response->redirect(['card/view', 'number' => $number]);
        }
    }

    /**
     * поставить отметку
     * клиент оповещен о запланированном посещении
     * @throws NotFoundHttpException
     */
    public function actionContacted($id)
    {
        $post = Yii::$app->request->post();
        $visit = $this->findModel($id);
        $visit->contacted = strtotime($post["Visit"]["contacted"]);
        $visit->comment = $post["Visit"]["comment"];
        if ($visit->save()) {
            Yii::$app->session->setFlash('success', 'Клинент уведомлен о посещении!');
        }

        $this->redirect("/visit/planned");

    }

    /**
     * снять отметку
     * клиент оповещен о запланированном посещении
     * @throws NotFoundHttpException
     */
    public function actionContactUnmark($id)
    {
        $visit = $this->findModel($id);
        $visit->contacted = 0;
        if ($visit->save()) {
            Yii::$app->session->setFlash('success', 'Отметка "Клинент уведомлен о посещении" снята!');
        }

        $this->redirect("/visit/planned");

    }

    /**
     * запись клиента на посещение
     * @throws NotFoundHttpException
     */
    public function actionRecord($id, $page, $number)
    {
        $post = Yii::$app->request->post();
        $visit = $this->findModel($id);
        if ($visit->load($post)) {
            $visit->visit_date = strtotime($post["Visit"]["visit_date"]);
            $visit->timestamp = strtotime($post["Visit"]["visit_date"]) + 60 * 60 * 24 * 2;
            $visit->recorded = 1;
        }
        if ($visit->save()) {
            Yii::$app->session->setFlash('success', 'Клинент записан!');
        } else {
            Yii::$app->session->setFlash('danger', 'Не выбрано время записи!');
        }

        if ($page == 'view'){
            $this->redirect(['card/view', 'number' => $number]);
        } elseif ($page == 'planned') {
            $this->redirect("/visit/planned");
        }
    }

    /**
     * снять отметку
     * клиент записан на посещение
     * @throws NotFoundHttpException
     */
    public function actionRecordUnmark($id, $page, $number)
    {
        $visit = $this->findModel($id);
        $visit->visit_date = null;
        if ($visit->next_visit_from != null && $visit->next_visit_by != null && $visit->not_in_time == 1) {
            if (($visit->visit_date < $visit->next_visit_by) || ($visit->visit_date == null && (int)$visit->next_visit_by + 60 * 60 * 11 > time())) {
                $visit->timestamp = strtotime($visit->next_visit_by) + 60 * 60 * 24 * 2;
                $visit->not_in_time = 0;
            }
        }
        $visit->recorded = 0;
        if ($visit->save()) {
            Yii::$app->session->setFlash('warning', 'Запись клиента снята!');
        }

        if ($page == 'view'){
            $this->redirect(['card/view', 'number' => $number]);
        } elseif ($page == 'planned') {
            $this->redirect("/visit/planned");
        }

    }

    /**
     * клиент отказался от записи
     * @throws NotFoundHttpException
     */
    public function actionCancel($id)
    {
        $visit = $this->findModel($id);
        $visit->cancel = 1;
        $visit->contacted = 0;

        if ($visit->save()) {
            Yii::$app->session->setFlash('warning', 'Клинент отказался от записи!');
        }
        $this->redirect("/visit/planned");
    }

    /**
     * снять отметку
     * клиент отказался от записи
     * @throws NotFoundHttpException
     */
    public function actionCancelUnmark($id)
    {
        $visit = $this->findModel($id);
        $visit->cancel = 0;
        if ($visit->save()) {
            Yii::$app->session->setFlash('warning', 'Отметка "Клинент отказался от записи снята!');
        }
        $this->redirect("/visit/planned");
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
    public function actionPrintPdf($profession, $id, $card_id) {

        // get your HTML raw content without any layouts or scripts
        $visit = $this->findModel($id);
        $secondVisit = $visit->has_second_visit != 0 ? Visit::find()->where(['id' => $visit->has_second_visit])->one() : null;
        $card = Card::find()->where(['id' => $card_id])->one();
        $specialist = Specialist::find()->where(['id' => $visit->specialist_id])->one();

        $content = $this->renderPartial('_pdfView', [
            'visit' => $visit,
            'card' => $card,
            'specialist' => $specialist,
            'profession' => $profession,
            'secondVisit' => $secondVisit
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
            'cssInline' => '',
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
     * @param $id
     * @param $number
     * @return \yii\web\Response
     */
    public function actionEdit24h($id, $number)
    {
        $model = Visit::find()->where(['id' => $id])->one();
        $card = Card::find()->where(['number' => $number])->one();
        $model->timestamp = time() + 60 * 60 * 24;
        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'Возможность редактирования посещения <b>#' . $model->id . '</b> продлена на 24 часа!');
        } else {
            Yii::$app->session->setFlash('danger', 'Ошибка продления срока редактирования!');
        }
        return $this->redirect(['card/view', 'number' => $card->number]);
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
