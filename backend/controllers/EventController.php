<?php
/**
 * Created by PhpStorm.
 * User: 4pok
 * Date: 22.07.2020
 * Time: 16:03
 */

namespace backend\controllers;

use backend\components\EventHelper;
use backend\models\Specialist;
use backend\models\Visit;
use DateTime;
use yii\web\Controller;
use Yii;
class EventController extends Controller
{
    public function actionIndex()
    {
        $events = [];
        $specialist = Specialist::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one();
        $eve = Visit::find()->where(['specialist_id' => $specialist->id])->andWhere(['>', 'problem_id', 0])->with(['problem', 'card'])->all();
        foreach ($eve as $item) {
            $event = new EventHelper();
            $event->id = $item->id;
            $event->title = $item->problem->name;
            $event->start = date(DateTime::ISO8601, $item->visit_date);
            $event->className = 'eveClass';
            $event->link = '/card/view?number=' . $item->card_number;
            $event->fio = 'Клиент: ' . $item->card->name . ' ' . $item->card->middle_name . ' ' . $item->card->surname;
            $event->time = 'Время записи/посещения: ' . date('d.m.Y H:i', $item->visit_date);
            $event->card = 'Карта №: ' . $item->card_number;
//            $event->description = '123';
            $event->color = $event->getColor($item);
            $events[] = $event;
        }

        return $this->render('index', [
            'events' => $events,
            'eve' => $eve,
        ]);
    }
}
?>