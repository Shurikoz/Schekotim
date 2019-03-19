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
     * Оповещение о новом отзыве на email администратора
     */

    public function sendNotificationReview($email, $reviewName, $reviewEmail, $reviewRating, $reviewBody, $reviewMobile, $linkPublic, $linkEdit)
    {
        return Yii::$app->mailer->compose('mailNotificationReview', [
            'reviewName' => $reviewName,
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
            ->send();
    }


    /**
     * {@inheritdoc}
     * Оповещение о отставленном "Положительном" или "Нейтральном" отзыве на email клиента
     */

    public function sendReviewClientPositiveNeutral($reviewName, $reviewEmail, $reviewRating, $reviewBody, $reviewMobile)
    {
        return Yii::$app->mailer->compose('mailReviewClientPositiveNeutral', [
            'reviewName' => $reviewName,
            'reviewEmail' => $reviewEmail,
            'reviewRating' => $reviewRating,
            'reviewBody' => $reviewBody,
            'reviewMobile' => $reviewMobile,
        ])
            ->setFrom(['marketing@schekotim.ru' => 'Спасибо за оставленнный отзыв!'])
            ->setTo($reviewEmail)
            ->setSubject('Вы оставили отзыв на сайте "Щекотливая тема"')
            ->send();
    }

    /**
     * {@inheritdoc}
     * Оповещение о отставленном "Негативном" отзыве на email клиента
     */

    public function sendReviewClientNegative($reviewName, $reviewEmail, $reviewRating, $reviewBody, $reviewMobile)
    {
        return Yii::$app->mailer->compose('mailReviewClientNegative', [
            'reviewName' => $reviewName,
            'reviewEmail' => $reviewEmail,
            'reviewRating' => $reviewRating,
            'reviewBody' => $reviewBody,
            'reviewMobile' => $reviewMobile,
        ])
            ->setTo($reviewEmail)
            ->setFrom(['marketing@schekotim.ru' => 'Спасибо за оставленнный отзыв!'])
            ->setSubject('Вы оставили отзыв на сайте "Щекотливая тема"')
            ->send();
    }


}