<?php

namespace backend\models;

use yii\db\ActiveRecord;
/**
 * This is the model class for table "gallery".
 *
 * @property int $id
 * @property string $filename
 * @property string $category
 * @property string $title
 */
class Gallery extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['filename'], 'image', 'extensions' => 'jpg, jpeg, png'],
            [['title'], 'string', 'max' => 300],
            ['category', 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Выберите файл',
            'category' => 'Выберите категорию',
            'title' => 'Краткий заголовок',
        ];
    }
}
