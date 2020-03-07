<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "visit".
 *
 * @property int $id
 * @property int $card_number
 * @property string $city_id
 * @property string $address_point
 * @property string $podolog
 * @property string $reason
 * @property string $manipulation
 * @property string $recommendation
 * @property string $next_visit_from
 * @property string $next_visit_by
 * @property string $visit_time
 * @property string $has_come
 * @property string $used_photo
 * @property string $description
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
            [['city_id', 'card_number', 'used_photo'], 'integer'],
            [['reason', 'manipulation', 'recommendation', 'description'], 'string'],
            [['podolog_id', 'next_visit_from', 'next_visit_by', 'visit_time'], 'safe'],
            [['address_point', 'has_come'], 'string', 'max' => 255],
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
            'address_point' => 'Точка',
            'podolog_id' => 'Подолог',
            'reason' => 'Причина обращения',
            'manipulation' => 'Манипуляции',
            'recommendation' => 'Рекомендации',
            'next_visit_from' => 'Следующий визит с',
            'next_visit_by' => 'Следующий визит по',
            'visit_time' => 'Время',
            'has_come' => 'Посещение',
            'used_photo' => 'Фото использовано',
            'description' => 'Комментарий',
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
        return $this->hasOne(AddressPoint::className(), ['id' => 'address_point']);
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    public function getPodolog()
    {
        return $this->hasOne(Podolog::className(), ['id' => 'podolog_id']);
    }

}
