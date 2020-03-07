<?php

use rmrevin\yii\fontawesome\FAS;
use yii\helpers\Html;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model backend\models\Card */

$this->title = 'Карта №: ' . $model->number;
$this->params['breadcrumbs'][] = ['label' => 'Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);

$visit_number = count($visits);

?>

<pre>
<!--    --><?//= print_r($visits)?>
</pre>

<div class="card-view">
    <?= Html::button(FAS::icon('angle-left', ['class' => 'big', 'data-role' => 'arrow']) . '&nbsp Вернуться к списку карт', [
        'class' => 'btn btn-default',
        'onclick' => 'history.back();'
    ]) ?>
    <br>
    <?php if (Yii::$app->user->can('admin')) { ?>
        <p>
            <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить карту?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php } ?>
    <br>
    <div class="box">
        <h3><?= Html::encode($this->title) ?></h3>
        <hr>
        <p class="titleCardName"><?= $model->surname ?> <?= $model->name ?> <?= $model->middle_name ?></p>
    </div>
    <div class="row cardView">
        <div class="col-md-3">
            <div class="box">
                <b>Дата рождения: </b><?= Yii::$app->formatter->asDate($model->birthday) ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box">
                <b>Дата создания: </b><?= Yii::$app->formatter->asDate($model->created_at) ?>
            </div>
        </div>
        <div class="col-md-6">
                <div class="box">
                    <b>Место создания: </b><?= $location->city->name ?>, <?= $location->address_point ?>
                </div>
        </div>
    </div>
    <table class="c-table">
        <caption class="c-table__title">
            Лист посещений
            <small>Всего посещений: <?= count($visits) ?></small>
            <small>(одна проблема - одно посещение)</small>
            <div class="pull-right">
                <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('user')) { ?>
                    <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Создать новый визит', ['visit/create', 'id' => $model->id, 'card_number' => $model->number, 'city' => $model->city, 'address_point' => $model->address_point], ['class' => 'btn btn-green']) ?>
                <?php } ?>
            </div>
        </caption>

        <thead class="c-table__head c-table__head--slim">
        <tr class="c-table__row">
            <th class="c-table__cell c-table__cell--head">Визит №</th>
            <th class="c-table__cell c-table__cell--head">Город / Точка</th>
            <th class="c-table__cell c-table__cell--head">Проблема</th>
            <th class="c-table__cell c-table__cell--head">Подолог</th>
            <th class="c-table__cell c-table__cell--head">Дата визита</th>
            <th class="c-table__cell c-table__cell--head">Время</th>
            <th class="c-table__cell c-table__cell--head">Посещение</th>
        </tr>
        </thead>
        <tbody>

        <?php // TODO Исправить timeout?>
        <?php Pjax::begin(['timeout' => 5000]); ?>
        <?php if (count($visits) != 0) { ?>
            <?php foreach (array_reverse($visits) as $item) { ?>
                <?php if ($item->has_come == 0) {
                    $hasCome = 'c-table__row--wait';
                    $pic = 'glyphicon-time';
                } elseif ($item->has_come == 1) {
                    $hasCome = 'c-table__row--success';
                    $pic = 'glyphicon-ok';
                } else {
                    $hasCome = 'c-table__row--danger';
                    $pic = 'glyphicon-remove';
                } ?>

                <tr class="c-table__row <?= $hasCome ?> visitBox">
                    <td class="c-table__cell"><p><?= $visit_number ?></p></td>
                    <td class="c-table__cell">
                        <p><?= $item->city->name ?></p>
                        <p><?= $item->addressPoint->address_point ?></p>
                    </td>
                    <td class="c-table__cell"><?= $item->reason ?></td>
                    <td class="c-table__cell"><?= $item->podolog->name?></td>
                    <td class="c-table__cell">
                        <p><b>С:</b> <?= Yii::$app->formatter->asDate($item->next_visit_from) ?></p>
                        <p><b>ДО:</b> <?= Yii::$app->formatter->asDate($item->next_visit_by) ?></p>
                    </td>
                    <td class="c-table__cell">
                        <p><b><?= Yii::$app->formatter->asTime($item->visit_time) ?></b></p>
                    </td>
                    <td class="c-table__cell">
                        <span class="glyphicon <?= $pic ?>"></span>
                    </td>

                </tr>
                <tr class="c-table__row visitInfoBlock hide hideBox">
                    <td colspan="10" class="c-table__visitInfoBlock">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="userStatus pull-right">
                                    <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('user')) { ?>
                                        <?php if ($item->has_come == 0) { ?>
                                            <?= Html::a('Пришел', ['visit/come', 'id' => $item->id, 'card' => $model->number], [
                                                'class' => 'btn btn-green',
                                                'data' => [
                                                    'confirm' => 'Отметить посещение пациента?',
                                                ],
                                            ]) ?>
                                            <br>
                                            <br>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box">
                                    <div class="col-md-12">
                                        <p><b>Манипуляции:</b></p>
                                        <br>
                                        <p><?= $item->manipulation == null ? 'Не заполнено' : $item->manipulation ?></p>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="col-md-12">
                                        <p><b>Рекомендации:</b></p>
                                        <br>
                                        <p><?= $item->recommendation == null ? 'Не заполнено' : $item->recommendation ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="box">
                                    <div class="col-md-12">
                                        <p><b>Фото ДО</b></p>
                                        <?php foreach ($item->photo as $photo) { ?>
                                            <?php if ($photo->made == 'before') { ?>
                                                <div class="photo" style="float: left; margin-right: 20px ">
                                                    <img src="<?= $photo->thumbnail ?>" alt="">
                                                    <br>
                                                    <?= Html::a('Скачать файл', ['photo/download', 'id' => $photo->id]) ?>
                                                    <?php ?>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="col-md-12">
                                        <p><b>Фото ПОСЛЕ</b></p>
                                        <?php foreach ($item->photo as $photo) { ?>
                                            <?php if ($photo->made == 'after') { ?>
                                                <div class="photo" style="float: left; margin-right: 20px ">
                                                    <img src="<?= $photo->thumbnail ?>" alt="">
                                                    <br>
                                                    <?= Html::a('Скачать файл', ['photo/download', 'id' => $photo->id]) ?>
                                                    <?php ?>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="box">
                                <div class="col-md-12">
                                    <p><b>Комментарий:</b></p>
                                    <br>
                                    <p><?= $item->description == null ? 'Не заполнено' : $item->description ?></p>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php $visit_number--; ?>
            <?php } ?>
        <?php } else { ?>
            <tr class="c-table__row">
                <td colspan="10" class="c-table__cell--empty">Посещений не зафиксировано</td>
            </tr>
        <?php } ?>

        <?php Pjax::end(); ?>
        </tbody>
    </table>
    <br>
    <div class="pull-right">
        <p><span class="glyphicon glyphicon-time"></span> - ожидание посещения</p>
        <p><span class="glyphicon glyphicon-ok"></span> - пациент пришел в указанное время</p>
        <p><span class="glyphicon glyphicon-remove"></span> - пациент не пришел в указанное время</p>
    </div>
</div>