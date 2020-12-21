<?php

namespace backend\models;

use Yii;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
 * This is the model class for table "stock".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string $image
 * @property string $endtime
 * @property string $public
 */
class Stock extends \yii\db\ActiveRecord
{
    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stock';
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $this->file = UploadedFile::getInstance($this, 'file');
        return parent::beforeValidate();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'text', 'public'], 'required'],
            [['text', 'image', 'public', 'endtime'], 'string'],
            [['title', 'endtime'], 'string', 'max' => 255],

            [['file'], 'image',
                'extensions' => ['jpg', 'jpeg', 'png'],
                'checkExtensionByMimeType' => true,
//                'skipOnEmpty' => false
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
            'title' => 'Заголовок',
            'text' => 'Текст',
            'image' => 'Изображение',
            'endtime' => 'Дата завершения',
            'public' => 'Опубликовать',
            'file' => 'Изображение *',
        ];
    }

    /**
     * @param $id
     * @param $model
     * @return bool
     */
    public function upload($id, $model)
    {
        if ($this->validate()) {
            $dir = 'upload/stock/' . $id;
            $path = Yii::getAlias('@frontend/web/');
            if (!file_exists($path . $dir)) {
                mkdir($path . $dir, 0777, true);
            }

            //очистим папку от старых изображений
            foreach (glob($path . $dir . '/*') as $file) {
                unlink($file);
            }

            $fileName = $this->randomFileName($this->file->extension);
            $img = $path . $dir . '/' . $fileName;
            $this->file->saveAs($img);

//            Image::thumbnail($img, 246, 246)
//                ->save(Yii::getAlias($img), ['quality' => 100]);

            //сохраним в бд
            $model->image = $dir . '/' . $fileName;
            $model->save(false);
            return true;
        } else {
            return false;
        }
    }

    public function checkPublicStock()
    {
        $today = date('Y-m-d');
        $model = Stock::find()->where(['<', 'endtime', $today])->all();
        foreach ($model as $item){
            $item->public = '0';
            $item->save();
        }

    }

    /**
     * @param bool $extension
     * @return string
     */
    private function randomFileName($extension = false)
    {
        $extension = $extension ? '.' . $extension : '';
        do {
            $name = md5(microtime() . rand(0, 1000));
            $file = $name . $extension;
        } while (file_exists($file));
        return $file;
    }
}
