<?php

use yii\grid\GridView;
use yii\helpers\Html;

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

    <div class="row">
        <div class="col-md-12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'name:ntext',
                    'anamnes:ntext',
                    'manipulation:ntext',
                    'recommendation:ntext',
                    'diagnosis:ntext',
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{up}{down}',
                        'buttons' => [
                            'up' => function ($url, $model, $index) {
                                if ($model->number != 1) {
                                    return Html::a('<span style="font-size: 18px" class="glyphicon glyphicon-chevron-up">', ['problem/up', 'id' => $index], ['title' => 'Поднять']). '<br>';
                                }
                            },
                            'down' => function ($url, $model, $index) {
                                if ($model->count() != $model->number) {
                                    return Html::a('<span style="font-size: 18px" class="glyphicon glyphicon-chevron-down">', ['problem/down', 'id' => $index], ['title' => 'Опустить']);
                                }
                            },

                        ]

                    ],
                    ['class' => 'yii\grid\ActionColumn'],

                ],
            ]); ?>
        </div>
    </div>
</div>
