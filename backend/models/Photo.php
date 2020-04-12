<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\imagine\Image;

/**
 * This is the model class for table "photo".
 *
 * @property int $id
 * @property int $visit_id
 * @property string $url
 * @property string $thumbnail
 * @property string $files
 */
class Photo extends ActiveRecord
{

    public $before;
    public $after;


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
            [['visit_id'], 'integer'],
            [['url', 'thumbnail'], 'string'],

            [['before', 'after'], 'image',
                'extensions' => ['jpg', 'jpeg'],
                'checkExtensionByMimeType' => true,
                'maxFiles' => 5,
                'tooMany' => 'Вы можете загрузить не более 5 файлов'
            ]
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
            'addPhotoBefore' => 'Добавить фото',
            'addPhotoAfter' => 'Добавить фото',
            'before' => '',
            'after' => ''
        ];
    }

    /**
     * Функция добавления до 5 фото "До обработки" при создании нового посещения
     * @param $model
     * @param $visitId
     * @param $addressPoint
     * @param $cardNumber
     * @param $dateVisit
     * @return bool
     */
    public function uploadBefore($visitId, $addressPoint, $cardNumber, $dateVisit)
    {
        if ($this->validate()) {
            $dir = 'upload/photo/' . $visitId;
            $this->checkDir($visitId, $dir);

            foreach ($this->before as $file) {
                $fileName = $this->randomFileName($file->extension);
                $file->saveAs($dir . '/temp/' . $fileName);

                //изображение в папке temp
                $tempImage = Yii::getAlias($dir . '/temp/' . $fileName);

                //параметры текста для фото
                $text = '
    Точка: ' . $addressPoint . '
    Пациент: ' . $cardNumber . '
    Дата: ' . $dateVisit;

                $fontFile = Yii::getAlias('@webroot/fonts/Phenomena-Regular.otf');
                $start = [0, 0];
                $fontOptions = [
                    'size'  => 30,    // Размер шрифта
                    'color' => '0b9341', // цвет шрифта
                ];

                //параметры логотипа
                $watermark = Yii::getAlias('@webroot/images/logoImage.png');
                $size = getimagesize($tempImage); // Определяем размер картинки
                $imageWidth = $size[0]; // Ширина картинки
                $imageHeight = $size[1]; // Высота картинки
                $watermarkPositionLeft = $imageWidth - 386; // Новая позиция watermark по оси X (горизонтально)
                $watermarkPositionTop = $imageHeight - 113; // Новая позиция watermark по оси Y (вертикально)

                //создадим миниатюру
                $thumb = $dir . '/thumbBefore/' . $fileName;
                Image::thumbnail($tempImage, 120, 120)
                    ->save(Yii::getAlias($thumb), ['quality' => 100]);

                //наложим логотип
                Image::watermark($tempImage, $watermark, [$watermarkPositionLeft, $watermarkPositionTop])
                    ->save($tempImage, ['quality' => 100]);

                //наложим текст
                $url = $dir . '/before/' . $fileName;
                Image::text($tempImage, $text, $fontFile, $start, $fontOptions)
                    ->save(Yii::getAlias($url), ['quality' => 100]);

                //сохраним в бд
                $model = new Photo();
                $model->visit_id = $visitId;
                $model->url = '/' . $dir . '/before/' . $fileName;
                $model->thumbnail = '/' . $dir . '/thumbBefore/' . $fileName;
                $model->made = 'before';
                $model->save(false);
            }
            //очистим папку temp
            if (file_exists('upload/photo/' . $visitId . '/temp/')) {
                foreach (glob('upload/photo/' . $visitId . '/temp/*') as $file) {
                    unlink($file);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Функция добавления до 5 фото "После обработки" при создании нового посещения
     * @param $visitId
     * @param $addressPoint
     * @param $cardNumber
     * @param $dateVisit
     * @return bool
     */
    public function uploadAfter($visitId, $addressPoint, $cardNumber, $dateVisit)
    {
        if ($this->validate()) {
            $dir = 'upload/photo/' . $visitId;
            $this->checkDir($visitId, $dir);

            foreach ($this->after as $file) {
                $fileName = $this->randomFileName($file->extension);
                $file->saveAs($dir . '/temp/' . $fileName);

                //изображение в папке temp
                $tempImage = Yii::getAlias($dir . '/temp/' . $fileName);

                //параметры текста для фото
                $text = '
    Точка: ' . $addressPoint . '
    Пациент: ' . $cardNumber . '
    Дата: ' . $dateVisit;

                $fontFile = Yii::getAlias('@webroot/fonts/Phenomena-Regular.otf');
                $start = [0, 0];
                $fontOptions = [
                    'size'  => 30,    // Размер шрифта
                    'color' => '0b9341', // цвет шрифта
                ];

                //параметры логотипа
                $watermark = Yii::getAlias('@webroot/images/logoImage.png');
                $size = getimagesize($tempImage); // Определяем размер картинки
                $imageWidth = $size[0]; // Ширина картинки
                $imageHeight = $size[1]; // Высота картинки
                $watermarkPositionLeft = $imageWidth - 386; // Новая позиция watermark по оси X (горизонтально)
                $watermarkPositionTop = $imageHeight - 113; // Новая позиция watermark по оси Y (вертикально)

                //создадим миниатюру
                $thumb = $dir . '/thumbAfter/' . $fileName;
                Image::thumbnail($tempImage, 120, 120)
                    ->save(Yii::getAlias($thumb), ['quality' => 100]);

                //наложим логотип
                Image::watermark($tempImage, $watermark, [$watermarkPositionLeft, $watermarkPositionTop])
                    ->save($tempImage, ['quality' => 100]);

                //наложим текст
                $url = $dir . '/after/' . $fileName;
                Image::text($tempImage, $text, $fontFile, $start, $fontOptions)
                    ->save(Yii::getAlias($url), ['quality' => 100]);

                //сохраним в бд
                $model = new Photo();
                $model->visit_id = $visitId;
                $model->url = '/' . $dir . '/after/' . $fileName;
                $model->thumbnail = '/' . $dir . '/thumbAfter/' . $fileName;
                $model->made = 'after';
                $model->save(false);
            }
            //очистим папку temp
            if (file_exists('upload/photo/' . $visitId . '/temp/')) {
                foreach (glob('upload/photo/' . $visitId . '/temp/*') as $file) {
                    unlink($file);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    private function randomFileName($extension = false)
    {
        $extension = $extension ? '.' . $extension : '';
        do {
            $name = md5(microtime() . rand(0, 1000));
            $file = $name . $extension;
        } while (file_exists($file));
        return $file;
    }

    private function checkDir($visitId, $dir){
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
            mkdir($dir . '/temp', 0777, true);
            mkdir($dir . '/before', 0777, true);
            mkdir($dir . '/after', 0777, true);
            mkdir($dir . '/thumbBefore', 0777, true);
            mkdir($dir . '/thumbAfter', 0777, true);
        } elseif (!file_exists('upload/photo/' . $visitId . '/temp')){
            mkdir($dir . '/temp', 0777, true);
        } elseif (!file_exists('upload/photo/' . $visitId . '/after')){
            mkdir($dir . '/after', 0777, true);
        } elseif (!file_exists('upload/photo/' . $visitId . '/thumbAfter')){
            mkdir($dir . '/thumbAfter', 0777, true);
        }
    }

    public function getVisit()
    {
        return $this->hasOne(Visit::className(), ['id' => 'visit_id']);
    }

}
