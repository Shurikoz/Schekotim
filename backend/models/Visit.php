<?php

namespace backend\models;

use Yii;
/**
 * This is the model class for table "visit".
 *
 * @property int $id
 * @property string $podolog_id
 * @property int $card_number
 * @property string $city_id
 * @property string $address_point_id
 * @property string $problem_id
 * @property string $anamnes
 * @property string $manipulation
 * @property string $recommendation
 * @property string $next_visit_from
 * @property string $next_visit_by
 * @property string $planned
 * @property string $visit_time
 * @property string $visit_date
 * @property string $has_come
 * @property string $resolve
 * @property string $used_photo
 * @property string $description
 * @property string $timestamp
 * @property string $edit
 * @property string $dermatolog
 * @property string $immunolog
 * @property string $ortoped
 * @property string $hirurg
 *
 */




class Visit extends \yii\db\ActiveRecord
{
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
            [['card_number', 'used_photo', 'edit', 'dermatolog', 'immunolog', 'ortoped', 'hirurg', 'planned'], 'integer'],
            [['anamnes', 'manipulation', 'recommendation', 'description'], 'string'],
            [['address_point_id', 'city_id', 'resolve', 'has_come', 'timestamp', 'next_visit_from', 'next_visit_by', 'visit_date', 'visit_time'], 'safe'],
            ['problem_id', 'integer', 'min' => '1', 'tooSmall' => 'Проблема не выбрана!'],
            ['podolog_id', 'integer', 'min' => '1', 'tooSmall' => 'Подолог не выбран!'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер посещения',
            'user_id' => 'ID пользователя',
            'card_number' => 'Номер карты',
            'city_id' => 'City ID',
            'address_point_id' => 'Точка',
            'podolog_id' => 'Подолог',
            'anamnes' => 'Анамнез',
            'manipulation' => 'Манипуляции',
            'recommendation' => 'Рекомендации',
            'dermatolog' => 'Дерматолог',
            'immunolog' => 'Иммунолог',
            'ortoped' => 'Ортопед',
            'hirurg' => 'Хирург',
            'next_visit_from' => 'Следующий визит с',
            'next_visit_by' => 'Следующий визит по',
            'visit_time' => 'Время посещения',
            'visit_date' => 'Дата посещения',
            'has_come' => 'Пациент пришел',
            'resolve' => 'Проблема решена',
            'used_photo' => '',
            'description' => 'Комментарий',
            'edit' => 'Редактирование',
            'planned' => 'Запланированное посещение'
        ];
    }

//    public function beforeSave($insert)
//    {
//        if (parent::beforeSave($insert)) {
//            $next_visit_from = isset($_POST["Visit"]["next_visit_from"]) ? $_POST["Visit"]["next_visit_from"] : null;
//            $next_visit_by = isset($_POST["Visit"]["next_visit_by"]) ? $_POST["Visit"]["next_visit_by"] : null;
//            $this->next_visit_from = $next_visit_from == null ? null : date("Y-m-d", strtotime($next_visit_from));
//            $this->next_visit_by = $next_visit_by == null ? null : date("Y-m-d", strtotime($next_visit_by));
//            return true;
//        }
//        return false;
//    }

    public function checkVisit($visits)
    {
        foreach ($visits as $visit) {
            if ($visit->next_visit_from != null && $visit->next_visit_by != null){
                if (strtotime($visit->next_visit_by) < time()) {
                    $visit->planned = 0;
                    $visit->has_come = 2;
                    $visit->visit_date = null;
                    $visit->visit_time = null;
                    $visit->save();
                }
            }
        }
    }

    /**
     * @param $insert
     * @param $changedAttributes
     * @return bool
     */
    public function afterSave($insert, $changedAttributes)
    {
        $operation = $insert ? 'create' : 'update';
//            var_dump($changedAttributes);die;
            $log = new Logs();
            $log->time = time();
            $log->operation = $operation;
            $log->text = json_encode($this->attributes, JSON_UNESCAPED_UNICODE);
            $log->user_id = Yii::$app->user->identity->getId();
            $log->save(false);
        parent::afterSave($insert, $changedAttributes);
    }

    public function getCard()
    {
        return $this->hasOne(Card::className(), ['number' => 'card_number']);
    }

    public function getPhoto()
    {
        return $this->hasMany(Photo::className(), ['visit_id' => 'id']);
    }

    public function getPodolog()
    {
        return $this->hasOne(Podolog::className(), ['id' => 'podolog_id']);
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
