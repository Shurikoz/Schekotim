<?php

use yii\helpers\Html;
use rmrevin\yii\fontawesome\FAS;

/* @var $this yii\web\View */
/* @var $model backend\models\Visit */

\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-left">
            <?= Html::a(FAS::icon('angle-left', ['class' => 'big', 'data-role' => 'arrow']) . '&nbsp Назад', ['/'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>
<hr>
<!--<div class="row">-->
<!--    <div class="col-md-12">-->
<!--        --><?//= $this->render('_search', [
//            'model' => $searchModel,
//        ]) ?>
<!--    </div>-->
<!--</div>-->
<table class="c-table">
    <caption class="c-table__title">
        Лист пропущенных посещений
        <small>Всего пропущенных посещений: <?= count($model) ?></small>
    </caption>
    <thead class="c-table__head c-table__head--slim">
    <tr class="c-table__row">
        <th class="c-table__cell c-table__cell--head">Карта</th>
        <th class="c-table__cell c-table__cell--head">ФИО</th>
        <th class="c-table__cell c-table__cell--head">Город / Точка</th>
        <th class="c-table__cell c-table__cell--head">Проблема</th>
        <th class="c-table__cell c-table__cell--head">Подолог</th>
        <th class="c-table__cell c-table__cell--head">Дата визита</th>
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
                $picCome = '<span class="glyphicon glyphicon-hourglass"></span>';
            } elseif ($item->has_come == 1) {
                $picCome = '<span class="glyphicon glyphicon-ok"></span>';
            } else {
                $picCome = '<span class="glyphicon glyphicon-remove"></span>';
            }
            ?>
            <tr class="c-table__row">
                <td class="c-table__cell">
                    <p><?= $item->card_number ?></p>
                </td>
                <td class="c-table__cell">
                    <p><?= $item->card->surname?></p>
                    <p><?= $item->card->name?></p>
                    <p><?= $item->card->middle_name?></p>
                </td>
                <td class="c-table__cell">
                    <p><?= $item->city->name ?></p>
                    <p><?= $item->address_point->address_point?></p>
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
                    <?php if (($item->next_visit_from != null && $item->next_visit_by != null && $item->has_come == 0 && $item->visit_date == null) || ($item->has_come == 2 && $item->next_visit_from != null && $item->next_visit_by != null)) { ?>
                        <p>с <?= date('d.m.Y', $item->next_visit_from) ?></p>
                        <p>до <?= date('d.m.Y', $item->next_visit_by) ?></p>
                    <?php } else if ($item->visit_date != null) { ?>
                        <span> <?= date('d.m.Y <b>H:i</b>', $item->visit_date)?></span>
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