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
            [['problem_id', 'address_point_id', 'podolog_id', 'city_id', 'card_number', 'used_photo', 'edit'], 'integer'],
            [['anamnes', 'manipulation', 'recommendation', 'description'], 'string'],
            [['timestamp', 'next_visit_from', 'next_visit_by', 'visit_date', 'visit_time'], 'safe'],
            [['resolve', 'has_come'], 'string', 'max' => 255],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID пользователя',
            'card_number' => 'Card ID',
            'city_id' => 'City ID',
            'address_point_id' => 'Точка',
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
            'used_photo' => 'Фото использовано',
            'description' => 'Комментарий',
            'edit' => 'Редактирование'
        ];
    }


    public function getCard()
    {
        return $this->hasOne(Card::className(), ['id' => 'card_number']);
    }

    public function getPhoto()
    {
        return $this->hasMany(Photo::className(), ['visit_id' => 'id']);
    }

    public function getAddressPoint()
    {
        return $this->hasOne(AddressPoint::className(), ['id' => 'address_point_id']);
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
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
