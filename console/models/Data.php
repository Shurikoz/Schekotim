<?php
/**
 * Created by PhpStorm.
 * User: 4pok
 * Date: 21.06.2020
 * Time: 10:32
 */
namespace console\models;

use yii\db\ActiveRecord;

class Data extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data'], 'safe'],
        ];
    }

}