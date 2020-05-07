<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "visit".
 *
 * @property int $id
 * @property string $podolog_id
 * @property int $card_number
 * @property string $city
 * @property string $address_point
 * @property string $problem_id
 * @property string $anamnes
 * @property string $manipulation
 * @property string $recommendation
 * @property string $next_visit_from
 * @property string $next_visit_by
 * @property string $visit_time
 * @property string $visit_date
 * @property string $has_come
 * @property string $resolve
 * @property string $used_photo
 * @property string $description
 * @property string $timestamp
 * @property string $edit
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
            [['podolog_id', 'card_number', 'used_photo', 'edit'], 'integer'],
            [['anamnes', 'manipulation', 'recommendation', 'description'], 'string'],
            [['address_point', 'city', 'resolve', 'has_come', 'timestamp', 'next_visit_from', 'next_visit_by', 'visit_date', 'visit_time'], 'safe'],
            ['problem_id', 'integer', 'min' => '1', 'tooSmall' => 'Проблема не выбрана!'],
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
            'city' => 'City ID',
            'address_point' => 'Точка',
            'podolog_id' => 'Подолог',
            'anamnes' => 'Анамнез',
            'manipulation' => 'Манипуляции',
            'recommendation' => 'Рекомендации',
            'next_visit_from' => 'Следующий визит с',
            'next_visit_by' => 'Следующий визит по',
            'visit_time' => 'Время посещения',
            'visit_date' => 'Дата посещения',
            'has_come' => 'Пациент пришел',
            'resolve' => 'Решена',
            'used_photo' => '',
            'description' => 'Комментарий',
            'edit' => 'Редактирование'
        ];
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $next_visit_from = isset($_POST["Visit"]["next_visit_from"]) ? $_POST["Visit"]["next_visit_from"] : null;
            $next_visit_by = isset($_POST["Visit"]["next_visit_by"]) ? $_POST["Visit"]["next_visit_by"] : null;
            $this->next_visit_from = $next_visit_from == null ? null : date("Y-m-d", strtotime($next_visit_from));
            $this->next_visit_by = $next_visit_by == null ? null : date("Y-m-d", strtotime($next_visit_by));
            return true;
        }
        return false;
    }

    public function getCard()
    {
        return $this->hasOne(Card::className(), ['id' => 'card_number']);
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

}
