<?php

use yii\helpers\Html;
use rmrevin\yii\fontawesome\FAS;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$count_items = (isset($_GET['per-page'])) ? $_GET['per-page'] : 20;

$this->title = 'Лист пропущенных посещений';

\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-left">
            <?= Html::a(FAS::icon('angle-left', ['class' => 'big', 'data-role' => 'arrow']) . '&nbsp В главное меню', ['/'], ['class' => 'btn btn-default']) ?>
        </div>
        <div class="pull-right">
            <span style="display: block;margin-top: 5px;" class="titleCardName"><b>Пропущенные посещения</b></span>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_search', [
            'model' => $searchModel,
        ]) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= Alert::widget() ?>
        <div class="pull-left cardsOnPage">
            <span>Карт на странице:</span>
            <?= Html::a(20, Url::current(['per-page' => 20]), ['class' => ($count_items == 20) ? 'active' : '']) ?>
            <?= Html::a(40, Url::current(['per-page' => 40]), ['class' => ($count_items == 40) ? 'active' : '']) ?>
            <?= Html::a(60, Url::current(['per-page' => 60]), ['class' => ($count_items == 60) ? 'active' : '']) ?>
        </div>
        <div class="pull-right perPage">
            <?= LinkPager::widget([
                'pagination' => $pages,
                'maxButtonCount' => 3,
                'firstPageLabel' => true,
                'lastPageLabel' => true,
            ]); ?>
        </div>
    </div>
</div>
<table class="c-table">
    <caption class="c-table__title">
        Лист пропущенных посещений
        <small>Всего пропущенных посещений: <?= $dataProvider->getTotalCount() ?></small>
    </caption>
    <thead class="c-table__head c-table__head--slim">
    <tr class="c-table__row">
        <th class="c-table__cell c-table__cell--head">ID</th>
        <th class="c-table__cell c-table__cell--head">Карта</th>
        <th class="c-table__cell c-table__cell--head">ФИО</th>
        <th class="c-table__cell c-table__cell--head">Проблема</th>
        <th class="c-table__cell c-table__cell--head">Подолог</th>
        <th class="c-table__cell c-table__cell--head">Дата визита</th>
        <th class="c-table__cell c-table__cell--head">Отметки</th>
        <th class="c-table__cell c-table__cell--head">Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php // TODO Исправить timeout?>
    <?php if ($dataProvider->getTotalCount() != 0) { ?>
        <?php foreach ($dataProvider->getModels() as $item) { ?>
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
                    <p><?= $item->id ?></p>
                </td>
                <td class="c-table__cell">
                    <p><?= $item->card_number ?></p>
                </td>
                <td class="c-table__cell">
                    <p><b><?= $item->card['surname'] ?> <?= $item->card['name'] ?> <?= $item->card['middle_name'] ?></b></p>
                </td>
                <td class="c-table__cell">
                    <?php if ($item->problem_id == 0) { ?>
                        <span class="text-red">Не указана</span>
                    <?php } else { ?>
                        <?= $item->problem->name ?>
                    <?php } ?>
                </td>
                <td class="c-table__cell">
                    <?= $item->specialist->name ?>
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
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?= LinkPager::widget([
                'pagination' => $pages,
                'maxButtonCount' => 3,
                'firstPageLabel' => true,
                'lastPageLabel' => true,
            ]); ?>
        </div>
    </div>
</div>
<br>
<div class="pull-right">
    <p><span class="glyphicon glyphicon-remove"></span> - пациент не пришел в указанное время</p>
</div>