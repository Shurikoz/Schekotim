<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "logs".
 *
 * @property int $id
 * @property int $user_id
 * @property int $object
 * @property int $object_id
 * @property int $operation
 * @property string $time
 * @property string $changes
 */
class Logs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['changes'], 'string'],
            [['time', 'operation', 'object', 'object_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'time' => 'Time',
            'changes' => 'Text',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
