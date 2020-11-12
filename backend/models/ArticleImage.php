<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_image".
 *
 * @property int $id
 * @property int $article_id
 * @property string $url
 */
class ArticleImage extends \yii\db\ActiveRecord
{
    public $secondPhoto;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_id'], 'integer'],
            [['url'], 'string', 'max' => 255],
            [['secondPhoto'], 'image',
                'extensions' => ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'PNG'],
                'checkExtensionByMimeType' => true,
                'maxFiles' => 8,
                'tooMany' => 'Вы можете загрузить не более 8 файлов'
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
            'article_id' => 'Article ID',
            'url' => 'Url',
            'secondPhoto' => 'Дополнительные фото'
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
    public function uploadPhotos($id)
    {
        if ($this->validate()) {
            $dir = 'upload/articles/' . $id;
            $path = Yii::getAlias('@frontend/web/');
            if (!file_exists($path . $dir)) {
                mkdir($path . $dir, 0777, true);
                if (!file_exists($path . $dir . '/main')) {
                    mkdir($path . $dir . '/main', 0777, true);
                }
                if (!file_exists($path . $dir . '/gallery')) {
                    mkdir($path . $dir . '/gallery', 0777, true);
                }
            }

            foreach ($this->secondPhoto as $file) {
                $fileName = $this->randomFileName($file->extension);
                $file->saveAs($path . $dir . '/gallery/' . $fileName);

                $articleImage = new ArticleImage();
                $articleImage->article_id = $id;
                $articleImage->url = '/' . $dir . '/gallery/' . $fileName;
                $articleImage->save(false);
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

    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

}
