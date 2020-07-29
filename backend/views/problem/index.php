<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Шаблоны для специалистов';

?>

<div class="row">
    <div class="col-md-12">
        <h3><?= Html::encode($this->title) ?></h3>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= Html::a('Создать шаблон', ['create'], ['class' => 'btn btn-green pull-right']) ?>
    </div>
</div>
<br>
<div class="problem-index">
    <table class="c-table">
        <caption class="c-table__title">
            Список шаблонов для специалистов
        </caption>
        <thead class="c-table__head c-table__head--slim">
        <tr class="c-table__row">
            <th class="c-table__cell c-table__cell--head" width="10%">Номер</th>
            <th class="c-table__cell c-table__cell--head" width="70%">Проблема</th>
            <th class="c-table__cell c-table__cell--head" width="10%">Порядок</th>
            <th class="c-table__cell c-table__cell--head" width="10%">Действия</th>
        </tr>
        </thead>
        <tbody>
                <?php if (count($dataProvider->getModels()) != 0) { ?>
                    <?php foreach ($dataProvider->getModels() as $item) { ?>
                        <tr class="c-table__row openBox" data-id="<?=$item->id?>">
                            <td class="c-table__cell">
                                <?= $item->number ?>
                            </td>
                            <td class="c-table__cell">
                                <?= $item->name ?>
                            </td>
                            <td class="c-table__cell">
                                <?php
                                if ($item->number != 1) {
                                    echo Html::a('<span style="font-size: 18px" class="glyphicon glyphicon-chevron-up">', ['problem/up', 'id' => $item->id], ['title' => 'Поднять']) . '<br>';
                                }
                                if ($item->count() != $item->number) {
                                    echo Html::a('<span style="font-size: 18px" class="glyphicon glyphicon-chevron-down">', ['problem/down', 'id' => $item->id], ['title' => 'Опустить']);
                                }
                                ?>
                            </td>
                            <td class="c-table__cell">
                                <?= Html::a('<span style="font-size: 18px" class="glyphicon glyphicon-pencil">', ['problem/update', 'id' => $item->id], ['title' => 'Редактировать']);?>
                                <?= Html::a('<span style="font-size: 18px" class="glyphicon glyphicon-trash">', ['problem/delete', 'id' => $item->id], ['title' => 'Удалить', 'data' => ['confirm' => 'Вы уверены, что хотите удалить этот элемент?', 'method' => 'post',]]);?>
                            </td>
                        </tr>
                        <tr class="c-table__row infoBlock hide hideBox">
                            <td colspan="10" class="c-table__infoBlock">
                                <div class="row">
                                    <div class="col-md-6">
                                            <div class="box">
                                                <p><b>Анамнез:</b></p>
                                                <br>
                                                <p><?= $item->anamnes == null ? '<em>Не заполнено</em>' : nl2br($item->anamnes) ?></p>
                                            </div>
                                            <div class="box">
                                                <p><b>Манипуляции:</b></p>
                                                <br>
                                                <p><?= $item->manipulation == null ? '<em>Не заполнено</em>' : nl2br($item->manipulation) ?></p>
                                            </div>
                                    </div>
                                    <div class="col-md-6">
                                            <div class="box">
                                                <p><b>Рекомендации:</b></p>
                                                <br>
                                                <p><?= $item->recommendation == null ? '<em>Не заполнено</em>' : nl2br($item->recommendation) ?></p>
                                            </div>
                                            <div class="box">
                                                <p><b>Диагноз:</b></p>
                                                <br>
                                                <p><?= $item->diagnosis == null ? '<em>Не заполнено</em>' : nl2br($item->diagnosis) ?></p>
                                            </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr class="c-table__row">
                        <td colspan="10" class="c-table__cell--empty">Шаблонов нет</td>
                    </tr>
                <?php } ?>
        </tbody>
    </table>













<!--    <div class="row">-->
<!--        <div class="col-md-12">-->
<!--            --><?php //Pjax::begin(); ?>
<!--            --><?//= GridView::widget([
//                'dataProvider' => $dataProvider,
//                'columns' => [
//                    'name:ntext',
//                    'anamnes:ntext',
//                    'manipulation:ntext',
//                    'recommendation:ntext',
//                    'diagnosis:ntext',
//                    ['class' => 'yii\grid\ActionColumn',
//                        'template' => '{up}{down}',
//                        'buttons' => [
//                            'up' => function ($url, $model, $index) {
//                                if ($model->number != 1) {
//                                    return Html::a('<span style="font-size: 18px" class="glyphicon glyphicon-chevron-up">', ['problem/up', 'id' => $index], ['title' => 'Поднять']). '<br>';
//                                }
//                            },
//                            'down' => function ($url, $model, $index) {
//                                if ($model->count() != $model->number) {
//                                    return Html::a('<span style="font-size: 18px" class="glyphicon glyphicon-chevron-down">', ['problem/down', 'id' => $index], ['title' => 'Опустить']);
//                                }
//                            },
//
//                        ]
//
//                    ],
//                    ['class' => 'yii\grid\ActionColumn'],
//
//                ],
//            ]); ?>
<!--            --><?php //Pjax::end(); ?>
<!--        </div>-->
<!--    </div>-->
</div>
