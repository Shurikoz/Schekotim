<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PhotoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фотографии работ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <br><br>

    <?php foreach (array_reverse($model) as $item) { ?>
        <h4>ID: <?= $item->id ?></h4>
        <div class="box">
            <?= DetailView::widget([
                'model' => $item,
                'attributes' => [
                    'reason',
                    'manipulation',
                    'recommendation',
                    'description',
                    'used_photo',
                ],
            ]); ?>
        </div>

        <?php if (!$item->used_photo == 1) { ?>
            <div>
                <?= Html::a('Использовано', ['photo/used', 'id' => $item->id], [
                    'class' => 'btn btn-success',
                    'data' => [
                        'confirm' => 'Отметить фото использованными?',
                    ],
                ]) ?>
            </div>
        <?php } ?>
        <br>
        <div class="col-md-6">
            <div class="box">
                <h4>Фото ДО</h4>
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
        <div class="col-md-6">
            <div class="box">
                <h4>Фото ПОСЛЕ</h4>
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

        <div class="row">
            <div class="col-md-12">
                <hr style="margin: 35px 0;">
            </div>
        </div>

    <?php } ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--    --><? //= GridView::widget([
    //        'dataProvider' => $dataProvider,
    //        'filterModel' => $searchModel,
    //        'columns' => [
    //            ['class' => 'yii\grid\SerialColumn'],
    //            'id',
    //            'visit_id',
    //            'url:ntext',
    //            'thumbnail:ntext',
    //            [
    //                'label' => 'Картинка',
    //                'format' => 'raw',
    //                'value' => function ($data) {
    //                    return Html::img($data->thumbnail);
    //                },
    //            ],
    //            'used:ntext',
    //            ['class' => 'yii\grid\ActionColumn'],
    //        ],
    //    ]); ?>
</div>

