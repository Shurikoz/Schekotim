<?php

namespace backend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "specialist".
 *
 * @property int $id
 * @property int $address_point
 * @property string $name
 * @property string $profession
 */
class Specialist extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'specialist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'profession'], 'string'],
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

    public function profession($specialist) {
        switch ($specialist) {
            case 'podolog':
                return "Подолог";
            case 'dermatolog':
                return "Дерматолог";
        }
        return '-';
    }

    public function getVisit()
    {
        return $this->hasMany(Visit::className(), ['specialist_id' => 'id']);
    }


    public function getAddressPoint()
    {
        return $this->hasOne(AddressPoint::className(), ['id' => 'address_point_id']);
    }

}
