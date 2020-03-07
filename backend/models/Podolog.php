<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "podolog".
 *
 * @property int $id
 * @property int $address_point
 * @property string $name
 */
class Podolog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'podolog';
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

    public function getVisit()
    {
        return $this->hasMany(Visit::className(), ['podolog_id' => 'id']);
    }

}
