<?php

namespace backend\models;
use russ666\widgets\Countdown;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "visit".
 *
 * @property int $id
 * @property int $number
 * @property string $specialist_id
 * @property int $card_number
 * @property string $city_id
 * @property string $address_point_id
 * @property string $problem_id
 * @property string $anamnes
 * @property string $manipulation
 * @property string $recommendation
 * @property string $diagnosis
 * @property string $next_visit_from
 * @property string $next_visit_by
 * @property string $planned
 * @property string $visit_date
 * @property string $has_come
 * @property string $resolve
 * @property string $used_photo
 * @property string $description
 * @property string $timestamp
 * @property string $cancel
 * @property string $edit
 * @property string $dermatolog
 * @property string $immunolog
 * @property string $ortoped
 * @property string $hirurg
 * @property string $recorded
 * @property string $contacted
 * @property string $comment
 * @property string $has_second_visit
 * @property string $not_in_time
 */

class Visit extends ActiveRecord
{

    public $cnt;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'visit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['card_number', 'used_photo', 'edit', 'dermatolog', 'immunolog', 'ortoped', 'hirurg', 'planned', 'visit_date', 'number', 'has_second_visit', 'not_in_time'], 'integer'],
            [['anamnes', 'manipulation', 'recommendation', 'description', 'diagnosis'], 'string'],
            [['address_point_id', 'city_id', 'resolve', 'has_come', 'timestamp', 'next_visit_from', 'next_visit_by', 'call_time'], 'safe'],
            ['problem_id', 'integer', 'min' => '1', 'tooSmall' => 'Проблема не выбрана!'],
            ['specialist_id', 'integer', 'min' => '1', 'tooSmall' => 'Специалист не выбран!'],
            [['comment'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id посещения',
            'number' => 'Номер посещения',
            'user_id' => 'ID пользователя',
            'card_number' => 'Номер карты',
            'city_id' => 'City ID',
            'address_point_id' => 'Точка',
            'specialist_id' => 'Специалист',
            'anamnes' => 'Анамнез',
            'manipulation' => 'Манипуляции',
            'recommendation' => 'Рекомендации',
            'dermatolog' => 'Дерматолог',
            'immunolog' => 'Иммунолог',
            'ortoped' => 'Ортопед',
            'hirurg' => 'Хирург',
            'next_visit_from' => 'Следующий визит с',
            'next_visit_by' => 'Следующий визит по',
            'visit_date' => 'Дата посещения',
            'has_come' => 'Пациент пришел',
            'resolve' => 'Проблема решена',
            'used_photo' => '',
            'description' => 'Комментарий',
            'edit' => 'Редактирование',
            'planned' => 'Запланированное посещение',
            'comment' => 'Коментарий',
            'diagnosis' => 'Диагноз'
        ];
    }

    /**
     * @param $insert
     * @param $changedAttributes
     * @return bool
     */
    public function afterSave($insert, $changedAttributes)
    {
//        $specialist = specialist::find()->where(['id' => $this->attributes['specialist_id']])->one();
        $operation = $insert ? 'create' : 'update';
        $log = new Logs();
        $log->time = time();
        $log->operation = $operation;
        $log->changes = json_encode($this->attributes, JSON_UNESCAPED_UNICODE);
//        $log->user_id = $specialist->user_id;
        $log->city_id = Yii::$app->user->identity->city_id;
        $log->address_point_id = Yii::$app->user->identity->address_point_id;
        $log->user_id = Yii::$app->user->identity->getId();
        $log->object = 'visit';
        $log->object_id = $this->id;
        $log->save(false);
        return parent::afterSave($insert, $changedAttributes);
    }

    /**
     * проверка посещений - пришел ли клиент и пришел вовремя/не вовремя
     * производится в контроллере CardController в экшене actionView
     */
    public function checkVisit($visits)
    {
        foreach ($visits as $visit) {
            if ($visit->next_visit_from != null && $visit->next_visit_by != null) {
                //клиент пришел не вовремя
                if ($visit->not_in_time == 0 && $visit->has_come == 0 && $visit->cancel == 0) {
                    if ($visit->visit_date == null && $visit->next_visit_by + 60 * 60 * 24 < time()) {
                        $visit->not_in_time = 1;
                        $visit->save();
                    } elseif ($visit->visit_date > $visit->next_visit_by + 60 * 60 * 24) {
                        $visit->not_in_time = 1;
                        $visit->save();
                    }
                }

                //клиент не пришел
                if ($visit->recorded == 0 && $visit->has_come == 0 && $visit->has_come != 2 && $visit->next_visit_by + 60 * 60 * 24 < time()) {
                    $visit->has_come = 2; //клиент не пришел
                    $visit->planned = 0;
                    $visit->save();
                } elseif ($visit->recorded == 1 && $visit->visit_date != null && $visit->visit_date + 60 * 60 * 12 < time() && $visit->has_come == 0 && $visit->has_come != 2) {
                    $visit->has_come = 2; //клиент не пришел
                    $visit->planned = 0;
                    $visit->save();
                }

            }
        }
    }

    /**
     * таймер обратного отсчета для кнопки изменения посещения
     * @param $item
     * @return string
     * @throws \Exception
     */
    public static function timer($item)
    {
        $res = Countdown::widget([
            'id' => 'timer_' . $item->id,
            'datetime' => date('Y-m-d H:i:s O', time() + ($item->timestamp - time())),
            'format' => '<span style=\"color: red\"\>%-D д. %-H:%-M:%-S</span> ',
            'tagName' => 'span',
            'events' => [
                'finish' => 'function(){$(\'#blockEdit_\' + $(this).parent().attr("data-id")).remove();}',
            ],
            'options' => [
                'class' => 'timerBox'
            ]
        ]);
        return $res;
    }
    /**
     * проверка на разрешение редактирования посещения
     * производится во вьюхе card/view
     */
    public static function checkSuccessChange($visit)
    {
        $admin = Yii::$app->user->can('admin');
        $leader = Yii::$app->user->can('leader');
        $administrator = Yii::$app->user->can('administrator');
        if ($visit->specialist_id != 0){
            if ($visit->has_come != 2
                && ($visit->specialist->user_id == Yii::$app->user->id || $admin || $leader || $administrator || $visit->specialist_id == 0) && ($visit->timestamp >= time() && $visit->resolve != 1 || $visit->next_visit_by != null && $visit->next_visit_by >= time())) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }

    /**
     * проверка на разрешение создания копии посещения
     */
    public static function checkSuccessCopy($item)
    {
        if ($item->next_visit_from == null && $item->next_visit_by == null && $item->visit_date != null){
            return true;
        } else {
            return false;
        }
    }

    /**
     * запись клиента на посещение
     */
    public static function record($id)
    {
        $post = Yii::$app->request->post();
        $visit = Visit::findOne($id);
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
    }

    /**
     * снять отметку "клиент записан на посещение"
     */
    public static function recordUnmark($id)
    {
        $visit = Visit::findOne($id);
        $visit->visit_date = null;
        if ($visit->next_visit_from != null && $visit->next_visit_by != null && $visit->not_in_time == 1) {
            if (($visit->visit_date < $visit->next_visit_by) || ($visit->visit_date == null && (int)$visit->next_visit_by + 60 * 60 * 11 > time())) {
                $visit->timestamp = strtotime($visit->next_visit_by) + 60 * 60 * 24 * 2;
                $visit->not_in_time = 0;
            }
        }
        $visit->recorded = 0;
        if ($visit->save(false)) {
            Yii::$app->session->setFlash('warning', 'Запись клиента снята!');
        }
    }

    /**
     * отметка проблемы как Решенная
     */
    public static function completed($id, $resolve)
    {
        $model = Visit::findOne($id);
        //достанем то что записано в дате будущего визита и перезапишем
        $next_visit_from = $model->next_visit_from;
        $next_visit_by = $model->next_visit_by;

        if ($resolve == true) {
            $model->resolve = 1;
            $model->next_visit_from = $next_visit_from;
            $model->next_visit_by = $next_visit_by;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Проблема #' . $model->id . ' помечена решенной!');
            }
        } else if ($resolve == false) {
            $model->resolve = 0;
            if ($model->save()) {
                Yii::$app->session->setFlash('warning', 'Проблема #' . $model->id . ' помечена как нерешенная.');
            }
        } else {
            Yii::$app->session->setFlash('danger', 'Ошибка отметки проблемы!');
        }
        return true;
    }

    /**
     * отметка Консультация
     * 0 - не решена
     * 1 - решена
     * 2 - консультация
     */
    public static function consult($id, $resolve)
    {
        $model = Visit::findOne($id);
        //достанем то что записано в дате будущего визита и перезапишем
        $next_visit_from = $model->next_visit_from;
        $next_visit_by = $model->next_visit_by;

        if ($resolve == true) {
            $model->resolve = 2;
            $model->next_visit_from = $next_visit_from;
            $model->next_visit_by = $next_visit_by;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Проблема #' . $model->id . ' помечена как Консультация!');
            }
        } else if ($resolve == false) {
            $model->resolve = 0;
            if ($model->save()) {
                Yii::$app->session->setFlash('warning', 'С проблемы #' . $model->id . ' снята отметка Консультация.');
            }
        } else {
            Yii::$app->session->setFlash('danger', 'Ошибка отметки проблемы!');
        }
        return true;
    }

    /**
     * удаление посещения
     */
    public static function deleteVisit($id)
    {
        $model = Visit::findOne($id);
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
    }

    /**
     * удаление фотографий
     * производится через VisitController, экшен actionDeletePhoto
     */
    public static function deletePhoto($id)
    {
        $photoBefore = Photo::find()->where(['visit_id' => $id, 'made' => 'before'])->all();
        $photoAfter = Photo::find()->where(['visit_id' => $id, 'made' => 'after'])->all();
        $photoDermatolog = Photo::find()->where(['visit_id' => $id, 'made' => 'dermatolog'])->all();

        $photo = Photo::findOne($id);
        $dirUrl = Yii::getAlias('@webroot' . $photo->url);
        $dirThumb = Yii::getAlias('@webroot' . $photo->thumbnail);
        $dirOrig = Yii::getAlias('@webroot' . $photo->original);
        $dirTemplate = Yii::getAlias('@webroot' . $photo->template);

        if ($photo->delete()) {
            chmod($dirUrl, 0777);
            unlink($dirUrl);

            chmod($dirThumb, 0777);
            unlink($dirThumb);

            chmod($dirOrig, 0777);
            unlink($dirOrig);

            chmod($dirTemplate, 0777);
            unlink($dirTemplate);
        }
        return [
            'photoBefore' => $photoBefore,
            'photoAfter' => $photoAfter,
            'photoDermatolog' => $photoDermatolog,
            'addPhotoBefore' => new Photo(),
            'addPhotoAfter' => new Photo(),
            'addPhotoDermatolog' => new Photo(),
        ];
    }

    public function getCard()
    {
        return $this->hasOne(Card::className(), ['number' => 'card_number']);
    }

    public function getPhoto()
    {
        return $this->hasMany(Photo::className(), ['visit_id' => 'id']);
    }

    public function getPhotoCount()
    {
        return count($this->photo);
    }

    public function getSpecialist()
    {
        return $this->hasOne(Specialist::className(), ['id' => 'specialist_id']);
    }

    public function getProblem()
    {
        return $this->hasOne(Problem::className(), ['id' => 'problem_id']);
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    public function getAddress_point()
    {
        return $this->hasOne(AddressPoint::className(), ['id' => 'address_point_id']);
    }

}
