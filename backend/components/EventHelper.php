<?php
/**
 * Created by PhpStorm.
 * User: 4pok
 * Date: 23.07.2020
 * Time: 19:09
 */

namespace backend\components;

use yii2fullcalendar\models\Event;

class EventHelper extends Event
{

    public $description;
    public $link;
    public $fio;
    public $time;
    public $card;

    /**
     * @param $item
     * @return string
     */
    public static function getColor($item)
    {
        switch ($item->has_come){
            case 0:
                $color = 'gray';
                break;
            case 1:
                $color = '#7ba335';
                break;
            case 2:
                $color = '#d84248';
                break;
        }
        return $color;

    }

}