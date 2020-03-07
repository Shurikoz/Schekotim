<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "address_point".
 *
 * @property int $id
 * @property int $city_id
 * @property string $address_point
 */
class AddressPoint extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'address_point';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'address_point'], 'required'],
            [['city_id'], 'integer'],
            [['address_point'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'address_point' => 'Address Point',
        ];
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    public function getVisit()
    {
        return $this->hasMany(Visit::className(), ['address_point' => 'id']);
    }

}