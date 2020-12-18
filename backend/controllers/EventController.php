<?php
/**
 * Created by PhpStorm.
 * User: 4pok
 * Date: 22.07.2020
 * Time: 16:03
 */

namespace backend\controllers;

use backend\models\Visit;
use yii\web\Controller;

class EventController extends Controller
{
    /**
     * получим массив с данными для календаря событий
     */
    public function actionIndex()
    {

        $e = new Visit();
        $events = $e->userEvents();

        return $this->render('index', [
            'events' => $events,
        ]);
    }
}
?>