<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "registry".
 *
 * @property int $id
 * @property int $number
 * @property int $date
 * @property string $name
 * @property string $course
 */
class Registry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registry';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number', 'date', 'name', 'course'], 'required'],
            [['number'], 'integer'],
            [['name', 'course'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Номер',
            'date' => 'Дата',
            'name' => 'ФИО',
            'course' => 'Курс',
        ];
    }
}
