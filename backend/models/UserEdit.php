<?php

namespace backend\models;

use common\models\User;

class UserEdit extends User
{

    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'match', 'pattern' => '/^([а-яА-ЯЁё\.\s]+)$/u', 'message' => 'Разрешено вводить только киррилические символы, точки и пробелы'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя пользователя',
        ];

    }
}