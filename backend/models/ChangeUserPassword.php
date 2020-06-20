<?php
/**
 * Created by PhpStorm.
 * User: 4pok
 * Date: 20.06.2020
 * Time: 16:32
 */

namespace backend\models;

use mdm\admin\models\form\ChangePassword;


class ChangeUserPassword extends ChangePassword
{

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'oldPassword' => 'Старый пароль',
            'newPassword' => 'Новый пароль',
            'retypePassword' => 'Повторите новый пароль',
        ];
    }

}



