<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "problem".
 *
 * @property int $id
 * @property string $name
 * @property string $anamnes
 * @property string $manipulation
 * @property string $recommendation
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
            [['anamnes', 'manipulation', 'recommendation'], 'safe'],
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
        ];
    }

    public function getVisit()
    {
        return $this->hasMany(Visit::className(), ['problem_id' => 'id']);
    }


}
