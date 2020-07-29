<?php

namespace backend\models;

use common\models\User;
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
        return $this->hasMany(Visit::className(), ['city_id' => 'id']);
    }

    public function getCard()
    {
        return $this->hasMany(Card::className(), ['city_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['city_id' => 'id']);
    }

    public function getLogs()
    {
        return $this->hasMany(Logs::className(), ['city_id' => 'id']);
    }

}
