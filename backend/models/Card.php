<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "card".
 *
 * @property int $id
 * @property int $user_id
 * @property int $number
 * @property string $city_id
 * @property string $address_point_id
 * @property string $name
 * @property string $surname
 * @property string $middle_name
 * @property string $birthday
 * @property string $created_at
 */
class Card extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id', 'address_point_id', 'user_id', 'number'], 'integer'],
            [['number'], 'required'],
            [['birthday', 'created_at'], 'safe'],
            [['name', 'surname', 'middle_name'], 'string', 'max' => 255],
            [['number'], 'unique'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'number' => 'Карта №',
            'city_id' => 'Город',
            'address_point_id' => 'Точка',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'middle_name' => 'Отчество',
            'birthday' => 'День рождения',
            'created_at' => 'Дата создания',
        ];
    }

    public function getVisit()
    {
        return $this->hasMany(Visit::className(), ['card_number' => 'number']);
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    public function getAddressPoint()
    {
        return $this->hasOne(AddressPoint::className(), ['id' => 'address_point_id']);
    }


}
