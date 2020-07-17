<?php

namespace backend\models;
use Yii;

/**
 * This is the model class for table "visit".
 *
 * @property int $id
 * @property int $number
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
            [['card_number', 'used_photo', 'edit', 'dermatolog', 'immunolog', 'ortoped', 'hirurg', 'planned', 'visit_date', 'number', 'has_second_visit', 'not_in_time'], 'integer'],
            [['anamnes', 'manipulation', 'recommendation', 'description'], 'string'],
            [['address_point_id', 'city_id', 'resolve', 'has_come', 'timestamp', 'next_visit_from', 'next_visit_by', 'call_time'], 'safe'],
            ['problem_id', 'integer', 'min' => '1', 'tooSmall' => 'Проблема не выбрана!'],
            ['podolog_id', 'integer', 'min' => '1', 'tooSmall' => 'Подолог не выбран!'],
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
            'visit_date' => 'Дата посещения',
            'has_come' => 'Пациент пришел',
            'resolve' => 'Проблема решена',
            'used_photo' => '',
            'description' => 'Комментарий',
            'edit' => 'Редактирование',
            'planned' => 'Запланированное посещение',
            'comment' => 'Коментарий'
        ];
    }

    /**
     * @param $insert
     * @param $changedAttributes
     * @return bool
     */
    public function afterSave($insert, $changedAttributes)
    {
//        $podolog = Podolog::find()->where(['id' => $this->attributes['podolog_id']])->one();
        $operation = $insert ? 'create' : 'update';
        $log = new Logs();
        $log->time = time();
        $log->operation = $operation;
        $log->changes = json_encode($this->attributes, JSON_UNESCAPED_UNICODE);
//        $log->user_id = $podolog->user_id;
        $log->user_id = Yii::$app->user->identity->getId();
        $log->object = 'visit';
        $log->object_id = $this->id;
        $log->save(false);
        parent::afterSave($insert, $changedAttributes);
    }

    public function checkVisit($visits)
    {
        foreach ($visits as $visit) {
            //клиент пришел не вовремя
            if ($visit->next_visit_from != null && $visit->next_visit_by != null) {
                if (($visit->visit_date > $visit->next_visit_by) || ($visit->visit_date == null && $visit->next_visit_by + 60 * 60 * 11 < time())) {
                    $visit->not_in_time = 1;
                    $visit->save();
                }
            }

            if ($visit->next_visit_from != null && $visit->next_visit_by != null && $visit->next_visit_by + 60 * 60 * 11 < time() && $visit->has_come == 0 && $visit->recorded == 0 && $visit->has_come != 2) {
                $visit->has_come = 2; //клиент не пришел
                $visit->planned = 0;
                $visit->save();
            } elseif ($visit->recorded == 1 && $visit->visit_date != 0 && $visit->visit_date + 60 * 60 * 11 < time() && $visit->has_come == 0 && $visit->has_come != 2) {
                $visit->has_come = 2; //клиент не пришел
                $visit->planned = 0;
                $visit->save();
            }
        }

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
