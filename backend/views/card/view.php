<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Card */

$this->title = 'Карта №: ' . $model->number;
$this->params['breadcrumbs'][] = ['label' => 'Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card-view">

    <h1><?= Html::encode($this->title) ?></h1>


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
    <div class="box">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
        ],
    ]) ?>
    </div>
    <?= Html::a('Создать новый визит', ['visit/create', 'id' => $model->id, 'card_number' => $model->number, 'city' => $model->city, 'address_point' => $model->address_point], ['class' => 'btn btn-primary']) ?>
    <br>
    <br>
    <?php
    $visit_number = count($visits);
    foreach (array_reverse($visits) as $item) { ?>
    <div class="box">
    <h3>Визит №: <?= $visit_number ?></h3>

        <?= DetailView::widget([
            'model' => $item,
            'attributes' => [
                'city',
                'address_point',
                'reason',
                'manipulation',
                'recommendation',
                'next_visit_from',
                'next_visit_by',
                'has_come',
                'description'
            ],
        ]);
        $visit_number--; ?>
    </div>

    <?php } ?>
</div>