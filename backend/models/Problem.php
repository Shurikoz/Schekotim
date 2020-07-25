<?php

namespace backend\models;

/**
 * This is the model class for table "problem".
 *
 * @property int $id
 * @property int $number
 * @property string $name
 * @property string $anamnes
 * @property string $manipulation
 * @property string $recommendation
 * @property string $diagnosis
 */

class Problem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'problem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
            [['number', 'anamnes', 'manipulation', 'recommendation', 'diagnosis'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Проблема',
            'anamnes' => 'Анамнез',
            'manipulation' => 'Манипуляции',
            'recommendation' => 'Рекомендации',
            'diagnosis' => 'Диагноз',
            'number' => 'Номер',
        ];
    }

    /**
     * @return int
     */
    public function count(){
        $model = Problem::find()->all();
        $count = count($model);
        return $count;
    }

    public function getVisit()
    {
        return $this->hasOne(Visit::className(), ['problem_id' => 'id']);
    }


}
