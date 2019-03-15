<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class ReviewForm extends ActiveRecord
{
    public $verifyCode;

    public static function tableName()
    {
        return 'reviews';
    }

    public function rules()
    {
        return [
            [['name', 'email', 'mobile', 'rating', 'text'], 'required'],
//            [['name', 'email', 'mobile', 'rating', 'text'], 'safe'],
            [['name', 'email'], 'trim'],
            ['email', 'email'],
            [['name'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 20],
            [['text'],'string', 'max' => 1000],
            ['verifyCode', 'captcha','captchaAction' => '/site/captcha'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'email' => 'Email',
            'mobile' => 'Телефон',
            'rating' => 'Оценка',
            'text' => 'Отзыв',
            'verifyCode' => 'Код подтверждения',
        ];
    }

    /**
     * {@inheritdoc}
     * Оповещение о новом отзывена email
     */
//    public function sendNotificationReview($email, $linkPublic, $linkEdit)
//    {
//        return Yii::$app->mailer->compose('mailNotificationReview', ['linkPublic' => $linkPublic, 'linkEdit' => $linkEdit])
//            ->setTo($email)
//            ->setFrom(['test@test.ru' => 'Письмо с сайта'])
//            ->setSubject('Тема сообщения')
//            ->setTextBody($this->body)
//            ->send();
//    }

    public function sendNotificationReview($email, $reviewEmail, $reviewRating, $reviewBody, $reviewMobile, $linkPublic, $linkEdit)
    {
        return Yii::$app->mailer->compose('mailNotificationReview', [
            'reviewEmail' => $reviewEmail,
            'reviewRating' => $reviewRating,
            'reviewBody' => $reviewBody,
            'reviewMobile' => $reviewMobile,
            'linkPublic' => $linkPublic,
            'linkEdit' => $linkEdit,
        ])
            ->setTo($email)
            ->setFrom(['marketing@schekotim.ru' => 'Добавлен новый отзыв'])
            ->setSubject('Новый отзыв на сайте!')
//            ->setTextBody('Текст сообщения')
            ->send();
    }

}