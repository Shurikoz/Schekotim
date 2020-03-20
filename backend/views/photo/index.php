<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\LinkPager;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PhotoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фотографии работ';
$this->params['breadcrumbs'][] = $this->title;
$count_visits = ($_GET['per-page']) ? $_GET['per-page'] : 20;

?>
<div class="photo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <br>
    <br>
    <div class="pull-left visitsOnPage">
        <span>Посещений на странице:</span>
        <?= Html::a(20, Url::current(['per-page' => 20]), ['class' => ($count_visits == 20) ? 'active' : '']) ?>
        <?= Html::a(40, Url::current(['per-page' => 40]), ['class' => ($count_visits == 40) ? 'active' : '']) ?>
        <?= Html::a(60, Url::current(['per-page' => 60]), ['class' => ($count_visits == 60) ? 'active' : '']) ?>
    </div>
    <br>
    <br>

    <?php foreach ($model as $item) { ?>
        <br>
        <div class="box">
            <?= DetailView::widget([
                'model' => $item,
                'attributes' => [
                    'id',
                    'anamnes',
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
                    'class' => 'btn btn-green',
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
    <?= LinkPager::widget([
        'pagination' => $pages,
        'maxButtonCount' => 5,
        'firstPageLabel' => 'Начало',
        'lastPageLabel' => 'Конец',
    ]); ?>
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

