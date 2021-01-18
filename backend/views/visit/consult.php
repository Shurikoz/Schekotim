<?php

use backend\models\Photo;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;
use rmrevin\yii\fontawesome\FAS;

$count_items = (isset($_GET['per-page'])) ? $_GET['per-page'] : 20;

$this->title = 'Лист консультаций';

?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-left">
            <?= Html::a(FAS::icon('angle-left', ['class' => 'big', 'data-role' => 'arrow']) . '&nbsp В главное меню', ['/'], ['class' => 'btn btn-default']) ?>
        </div>
        <div class="pull-right">
            <span style="display: block;margin-top: 5px;" class="titleCardName"><b>Консультации</b></span>
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
</div><div class="row">
    <div class="col-md-12">
        <div class="pull-left cardsOnPage">
            <span>Записей на странице:</span>
            <?= Html::a(20, Url::current(['per-page' => 20]), ['class' => ($count_items == 20) ? 'active' : '']) ?>
            <?= Html::a(40, Url::current(['per-page' => 40]), ['class' => ($count_items == 40) ? 'active' : '']) ?>
            <?= Html::a(60, Url::current(['per-page' => 60]), ['class' => ($count_items == 60) ? 'active' : '']) ?>
        </div>
        <div class="pull-right perPage">
            <?= LinkPager::widget([
                'pagination' => $pages,
                'maxButtonCount' => 5,
                'firstPageLabel' => true,
                'lastPageLabel' => true,
            ]); ?>
        </div>
    </div>
</div>
<table class="c-table">
    <caption class="c-table__title">
        Лист консультаций
    </caption>
    <thead class="c-table__head c-table__head--slim">
    <tr class="c-table__row">
        <th class="c-table__cell c-table__cell--head">Карта</th>
        <th class="c-table__cell c-table__cell--head">Id</th>
        <th class="c-table__cell c-table__cell--head">ФИО</th>
        <th class="c-table__cell c-table__cell--head">Проблема</th>
        <th class="c-table__cell c-table__cell--head">Подолог</th>
        <th class="c-table__cell c-table__cell--head">Дата визита</th>
        <th class="c-table__cell c-table__cell--head">Отметки</th>
        <th class="c-table__cell c-table__cell--head">Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($dataProvider->getModels() as $item) { ?>
        <tr class="c-table__row">
                <td class="c-table__cell">
                    <?= $item->card_number?>
                </td>
                <td class="c-table__cell">
                    <?= $item->id?>
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
                    <?php if (Photo::countPhotoBefore($item->photo) == 0) { ?>
                        <span class="glyphicon glyphicon-camera"></span>
                    <?php } ?>
                    <span class="glyphicon glyphicon-asterisk"></span>
                </td>
                <td class="c-table__cell cardBtn">
                    <?= Html::a('<span class="glyphicon glyphicon-new-window"></span>', ['card/view', 'number' => $item->card_number], [
                        'class' => 'btn linkNewWindow',
                        'title' => 'Открыть карту пациента'
                    ]) ?>
                </td>
            </tr>
    <?php } ?>
    </tbody>
</table>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?= LinkPager::widget([
                'pagination' => $pages,
                'maxButtonCount' => 5,
                'firstPageLabel' => true,
                'lastPageLabel' => true,
            ]); ?>
        </div>
    </div>
</div>

