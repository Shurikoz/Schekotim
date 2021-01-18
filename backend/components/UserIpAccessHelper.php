<?php

namespace backend\components;

use Yii;

class UserIpAccessHelper
{
    /**
     * @return bool
     */
    public function ipAccess()
    {
        // проверка на ip с которого осуществляется доступ
        // ipAccessСondition - проверка включен ли доступ по ip
        if (!Yii::$app->params['ipAccessСondition']) {
            return true;
        }
        if ($this->checkIp() || $this->checkUser()) {
            return true;
        }
        return false;
    }

    /**
     * проверка прав пользователя
     * @return bool
     */
    private function checkUser()
    {
        if (Yii::$app->user->can('admin') || Yii::$app->user->can('leader')) {
            return true;
        }
        return false;
    }

    /**
     * проверка доступа по указанным ip адресам
     * @return bool
     */
    private function checkIp()
    {
        if (in_array(Yii::$app->request->userIP, Yii::$app->params['ipAddress'])){
            return true;
        }
        return false;
    }
}