<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use himiklab\yii2\recaptcha\ReCaptchaValidator;

class ReviewForm extends ActiveRecord
{
    public $reCaptcha;

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
            [['text'], 'string', 'max' => 1000],
            ['image', 'image', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 5242880],
//            ['verifyCode', 'captcha', 'captchaAction' => '/site/captcha'],
            [['reCaptcha'], ReCaptchaValidator::className(), 'secret' => '6Lf4qbgUAAAAAFq4d7jUewzRc7Qp6z9QrRJK7lW2']


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
            'reCaptcha' => 'Код подтверждения',
            'image' => 'Прикрепить фото'
        ];
    }

    /**
     * {@inheritdoc}
     * Оповещение о новом отзыве на email администратора
     */

    public function sendNotificationReview($email1, $email2, $reviewName, $reviewEmail, $reviewRating, $reviewBody, $reviewMobile, $linkPublic, $linkEdit, $filename)
    {
        $image = Yii::getAlias('@frontend/web') . '/images/reviews/' . $filename;

//        Если приложено фото, то отправляем его в письме
        if ($filename){
            return Yii::$app->mailer->compose('mailNotificationReview', [
                'reviewName' => $reviewName,
                'reviewEmail' => $reviewEmail,
                'reviewRating' => $reviewRating,
                'reviewBody' => $reviewBody,
                'reviewMobile' => $reviewMobile,
                'linkPublic' => $linkPublic,
                'linkEdit' => $linkEdit,
                'filename' => $filename,
                'image' => true
            ])
                ->setTo([
                    $email1,
                    $email2
                ])
                ->setFrom(['marketing@schekotim.ru' => 'Добавлен новый отзыв'])
                ->setSubject('Новый отзыв на сайте!')
                ->attach($image)
                ->send();
        } else {
            return Yii::$app->mailer->compose('mailNotificationReview', [
                'reviewName' => $reviewName,
                'reviewEmail' => $reviewEmail,
                'reviewRating' => $reviewRating,
                'reviewBody' => $reviewBody,
                'reviewMobile' => $reviewMobile,
                'linkPublic' => $linkPublic,
                'linkEdit' => $linkEdit,
                'image' => false
            ])
                ->setTo([
                    $email1,
                    $email2
                ])
                ->setFrom(['marketing@schekotim.ru' => 'Добавлен новый отзыв'])
                ->setSubject('Новый отзыв на сайте!')
                ->send();
        }

    }


    /**
     * {@inheritdoc}
     * Оповещение о отставленном "Положительном" или "Нейтральном" отзыве на email клиента
     */

    public function sendReviewClientPositiveNeutral($reviewName, $reviewEmail, $reviewRating, $reviewBody, $reviewMobile, $filename)
    {
        $image = Yii::getAlias('@frontend/web') . '/images/reviews/' . $filename;

//        Если приложено фото, то отправляем его в письме
        if ($filename){
            return Yii::$app->mailer->compose('mailReviewClientPositiveNeutral', [
                'reviewName' => $reviewName,
                'reviewEmail' => $reviewEmail,
                'reviewRating' => $reviewRating,
                'reviewBody' => $reviewBody,
                'reviewMobile' => $reviewMobile,
                'filename' => $filename,
                'image' => true
            ])
                ->setFrom(['marketing@schekotim.ru' => 'Спасибо за оставленнный отзыв!'])
                ->setTo($reviewEmail)
                ->setSubject('Вы оставили отзыв на сайте "Щекотливая тема"')
                ->attach($image)
                ->send();
        } else {
            return Yii::$app->mailer->compose('mailReviewClientPositiveNeutral', [
                'reviewName' => $reviewName,
                'reviewEmail' => $reviewEmail,
                'reviewRating' => $reviewRating,
                'reviewBody' => $reviewBody,
                'reviewMobile' => $reviewMobile,
                'image' => false
            ])
                ->setFrom(['marketing@schekotim.ru' => 'Спасибо за оставленнный отзыв!'])
                ->setTo($reviewEmail)
                ->setSubject('Вы оставили отзыв на сайте "Щекотливая тема"')
                ->send();
        }

    }

    /**
     * {@inheritdoc}
     * Оповещение о отставленном "Негативном" отзыве на email клиента
     */

    public function sendReviewClientNegative($reviewName, $reviewEmail, $reviewRating, $reviewBody, $reviewMobile, $filename)
    {
        $image = Yii::getAlias('@frontend/web') . '/images/reviews/' . $filename;

//        Если приложено фото, то отправляем его в письме
        if ($filename){
        return Yii::$app->mailer->compose('mailReviewClientNegative', [
            'reviewName' => $reviewName,
            'reviewEmail' => $reviewEmail,
            'reviewRating' => $reviewRating,
            'reviewBody' => $reviewBody,
            'reviewMobile' => $reviewMobile,
            'filename' => $filename,
            'image' => true
        ])
            ->setTo($reviewEmail)
            ->setFrom(['marketing@schekotim.ru' => 'Спасибо за оставленнный отзыв!'])
            ->setSubject('Вы оставили отзыв на сайте "Щекотливая тема"')
            ->attach($image)
            ->send();
    } else {
            return Yii::$app->mailer->compose('mailReviewClientNegative', [
                'reviewName' => $reviewName,
                'reviewEmail' => $reviewEmail,
                'reviewRating' => $reviewRating,
                'reviewBody' => $reviewBody,
                'reviewMobile' => $reviewMobile,
                'image' => false
            ])
                ->setTo($reviewEmail)
                ->setFrom(['marketing@schekotim.ru' => 'Спасибо за оставленнный отзыв!'])
                ->setSubject('Вы оставили отзыв на сайте "Щекотливая тема"')
                ->send();
        }
    }




}