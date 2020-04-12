<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "card".
 *
 * @property int $id
 * @property int $user_id
 * @property int $number
 * @property string $city
 * @property string $address_point
 * @property string $name
 * @property string $surname
 * @property string $middle_name
 * @property string $birthday
 * @property string $created_at
 * @property string $phone
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
            ['phone', 'match', 'pattern' => '/^\+7\s\([0-9]{3}\)\s[0-9]{3}\s[0-9]{2}\s[0-9]{2}$/', 'message' => 'Неправильно указан номер' ],
            [['user_id', 'number'], 'integer'],
            [['city', 'address_point', 'name', 'surname', 'middle_name', 'number', 'phone', 'user_id', 'birthday'], 'required'],
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
            'city' => 'Город',
            'address_point' => 'Точка',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'middle_name' => 'Отчество',
            'birthday' => 'День рождения',
            'created_at' => 'Дата создания',
            'phone' => 'Телефон',
        ];
    }

    public function getVisit()
    {
        return $this->hasMany(Visit::className(), ['card_number' => 'number']);
    }

}
