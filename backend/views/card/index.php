<?php

use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Карты пациентов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-index">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <h1><?= Html::encode($this->title) ?></h1>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('manager')) { ?>
                    <p>
                        <?= Html::a('Создать карту', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                <?php } ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'pager' => [
                        'firstPageLabel' => 'Начало',
                        'lastPageLabel' => 'Конец',
                    ],
                    'columns' => [
//                ['class' => 'yii\grid\SerialColumn'],
//                'id',
//                'user_id',
                        'number',
                        'city',
                        'address_point',
                        'doctor:ntext',
                        'name',
                        'surname',
                        'middle_name',
                        'birthday',
                        'description:ntext',
                        'created_at',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update}',
                            'visible' => Yii::$app->user->can('admin'),

                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{delete}',
                            'visible' => Yii::$app->user->can('admin'),

                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view}',
                        ]
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>