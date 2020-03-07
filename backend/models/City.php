<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $id
 * @property string $name
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public function getAddressPoint()
    {
        return $this->hasMany(AddressPoint::className(), ['city_id' => 'id']);
    }

    public function getVisit()
    {
        return $this->hasOne(Visit::className(), ['city_id' => 'id']);
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['city' => 'id']);
    }

}
