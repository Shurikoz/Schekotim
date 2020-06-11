<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "price".
 *
 * @property string $text
 */
class Price extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'text' => 'Text',
        ];
    }
}
