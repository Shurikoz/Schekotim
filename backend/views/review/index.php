<?php
namespace app\models;

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ReviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отзывы';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-12 col-12-medium">
        <div class="review-index">
            <h1><?= Html::encode($this->title) ?></h1>
            <p><?= Html::a('Добавить отзыв', ['create'], ['class' => 'btn btn-success']) ?></p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'options' => ['width' => '100%'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn',],
                    'id',
                    'name',
                    'email:email',
                    'mobile',
                    'created_at',
                    'rating',
                    'active',
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => 'Действия',
                        'template' => '{show}{hide}',
                        'buttons' => [
                            'show' => function ($model, $key, $index) {
                                return Html::a('<span style="font-size: 18px" class="glyphicon glyphicon-ok">', ['review/show', 'id' => $index], ['class' => 'btn btn-primary', 'title' => 'Опубликовать']);
                            },
                            'hide' => function ($model, $key, $index) {
                                return Html::a('<span style="font-size: 18px" class="glyphicon glyphicon-remove">', ['review/hide', 'id' => $index], ['class' => 'btn btn-primary', 'title' => 'Снять с публикации']);
                            },
                        ]
                    ],
                    'text:ntext',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>