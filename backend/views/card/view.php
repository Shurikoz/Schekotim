<?php

use common\widgets\Alert;
use rmrevin\yii\fontawesome\FAS;
use russ666\widgets\Countdown;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\Card */

$this->title = 'Карта №: ' . $model->number;

\yii\web\YiiAsset::register($this);

$visit_number = count($visits);

?>

<div class="card-view">
    <?= Html::a(FAS::icon('angle-left', ['class' => 'big', 'data-role' => 'arrow']) . '&nbsp Вернуться к списку карт', ['/card/index'], ['class' => 'btn btn-default']) ?>
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
        <h3><b><?= Html::encode($this->title) ?></b></h3>
    </div>
    <div class="row cardView">
        <div class="col-md-6">
            <div class="box">
                <p class="titleCardName">
                    <b>ФИО:</b> <?= $model->surname ?> <?= $model->name ?> <?= $model->middle_name ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <p class="titleCardName"><b>Телефон:</b> <?= $model->phone ?> </p>
            </div>
        </div>
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
        <?= Alert::widget() ?>
        <caption class="c-table__title">
            Лист посещений
            <small>Всего посещений: <?= count($visits) ?></small>
            <small>(одна проблема - одно посещение)</small>
            <div class="pull-right">
                <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('user')) { ?>
                    <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Создать новое посещение', ['visit/create-first', 'id' => $model->id, 'card_number' => $model->number], ['class' => 'btn btn-green']) ?>
                <?php } ?>
            </div>
        </caption>

        <thead class="c-table__head c-table__head--slim">
        <tr class="c-table__row">
            <th class="c-table__cell c-table__cell--head">ID</th>
            <th class="c-table__cell c-table__cell--head">Визит №</th>
            <th class="c-table__cell c-table__cell--head">Город / Точка</th>
            <th class="c-table__cell c-table__cell--head">Проблема</th>
            <th class="c-table__cell c-table__cell--head">Подолог</th>
            <th class="c-table__cell c-table__cell--head">Дата визита</th>
            <th class="c-table__cell c-table__cell--head">Время</th>
            <th class="c-table__cell c-table__cell--head">Отметки</th>
        </tr>
        </thead>
        <tbody>

        <?php // TODO Исправить timeout?>
        <?php Pjax::begin(['timeout' => 5000]); ?>
        <?php if (count($visits) != 0) { ?>
            <?php foreach (array_reverse($visits) as $item) { ?>
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
                // проверим решена проблема или нет
                if ($item->resolve != 0) {
                    $picResolve = '<span class="glyphicon glyphicon-remove-circle"></span>';
                } else {
                    $picResolve = '';
                }

                if ($item->photo == null){
                    $picCamera = '<span class="glyphicon glyphicon-camera"></span>';
                } else {
                    $picCamera = '';
                }
                ?>
                <tr class="c-table__row <?= $hasCome ?> visitBox">
                    <td class="c-table__cell">
                        <span><?= $item->id ?></span>
                    </td>
                    <td class="c-table__cell">
                        <span><?= $visit_number ?></span>
                    </td>
                    <td class="c-table__cell">
                        <p><?= $item->city->name ?></p>
                        <p><?= $item->addressPoint->address_point ?></p>
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
                            <p><b>С:</b> <?= Yii::$app->formatter->asDate($item->next_visit_from) ?></p>
                            <p><b>ДО:</b> <?= Yii::$app->formatter->asDate($item->next_visit_by) ?></p>
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
                        <?= $picCamera ?>
                        <?= $picCome ?>
                        <?= $picResolve ?>

                    </td>
                </tr>
                <tr class="c-table__row visitInfoBlock hide hideBox">
                    <td colspan="10" class="c-table__visitInfoBlock">
                        <?php if ($item->podolog->user_id == Yii::$app->user->id || Yii::$app->user->can('admin')) { ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="userStatus pull-right">
                                        <div>
                                            <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Создать будущее посещение', ['visit/create-second', 'id' => $item->id, 'card' => $model->id, 'card_number' => $model->number], ['class' => 'btn btn-green']) ?>
                                        </div>
                                        <?php //проверка, если текущий пользователь является указанным в визите подологом, то он может редактировать этот визит
                                        if (($item->podolog->user_id == Yii::$app->user->id && $item->timestamp + 60 * 60 * 24 * 2 >= time()) &&  $item->has_come != 2) { ?>
                                            <div id="blockEdit_<?= $item->id ?>" data-id="<?= $item->id ?>">
                                                <?= Html::a('Изменить посещение', ['visit/update', 'id' => $item->id, 'card' => $model->id, 'card_number' => $model->number], ['class' => 'btn btn-info']) ?>
                                                <?php //если указан интервал посещения, то таймер не выводим ?>
                                                <?php if (strtotime($item->next_visit_by) <= time()) { ?>
                                                    <?= Countdown::widget([
                                                        'id' => 'timer_' . $item->id,
                                                        'datetime' => date('Y-m-d H:i:s O', time() + ($item->timestamp - time())),
                                                        'format' => '<span style=\"color: red\"\>%-D д. %-H:%-M:%-S</span> ',
                                                        'tagName' => 'span',
                                                        'events' => [
                                                            'finish' => 'function(){$(\'#blockEdit_\' + $(this).parent().attr("data-id")).remove()}',
                                                        ],
                                                        'options' => [
                                                            'class' => 'timerBox'
                                                        ]
                                                    ]) ?>
                                                <?php } ?>
                                            </div>
                                        <?php } elseif (Yii::$app->user->can('admin')) { ?>
                                            <div>
                                                <?= Html::a('Изменить посещение', ['visit/update', 'id' => $item->id, 'card' => $model->id, 'card_number' => $model->number], ['class' => 'btn btn-info']) ?>
                                            </div>
                                        <?php } ?>

                                        <?php //кнопка «Проблема решена» доступна админу или тому, кто создал посещение?>
                                        <?php if ($item->podolog->user_id == Yii::$app->user->id || Yii::$app->user->can('admin')) { ?>
                                            <div>
                                                <?php if ($item->visit_date != null && $item->problem_id != 0) { ?>
                                                    <?php if ($item->resolve == 0) { ?>
                                                        <?= Html::a('Проблема решена!', ['visit/completed', 'id' => $item->id, 'card' => $model->id, 'resolve' => true], [
                                                            'class' => 'btn btn-green'
                                                        ]) ?>
                                                    <?php } else { ?>
                                                        <?= Html::a('Снять отметку «Проблема решена»!', ['visit/completed', 'id' => $item->id, 'card' => $model->id, 'resolve' => false], [
                                                            'class' => 'btn btn-default'
                                                        ]) ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>

                                        <?php if (Yii::$app->user->can('admin')) { ?>
                                            <div>
                                                <?= Html::a('Удалить', ['visit/delete', 'id' => $item->id, 'card' => $model->id], [
                                                    'class' => 'btn btn-danger',
                                                    'data' => [
                                                        'confirm' => 'Вы уверены, что хотите удалить посещение?',
                                                        'method' => 'post',
                                                    ],
                                                ]) ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box">
                                    <div class="col-md-12">
                                        <p><b>Манипуляции:</b></p>
                                        <br>
                                        <p><?= $item->manipulation == null ? '<span class="text-red">Не заполнено</span>' : $item->manipulation ?></p>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="col-md-12">
                                        <p><b>Рекомендации:</b></p>
                                        <br>
                                        <p><?= $item->recommendation == null ? '<span class="text-red">Не заполнено</span>' : $item->recommendation ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="box">
                                    <div class="col-md-12">
                                        <p><b>Фото до обработки</b></p>
                                        <?php if ($item->photo != null) { ?>
                                            <?php foreach ($item->photo as $photo) { ?>
                                                <?php if ($photo->made == 'before') { ?>
                                                    <div class="photo" style="float: left; margin-right: 20px ">
                                                        <?= Html::a('<img src="'. $photo->thumbnail . '">', $photo->url, ['target'=>'_blank']) ?>
                                                        <br>
                                                        <?= Html::a('Скачать файл', ['photo/download', 'id' => $photo->id]) ?>
                                                        <?php ?>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <p><span class="text-red">Не заполнено</span></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="col-md-12">
                                        <p><b>Фото после обработки</b></p>
                                        <?php if ($item->photo != null) { ?>
                                            <?php foreach ($item->photo as $photo) { ?>
                                                <?php if ($photo->made == 'after') { ?>
                                                    <div class="photo" style="float: left; margin-right: 20px ">
                                                        <?= Html::a('<img src="'. $photo->thumbnail . '">', $photo->url, ['target'=>'_blank']) ?>
                                                        <br>
                                                        <?= Html::a('Скачать файл', ['photo/download', 'id' => $photo->id]) ?>
                                                        <?php ?>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <p><span class="text-red">Не заполнено</span></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box">
                                    <p><b>Комментарий:</b></p>
                                    <br>
                                    <p><?= $item->description == null ? '<span>Не заполнено</span>' : $item->description ?></p>
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
        <p><span class="glyphicon glyphicon-hourglass"></span> - ожидание посещения</p>
        <p><span class="glyphicon glyphicon-ok"></span> - посещение зафиксировано</p>
        <p><span class="glyphicon glyphicon-remove"></span> - пациент не пришел в указанное время</p>
        <p><span class="glyphicon glyphicon-remove-circle"></span> - проблема решена</p>
        <p><span class="glyphicon glyphicon-camera"></span> - не добавлены фотографии</p>

    </div>
</div>