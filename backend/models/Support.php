<?php

namespace backend\models;

use common\models\User;
use Yii;
/**
 * This is the model class for table "support".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property int $user_id
 * @property string|null $file_url
 * @property string $date
 * @property int $time
 * @property int $viewed
 * @property int $result
 */
class Support extends \yii\db\ActiveRecord
{

    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'support';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['title', 'text', 'file_url'], 'string'],
            [['title'], 'string', 'max' => 64],
            [['user_id', 'viewed', 'result'], 'integer'],
            [['date', 'user_id', 'date', 'time'], 'safe'],
            [['file'], 'image',
                'extensions' => ['png', 'jpg', 'jpeg'],
                'checkExtensionByMimeType' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Тема обращения',
            'text' => 'Описание проблемы',
            'user_id' => 'User ID',
            'file' => 'File',
            'date' => 'Date',
            'time' => 'Time',
            'viewed' => 'Viewed',
            'result' => 'Result',
        ];
    }


    /**
     * @param $id
     * @return bool
     */
    public function upload($model)
    {
        if ($this->validate()) {
            $dir = 'upload/support/' . $model->id;
            $this->checkDir($dir);
            $this->file->saveAs($dir . '/' . $this->file->baseName . '.' . $this->file->extension);
            $model->file_url = '/' . $dir . '/' . $this->file->baseName . '.' . $this->file->extension;
            $model->save(false);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $dir
     */
    private function checkDir($dir){
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @param $title
     * @param $text
     * @return bool whether the email was send
     */
    public function sendEmail($title, $text)
    {
        return Yii::$app->mailer
            ->compose(
                ['html' => 'supportNotification-html', 'text' => 'supportNotification-text'],
                ['title' => $title, 'text' => $text,]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setTo(Yii::$app->params['feedbackEmail'])
            ->setSubject('Запрос службы поддержки')
            ->send();
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


}
