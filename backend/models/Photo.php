<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "photo_visit".
 *
 * @property int $id
 * @property int $visit_id
 * @property string $url
 * @property string $thumbnail
 * @property string $used
 */
class Photo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['visit_id', 'used'], 'integer'],
            [['url', 'thumbnail'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'visit_id' => 'Номер посещения',
            'url' => 'Фотография',
            'thumbnail' => 'Превью',
            'used' => 'Использовано',
        ];
    }


    public function getVisit()
    {
        return $this->hasOne(Visit::className(), ['id' => 'visit_id']);
    }



}
