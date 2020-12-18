<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

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
 * @property string $profession
 * @property string $orthopedic_features
 */
class Card extends ActiveRecord
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
            [['name', 'surname', 'middle_name'], 'match', 'pattern' => '/^([а-яА-ЯЁё\-\s]+)$/u', 'message' => 'Разрешено вводить только кириллические символы, пробелы и знак "-"'],
            [['user_id', 'number'], 'integer'],
            [['city_id', 'address_point_id', 'name', 'surname', 'middle_name', 'number', 'phone', 'user_id', 'birthday'], 'required'],
            [['created_at', 'representative', 'profession', 'orthopedic_features'], 'safe'],
            [['name', 'surname', 'middle_name'], 'string', 'max' => 255],
            [['number'], 'unique'],
            [['birthday'], 'match', 'pattern' => '/^\d{2}[\,\.]\d{2}[\,\.]\d{4}$/', 'message' => 'Укажите дату в формате дд.мм.гггг'],

        ];
    }


    /**
     * @param $insert
     * @param $changedAttributes
     * @return bool
     */
    public function afterSave($insert, $changedAttributes)
    {
        $operation = $insert ? 'create' : 'update';
        $log = new Logs();
        $log->time = time();
        $log->operation = $operation;
        $log->changes = json_encode($this->attributes, JSON_UNESCAPED_UNICODE);
        $log->user_id = Yii::$app->user->identity->getId();
        $log->city_id = Yii::$app->user->identity->city_id;
        $log->address_point_id = Yii::$app->user->identity->address_point_id;
        $log->object = 'card';
        $log->object_id = $this->id;
        $log->save(false);
        parent::afterSave($insert, $changedAttributes);
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
            'phone' => 'Телефон',
            'representative' => 'Представитель клиента',
            'profession' => 'Профессия',
            'orthopedic_features' => 'Ортопедические особенности'
        ];
    }

    public function getFullName() {
        return $this->name . ' ' . $this->middle_name . ' ' . $this->surname;
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
