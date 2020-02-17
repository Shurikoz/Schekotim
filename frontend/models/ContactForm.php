<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $reCaptcha;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
//            ['verifyCode', 'captcha'],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => '6Lf4qbgUAAAAAFq4d7jUewzRc7Qp6z9QrRJK7lW2']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'subject' => 'Тема',
            'body' => 'Сообщение',
            'reCaptcha' => 'Код подтверждения',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose('mailContactForm', [
            'name' => $this->name,
            'email' => $this->email,
            'body' => $this->body
        ])
            ->setFrom([Yii::$app->params['adminEmail'] => 'Письмо с сайта'])
            ->setTo($email)
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}
