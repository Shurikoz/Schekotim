<?php

namespace backend\models;

use yii\db\ActiveRecord;


class ReviewForm extends ActiveRecord
{

    public static function tableName()
    {
        return 'reviews';
    }

    public function rules()
    {
        return [
            [['name', 'email', 'mobile', 'created_at', 'rating', 'text'], 'required'],
            [['created_at'], 'safe'],
            [['rating', 'active'], 'integer'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'email' => 'Email',
            'mobile' => 'Телефон',
            'rating' => 'Оценка',
            'active' => 'Публикация',
            'text' => 'Отзыв',
        ];
    }

}
