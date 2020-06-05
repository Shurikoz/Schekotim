<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use common\widgets\Alert;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$count_orders = (isset($_GET['per-page'])) ? $_GET['per-page'] : 20;

$this->title = 'Карты пациентов';

?>
<div class="card-index">
    <div class="row">
        <div class="col-md-12">

            <?= $this->render('_search', [
                'model' => $searchModel,
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="pull-left cardsOnPage">
                <span>Карт на странице:</span>
                <?= Html::a(20, Url::current(['per-page' => 20]), ['class' => ($count_orders == 20) ? 'active' : '']) ?>
                <?= Html::a(40, Url::current(['per-page' => 40]), ['class' => ($count_orders == 40) ? 'active' : '']) ?>
                <?= Html::a(60, Url::current(['per-page' => 60]), ['class' => ($count_orders == 60) ? 'active' : '']) ?>
            </div>
            <div class="pull-right perPage">
                <?= LinkPager::widget([
                    'pagination' => $pages,
                    'maxButtonCount' => 5,
                ]); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= Alert::widget() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="c-table">
                <caption class="c-table__title">
                    <?= Html::encode($this->title) ?>
                    <small>Найдено карт: <?= $dataProvider->getTotalCount() ?></small>

                    <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('manager')) { ?>
                        <?= Html::a('Создать карту', ['card/create'], ['style' => 'float:right;', 'class' => 'btn btn-md btn-green center-block']) ?>
                    <?php } ?>
                </caption>

                <thead class="c-table__head c-table__head--slim">
                <tr class="c-table__row">
                    <th class="c-table__cell c-table__cell--head">№</th>
                    <th class="c-table__cell c-table__cell--head">Город / Точка</th>
                    <th class="c-table__cell c-table__cell--head">Пациент</th>
                    <th class="c-table__cell c-table__cell--head">Посещений</th>
                    <th class="c-table__cell c-table__cell--head">
                        <span class="u-hidden-visually">Действия</span>
                    </th>
                </tr>
                </thead>
                <tbody>

                <?php // TODO Исправить timeout?>
                <?php Pjax::begin(['timeout' => 5000]); ?>

                <?php if ($dataProvider->getModels()) { ?>
                    <?php foreach ($dataProvider->getModels() as $item) { ?>
                        <tr class="c-table__row">
                            <td class="c-table__cell"><b><?= $item->number ?></b></td>
                            <td class="c-table__cell">
                                <p><?= $item->city ?></p>
                                <p><?= $item->address_point?></p>
                            </td>

                            <td class="c-table__cell">
                                <p><b><?= $item->surname ?> <?= $item->name ?> <?= $item->middle_name ?></b></p>
                                <p>Г.р.: <?= Yii::$app->formatter->asDate($item->birthday) ?></p>
                            </td>

                            <td class="c-table__cell"><span class="visitMarker"><?= count($item->visit) ?></span></td>

                            <td class="c-table__cell cardBtn">
                                <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['card/view', 'number' => $item->number], [
                                    'class' => 'btn linkNewWindow',
                                    'data-number' => $item->number
                                ]) ?>
                                <?php if (Yii::$app->user->can('admin')) { ?>
                                    <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['card/update', 'number' => $item->number], ['class' => 'btn']) ?>
                                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['card/delete', 'number' => $item->number], [
                                        'class' => 'btn',
                                        'data-method' => 'POST',
                                        'data-confirm' => 'Вы уверены, что хотите удалить карту?'
                                    ]) ?>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr class="c-table__row">
                        <td colspan="10" class="c-table__cell--empty">Ничего не найдено :(</td>
                    </tr>
                <?php } ?>

                <?php Pjax::end(); ?>
                </tbody>
            </table>
            <div class="pull-right">
                <?= LinkPager::widget([
                    'pagination' => $pages,
                    'maxButtonCount' => 5,
                ]); ?>

            </div>

        </div>
    </div>
</div>