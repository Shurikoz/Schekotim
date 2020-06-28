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
 * @property string $representative
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
            ['phone', 'match', 'pattern' => '/^\+7\s\([0-9]{3}\)\s[0-9]{3}\s[0-9]{2}\s[0-9]{2}$/', 'message' => 'Неправильно указан номер'],
            [['name', 'surname', 'middle_name'], 'match', 'pattern' => '/^([а-яА-ЯЁё]+)$/u', 'message' => 'Разрешено вводить только кириллические символы'],
            [['user_id', 'number'], 'integer'],
            [['city_id', 'address_point_id', 'name', 'surname', 'middle_name', 'number', 'phone', 'user_id', 'birthday'], 'required'],
            [['created_at', 'representative'], 'safe'],
            [['name', 'surname', 'middle_name'], 'string', 'max' => 255],
            [['number'], 'unique'],
        ];
    }
//
//    public function beforeSave($insert)
//    {
//        if (parent::beforeSave($insert)) {
//            $this->birthday = isset($_POST["Card"]["birthday"]) ? $_POST["Card"]["birthday"] : null;
//            return true;
//        }
//        return false;
//    }

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
            'phone' => 'Телефон',
            'representative' => 'Представитель клиента'
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

    public function getAddress_point()
    {
        return $this->hasOne(AddressPoint::className(), ['id' => 'address_point_id']);
    }

}
