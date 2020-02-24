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
 * @property string $doctor
 * @property string $name
 * @property string $surname
 * @property string $middle_name
 * @property string $birthday
 * @property string $description
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
            [['user_id', 'number'], 'integer'],
            [['number'], 'required'],
            [['doctor', 'description'], 'string'],
            [['birthday', 'created_at'], 'safe'],
            [['city', 'address_point', 'name', 'surname', 'middle_name'], 'string', 'max' => 255],
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
            'doctor' => 'Подолог',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'middle_name' => 'Отчество',
            'birthday' => 'День рождения',
            'description' => 'Коментарии',
            'created_at' => 'Дата создания',
        ];
    }

    public function getVisit()
    {
        return $this->hasMany(Visit::className(), ['visit_id' => 'id']);
    }


}
