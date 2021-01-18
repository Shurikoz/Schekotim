<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Логи действий';

$count_items = (isset($_GET['per-page'])) ? $_GET['per-page'] : 20;

$admin = Yii::$app->user->can('admin');
\yii\web\YiiAsset::register($this);

?>

<div class="row">
    <div class="col-md-12">
        <h3>Логи (История действий)</h3>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="pull-left cardsOnPage">
            <span>Карт на странице:</span>
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
<div class="row">
    <div class="col-md-12">
        <table class="c-table">
            <thead class="c-table__head c-table__head--slim">
            <tr class="c-table__row">
                <th class="c-table__cell c-table__cell--head">ID операции</th>
                <th class="c-table__cell c-table__cell--head">Дата</th>
                <th class="c-table__cell c-table__cell--head">Время</th>
                <th class="c-table__cell c-table__cell--head">Объект</th>
                <th class="c-table__cell c-table__cell--head">ID объекта</th>
                <th class="c-table__cell c-table__cell--head">Операция</th>
                <th class="c-table__cell c-table__cell--head">Логин</th>
                <th class="c-table__cell c-table__cell--head">Имя</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($dataProvider->getModels() as $item) { ?>
                <?php $changes = json_decode($item->changes, JSON_UNESCAPED_UNICODE); ?>
                <tr class="c-table__row openBox">
                    <td class="c-table__cell">
                        <?= $item->id ?>
                    </td>
                    <td class="c-table__cell">
                        <?= date('d.m.Y', $item->time)?>
                    </td>
                    <td class="c-table__cell">
                        <?= date('H:i', $item->time)?>
                    </td>
                    <td class="c-table__cell">
                        <?= $item->object == 'visit' ? 'Посещение' : 'Карта'?>
                    </td>
                    <td class="c-table__cell">
                        <?= $item->object_id?>
                    </td>
                    <td class="c-table__cell">
                        <?= $item->operation == 'create' ? 'Создание' : 'Изменение'?>
                    </td>
                    <td class="c-table__cell">
                        <?= $item->user->username ?>
                    </td>
                    <td class="c-table__cell">
                        <?= $item->user->name == null ? '-' : $item->user->name?>
                    </td>
                </tr>
                <tr class="c-table__row infoBlock hide hideBox">
                    <td colspan="10" class="c-table__infoBlock">
                        <div class="box">
                            <p><b>Изменения:</b></p>
                            <pre>
                                <?= print_r($changes) ?>
                            </pre>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
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
