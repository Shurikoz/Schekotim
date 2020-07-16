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
 * @property string $original
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
            [['url', 'thumbnail', 'original'], 'string'],

            [['before', 'after'], 'image',
                'extensions' => ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'PNG'],
                'checkExtensionByMimeType' => true,
                'maxFiles' => 5,
                'tooMany' => 'Вы можете загрузить не более 5 файлов'
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
     * @param $card
     * @param $cardNumber
     * @param $dateVisit
     * @return bool
     */
    public function uploadBefore($visitId, $cardNumber, $dateVisit)
    {
        if ($this->validate()) {
            $dir = 'upload/photo/' . $visitId;
            $this->checkDir($visitId, $dir);

            foreach ($this->before as $file) {
                $fileName = $this->randomFileName($file->extension);
                $file->saveAs($dir . '/temp/' . $fileName);

                //изображение в папке temp
                $tempImage = Yii::getAlias($dir . '/temp/' . $fileName);

                //сохраним оригинал
                copy($tempImage, $dir . '/originalBefore/' . $fileName);

                Image::autorotate($tempImage)->save($tempImage);

                Image::resize($tempImage, 1080, 1080)
                    ->save($tempImage, ['quality' => 100]);

                //создадим миниатюру
                $thumb = Yii::getAlias($dir . '/thumbBefore/' . $fileName);
                Image::thumbnail($tempImage, 120, 120)->save($thumb, ['quality' => 100]);

                //наложим логотип
                $this->setLogo($tempImage);

                //наложим текст
                $url = $dir . '/before/' . $fileName;
                $this->setText($tempImage, $url, $cardNumber, $dateVisit);

                //сохраним в бд
                $model = new Photo();
                $model->visit_id = $visitId;
                $model->url = '/' . $dir . '/before/' . $fileName;
                $model->thumbnail = '/' . $dir . '/thumbBefore/' . $fileName;
                $model->original = '/' . $dir . '/originalBefore/' . $fileName;
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
    public function uploadAfter($visitId, $cardNumber, $dateVisit)
    {
        if ($this->validate()) {
            $dir = 'upload/photo/' . $visitId;
            $this->checkDir($visitId, $dir);

            foreach ($this->after as $file) {
                $fileName = $this->randomFileName($file->extension);
                $file->saveAs($dir . '/temp/' . $fileName);

                //изображение в папке temp
                $tempImage = Yii::getAlias($dir . '/temp/' . $fileName);

                //сохраним оригинал
                copy($tempImage, $dir . '/originalAfter/' . $fileName);

                Image::autorotate($tempImage)->save($tempImage);

                Image::resize($tempImage, 1080, 1080)
                    ->save($tempImage, ['quality' => 100]);

                //создадим миниатюру
                $thumb = Yii::getAlias($dir . '/thumbAfter/' . $fileName);
                Image::thumbnail($tempImage, 120, 120)->save($thumb, ['quality' => 100]);

                //наложим логотип
                $this->setLogo($tempImage);

                //наложим текст
                $url = $dir . '/after/' . $fileName;
                $this->setText($tempImage, $url, $cardNumber, $dateVisit);

                //сохраним в бд
                $model = new Photo();
                $model->visit_id = $visitId;
                $model->url = '/' . $dir . '/after/' . $fileName;
                $model->thumbnail = '/' . $dir . '/thumbAfter/' . $fileName;
                $model->original = '/' . $dir . '/originalAfter/' . $fileName;
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

    /**
     * @param $tempImage
     * @return \Imagine\Image\ImageInterface
     */
    private function setLogo($tempImage)
    {
        $watermark = Yii::getAlias('@webroot/images/logoImage.png');
        $size = getimagesize($tempImage); // Определяем размер картинки
        $imageWidth = $size[0]; // Ширина картинки
        $imageHeight = $size[1]; // Высота картинки
        $watermarkPositionLeft = $imageWidth - 386; // Новая позиция watermark по оси X (горизонтально)
        $watermarkPositionTop = $imageHeight - 85; // Новая позиция watermark по оси Y (вертикально)
        //наложим логотип
        return Image::watermark($tempImage, $watermark, [$watermarkPositionLeft, $watermarkPositionTop])
            ->save($tempImage, ['quality' => 100]);
    }

    /**
     * @param $tempImage
     * @param $url
     * @param $cardNumber
     * @param $dateVisit
     * @return \Imagine\Image\ImageInterface
     */
    private function setText($tempImage, $url, $cardNumber, $dateVisit)
    {
        //параметры текста для фото
        $text = '#: ' . $cardNumber . ',  ' . $dateVisit;

        $fontFile = Yii::getAlias('@webroot/fonts/Phenomena-Regular.otf');
        $start = [40, 1020];
        $fontOptions = [
            'size'  => 34,    // Размер шрифта
            'color' => '0b9341', // цвет шрифта
        ];
        return Image::text($tempImage, $text, $fontFile, $start, $fontOptions)
            ->save(Yii::getAlias($url), ['quality' => 100]);
    }
    /**
     * @param $visitId
     * @param $dir
     */
    private function checkDir($visitId, $dir){
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
            mkdir($dir . '/temp', 0777, true);
            mkdir($dir . '/originalBefore', 0777, true);
            mkdir($dir . '/originalAfter', 0777, true);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisit()
    {
        return $this->hasOne(Visit::className(), ['id' => 'visit_id']);
    }

    public function getFilter()
    {
        return [
            '1' => 'Использованы',
            '0' => 'Не использованы',
        ];
    }

    /**
     * функции для подсчета количества фотографий в посещении до и после обработки
     * @param $photo
     * @return int
     */
    public static function countPhotoBefore($photo)
    {
        $before = 0;
        foreach ($photo as $item) {
            $item->made == 'before' ? $before++ : '';
        }
        return $before;
    }

    /**
     * функции для подсчета количества фотографий в посещении до и после обработки
     * @param $photo
     * @return int
     */
    public static function countPhotoAfter($photo)
    {
        $after = 0;
        foreach ($photo as $item) {
            $item->made == 'after' ? $after++ : '';
        }
        return $after;
    }

}
