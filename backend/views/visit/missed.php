<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Visit */

\yii\web\YiiAsset::register($this);
?>
<!--<div class="visit-view">-->
<!--<pre>-->
<!--    --><?php //print_r($model);?>
<!--    </pre>-->
<!--</div>-->

<table class="c-table">
    <caption class="c-table__title">
        Лист пропущенных посещений
        <small>Всего пропущенных посещений: <?= count($model) ?></small>
    </caption>
    <thead class="c-table__head c-table__head--slim">
    <tr class="c-table__row">
        <th class="c-table__cell c-table__cell--head">ID</th>
        <th class="c-table__cell c-table__cell--head">Город / Точка</th>
        <th class="c-table__cell c-table__cell--head">Проблема</th>
        <th class="c-table__cell c-table__cell--head">Подолог</th>
        <th class="c-table__cell c-table__cell--head">Дата визита</th>
        <th class="c-table__cell c-table__cell--head">Время</th>
        <th class="c-table__cell c-table__cell--head">Отметки</th>
        <th class="c-table__cell c-table__cell--head">Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php // TODO Исправить timeout?>
    <?php if (count($model) != 0) { ?>
        <?php foreach (array_reverse($model) as $item) { ?>
            <?php
            // проверим указатель пришел ли пациент
            if ($item->has_come == 0) {
                $hasCome = 'c-table__row--wait';
                $picCome = '<span class="glyphicon glyphicon-hourglass"></span>';
            } elseif ($item->has_come == 1) {
                $hasCome = 'c-table__row--success';
                $picCome = '<span class="glyphicon glyphicon-ok"></span>';
            } else {
                $hasCome = 'c-table__row--danger';
                $picCome = '<span class="glyphicon glyphicon-remove"></span>';
            }
            ?>
            <tr class="c-table__row <?= $hasCome ?> ">
                <td class="c-table__cell">
                    <span><?= $item->id ?></span>
                </td>
                <td class="c-table__cell">
                    <p><?= $item->city ?></p>
                    <p><?= $item->address_point ?></p>
                </td>
                <td class="c-table__cell">
                    <?php if ($item->problem_id == 0) { ?>
                        <span class="text-red">Не указана</span>
                    <?php } else { ?>
                        <?= $item->problem->name ?>
                    <?php } ?>
                </td>
                <td class="c-table__cell">
                    <?= $item->podolog->name ?>
                </td>
                <td class="c-table__cell">
                    <?php if ($item->next_visit_from != null && $item->next_visit_by != null && $item->has_come == 0) { ?>
                        <p>с <?= Yii::$app->formatter->asDate($item->next_visit_from) ?></p>
                        <p>до <?= Yii::$app->formatter->asDate($item->next_visit_by) ?></p>
                    <?php } else if ($item->has_come == 1) { ?>
                        <span> <?= Yii::$app->formatter->asDate($item->visit_date) ?></span>
                    <?php } else if ($item->has_come == 2) { ?>
                        <span>-</span>
                    <?php } ?>
                </td>
                <td class="c-table__cell">
                    <?php if ($item->visit_time != null) { ?>
                        <span><b><?= Yii::$app->formatter->asTime($item->visit_time) ?></b></span>
                    <?php } else { ?>
                        <span>-</span>
                    <?php } ?>
                </td>
                <td class="c-table__cell">
                    <span class="glyphicon glyphicon-remove"></span>
                </td>
                <td class="c-table__cell cardBtn">
                    <?= Html::a('<span class="glyphicon glyphicon-new-window"></span>', ['card/view', 'number' => $item->card_number], [
                        'class' => 'btn linkNewWindow',
                        'title' => 'Открыть карту пациента'
                    ]) ?>
                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr class="c-table__row">
            <td colspan="10" class="c-table__cell--empty">Пропущенных посещений нет.</td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<br>
<div class="pull-right">
    <p><span class="glyphicon glyphicon-remove"></span> - пациент не пришел в указанное время</p>
</div>