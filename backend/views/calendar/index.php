<?php

use rmrevin\yii\fontawesome\FAS;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii2fullcalendar\yii2fullcalendar;

$this->title = 'Календарь записи';

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
            <div class="pull-left">
                <?= Html::a(FAS::icon('angle-left', ['class' => 'big', 'data-role' => 'arrow']) . '&nbsp В главное меню', ['/'], ['class' => 'btn btn-default']) ?>
            </div>
            <div class="pull-right">
                <span style="display: block;margin-top: 5px;" class="titleCardName"><b>Календарь записи</b></span>
            </div>
        </div>
    </div>
    <hr>
<?php if (Yii::$app->user->can('leader')) { ?>
    <div class="row">
        <div class="col-md-3 col-sm-12">
            <div class="c-field">
                <?= Html::label('Выберите специалиста', 'specialist') ?>
                <?php isset($_GET['user']) ? $user = $_GET['user'] : $user = ''?>
                <?= Html::dropDownList('specialist', null, $specialist, [
//                    'prompt' => 'Специалист',
                    'class' => 'c-input showCalendarSelectedSpecialist',
                    'options' => [
                        $user => ['Selected' => true]
                    ]
                ]) ?>
            </div>
        </div>
    </div>
    <hr>
<?php } ?>
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
    'id' => 'modalWin',
    'footer' => Html::a('Открыть карту', [''], ['id' => 'linkCard', 'class' => 'btn btn-green']),
]);
echo '<div id="modalCard"></div><br>';
echo '<div id="modalTitle"></div><br>';
echo '<div id="modalFio"></div><br>';
echo '<div id="modalTime"></div><br>';
Modal::end();
?>