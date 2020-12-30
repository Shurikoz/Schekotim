<?php
/**
 * Created by PhpStorm.
 * User: 4pok
 * Date: 22.07.2020
 * Time: 16:03
 */

namespace backend\controllers;

use backend\models\Specialist;
use backend\models\Visit;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class CalendarController extends Controller
{
    /**
     * получим массив с данными для календаря событий
     * @param $user
     * @return string
     */
    public function actionIndex($user = 1)
    {

        $e = new Visit();
        $events = $e->getUserCalendar($user);
        $specialist = ArrayHelper::map(Specialist::find()->all(), 'id', 'name');

        return $this->render('index', [
            'events' => $events,
            'specialist' => $specialist
        ]);
    }
}
?>