<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii2fullcalendar\yii2fullcalendar;

$JSEventMouseover = <<<EOF
function(date) {
    $('#modalWin').modal('show');
    $('#linkCard').attr('href', date.link);
    $('#modalTitle').text(date.title);
    $('#modalFio').text(date.fio);
    $('#modalTime').text(date.time);
    $('#modalCard').text(date.card);
}    
EOF;
?>
<div class="row">
    <div class="col-md-12">
        <h3>Календарь записей</h3>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= yii2fullcalendar::widget([
            'options' => [
                'lang' => 'ru',
            ],
            'clientOptions' => [
                'schedulerLicenseKey' => 'CC-Attribution-NonCommercial-NoDerivatives',
                'height' => 'auto',
                'nowIndicator' => true,
                'defaultView' => 'list',
//        'defaultView' => 'month',
                'minTime' => '10:00:00',
                'maxTime' => '21:00:00',
                'allDayText' => 'Часы',
                'timeFormat' => 'H:mm',
                'slotEventOverlap' => false,
                'eventBackgroundColor' => '#7ba335',
                'header' => [
                    'right' => 'list,basicWeek,month'
                ],
                'eventClick' => new JsExpression($JSEventMouseover),
            ],
            'events' => $events,
        ]);
        ?>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <p><span class="fc-event-dot" style="background-color:gray"></span> - ожидание посещения</p>
            <p><span class="fc-event-dot" style="background-color:#7ba335"></span> - клиент пришел</p>
            <p><span class="fc-event-dot" style="background-color:#d84248"></span> - клиент не пришел</p>
        </div>
    </div>
</div>

<?php
Modal::begin([
    'header' => '<b>Краткое описание посещения</b>',
    'id'=>'modalWin',
    'footer' => Html::a('Открыть карту', [''], ['id' => 'linkCard', 'class' => 'btn btn-green']),
]);
echo '<div id="modalCard"></div><br>';
echo '<div id="modalTitle"></div><br>';
echo '<div id="modalFio"></div><br>';
echo '<div id="modalTime"></div><br>';
Modal::end();
?>