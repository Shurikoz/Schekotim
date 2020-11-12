<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $image
 * @property string $created_at
 * @property int $status
 * @property string $tags
 * @property string $count_view
 */
class Article extends \yii\db\ActiveRecord
{
    public $mainPhoto;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'content'], 'required'],
            [['description', 'content', 'count_view'], 'string'],
            [['status', 'status'], 'integer'],
            [['image', 'created_at', 'image', 'tags'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['mainPhoto'], 'image',
                'extensions' => ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'PNG'],
                'checkExtensionByMimeType' => true,
            ],
        ];
    }
    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $this->mainPhoto = UploadedFile::getInstance($this, 'mainPhoto');
        return parent::beforeValidate();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'description' => 'Краткое описание',
            'content' => 'Контент',
            'image' => 'Основное изображение',
            'created_at' => 'Дата создания',
            'status' => 'Опубликовать',
            'tags' => 'Теги',
            'mainPhoto' => 'Основное фото',
            'count_view' => 'Просмотры'
        ];
    }

    /**
     * @param $articleId
     * @return bool
     */
    public function uploadPhoto($id, $model)
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

            //очистим папку от старых изображений
            foreach (glob($path . $dir . '/main/*') as $file) {
                unlink($file);
            }

            $fileName = $this->randomFileName($this->mainPhoto->extension);
            $img = $path . $dir . '/main/' . $fileName;

            $this->mainPhoto->saveAs($img);

            //сохраним в бд
            $model->image = $dir . '/main/' . $fileName;
            $model->save(false);
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
     * Счетчик просмотров поста с записью id в сессию
     * данный подход исключает накрутку просмотров за сессию
     * @return bool
     */
    public function countViewArticle()
    {
        $session = Yii::$app->session;
        // Если в сессии отсутствуют данные,
        // создаём, увеличиваем счетчик, и записываем в бд
        if (!isset($session['article_view'])) {
            $session->set('article_view', [$this->id]);
            $this->updateCounters(['count_view' => 1]);
            // Если в сессии уже есть данные то проверяем засчитывался ли данный пост
            // если нет то увеличиваем счетчик, записываем в бд и сохраняем в сессию просмотр этого поста
        } else {
            if (!ArrayHelper::isIn($this->id, $session['article_view'])) {
                $array = $session['article_view'];
                array_push($array, $this->id);
                $session->remove('article_view');
                $session->set('article_view', $array);
                $this->updateCounters(['count_view' => 1]);
            }
        }
        return true;
    }

    public function getArticleImage()
    {
        return $this->hasMany(ArticleImage::className(), ['article_id' => 'id']);
    }

}
