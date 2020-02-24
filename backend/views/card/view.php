<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\helpers\Url;

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

    <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('user')) { ?>
        <?= Html::a('Создать новый визит', ['visit/create', 'id' => $model->id, 'card_number' => $model->number, 'city' => $model->city, 'address_point' => $model->address_point], ['class' => 'btn btn-primary']) ?>
        <br>
        <br>
    <?php } ?>

    <?php

    $visit_number = count($visits);

    foreach (array_reverse($visits) as $item) { ?>
        <hr>
        <?php // TODO Исправить timeout?>
        <?php Pjax::begin(['timeout' => 5000]); ?>
        <div class="box">
            <h3>Визит №: <?= $visit_number ?></h3>
            <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('user')) : ?>
                <div class="col-md-3">
                    <div class="userStatus">
                        <?php if ($item->has_come == 0): ?>
                            <?= Html::a('Пришел', ['visit/come', 'id' => $item->id, 'card' => $model->number], [
                                'class' => 'btn btn-success',
                                'data' => [
                                    'confirm' => 'Отметить посещение пациента?',
                                ],
                            ]) ?>
                        <?php else : ?>
                            <p>Посещение зафиксировано</p>
                        <?php endif; ?>
                    </div>
                </div>
                <br><br>
            <?php endif; ?>
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
            ]); ?>
            <br>
            <?php if ($item->photo) { ?>
                <h4>Фотографии</h4>
                <?php foreach ($item->photo as $photo) { ?>
                    <div class="photo" style="float: left; margin-right: 20px ">
                        <img src="<?= $photo->thumbnail ?>" alt="">
                        <?= Html::a('Скачать файл', ['card/download', 'id' => $photo->id], ['data-pjax' => '0']) ?>
                        <?php ?>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <h4>Фотографий нет</h4>
            <?php } ?>
            <?php $visit_number--; ?>
            <?php Pjax::end(); ?>
        </div>
    <?php } ?>
</div>