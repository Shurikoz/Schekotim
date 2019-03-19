<?php

namespace backend\models;

use yii\db\ActiveRecord;
use yii;

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

    /**
     * {@inheritdoc}
     * Оповещение о публикации отзыва на email клиента
     */

    public function sendReviewClientPublic($reviewName, $reviewEmail, $reviewRating, $reviewBody, $reviewMobile)
    {
        return Yii::$app->mailer->compose('mailReviewClientPublic', [
            'reviewName' => $reviewName,
            'reviewEmail' => $reviewEmail,
            'reviewRating' => $reviewRating,
            'reviewBody' => $reviewBody,
            'reviewMobile' => $reviewMobile,
        ])
            ->setFrom(['marketing@schekotim.ru' => 'Спасибо за оставленнный отзыв!'])
            ->setTo($reviewEmail)
            ->setSubject('Ваш отзыв опубликован!')
            ->send();
    }

}
