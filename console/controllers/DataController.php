<?php
/**
 * Created by PhpStorm.
 * User: 4pok
 * Date: 21.06.2020
 * Time: 10:34
 */
namespace console\controllers;

use yii\console\Controller;
use console\models\Data;

class DataController extends Controller
{

    /**
     * @return string
     */
    public function actionData()
    {
        $data = new Data();
        $data->data = date('H:i:s');
        $data->save();
        return true;
    }

}