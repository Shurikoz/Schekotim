<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "visit".
 *
 * @property int $id
 * @property int $card_number
 * @property string $city
 * @property string $address_point
 * @property string $reason
 * @property string $manipulation
 * @property string $recommendation
 * @property string $next_visit_from
 * @property string $next_visit_by
 * @property string $has_come
 * @property string $description
 */
class Visit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'visit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['card_number'], 'integer'],
            [['reason', 'manipulation', 'recommendation', 'description'], 'string'],
            [['next_visit_from', 'next_visit_by'], 'required'],
            [['next_visit_from', 'next_visit_by'], 'safe'],
            [['city', 'address_point', 'has_come'], 'string', 'max' => 255],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_number' => 'Card ID',
            'city' => 'Город',
            'address_point' => 'Точка',
            'reason' => 'Причина обращения',
            'manipulation' => 'Манипуляции',
            'recommendation' => 'Рекомендации',
            'next_visit_from' => 'Следующий визит с',
            'next_visit_by' => 'Следующий визит по',
            'has_come' => 'Посещение',
            'description' => 'Комментарий',
        ];
    }


    public function getCard()
    {
        return $this->hasOne(Card::className(), ['id' => 'card_number']);
    }

    public function getPhoto()
    {
        return $this->hasMany(Photo::className(), ['visit_id' => 'id']);
    }

}
