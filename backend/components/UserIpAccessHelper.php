<?php
/**
 * Created by PhpStorm.
 * User: 4pok
 * Date: 30.12.2020
 * Time: 0:48
 */

namespace backend\components;

use Yii;

class UserIpAccessHelper
{
    /**
     * @return bool
     */
    public function ipAccess()
    {
        if (Yii::$app->request->userIP == Yii::$app->params['ipAddress'] || $this->checkUser()) {
            return false;
        }

        return true;

    }

    public function checkUser()
    {
        if (Yii::$app->user->can('admin') || Yii::$app->user->can('leader')) {
            return true;
        }

        return false;
    }
}