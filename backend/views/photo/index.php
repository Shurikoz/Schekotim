<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VisitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фотографии работ';
$count_visits = ($_GET['per-page']) ? $_GET['per-page'] : 20;

$_GET['VisitSearch']['used_photo'] == '' ? $all = 'active' : $all = '';
$_GET['VisitSearch']['used_photo'] == '1' ? $usedPhoto1 = 'active' : $usedPhoto1 = '';
$_GET['VisitSearch']['used_photo'] == '0' ? $usedPhoto0 = 'active' : $usedPhoto0 = '';

?>
<div class="photo-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <br>
    <br>
    <div class="visit-search">
        <div class="box">
            <div class="col-sm-12">
                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                ]); ?>
                <?= Html::button('Сбросить', ['class' => 'btn btn-default resetFormButton pull-right']) ?>
                <p class="titleNormal">Фильтр</p>
                <hr>
                <div class="row">
                    <div class="col-md-2">
                        <div class="c-field">
                            <?= $form->field($searchModel, 'card_number')->textInput(['class' => 'autoSearchSubmit c-input'])->label('Номер карты', ['class' => 'c-field__label']) ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="c-field">
                            <?= $form->field($searchModel, 'id')->textInput(['class' => 'autoSearchSubmit c-input'])->label('Номер посещения', ['class' => 'c-field__label']) ?>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="searchVisit">
                            <?= Html::a('Все', Url::current(['VisitSearch[used_photo]' => '']), ['class' => 'btnSearchVisit ' . $all]) ?>
                        </div>
                        <div class="searchVisit">
                            <?= Html::a('Использованы', Url::current(['VisitSearch[used_photo]' => '1']), ['class' => 'btnSearchVisit ' . $usedPhoto1]) ?>
                        </div>
                        <div class="searchVisit">
                            <?= Html::a('Не использованы', Url::current(['VisitSearch[used_photo]' => '0']), ['class' => 'btnSearchVisit ' . $usedPhoto0]) ?>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <br>
        <div class="pull-left visitsOnPage">
            <span>Посещений на странице:</span>
            <?= Html::a(20, Url::current(['per-page' => 20]), ['class' => ($count_visits == 20) ? 'active' : '']) ?>
            <?= Html::a(40, Url::current(['per-page' => 40]), ['class' => ($count_visits == 40) ? 'active' : '']) ?>
            <?= Html::a(60, Url::current(['per-page' => 60]), ['class' => ($count_visits == 60) ? 'active' : '']) ?>
        </div>
        <div class="pull-right perPage">
            <?= LinkPager::widget([
                'pagination' => $pages,
                'maxButtonCount' => 5,
            ]); ?>
        </div>
        <br>
        <br>
        <br>

        <?php // TODO Исправить timeout?>
        <?php foreach ($dataProvider->models as $item) { ?>
            <div class="blockCard <?= $item->used_photo == 1 ? 'usingCard' : '' ?>">
                <?php if ($item->used_photo != 1) { ?>
                    <div class="pull-right">
                        <?= Html::a('<span class="glyphicon glyphicon-check"></span> Использовано', ['photo/used', 'id' => $item->id], [
                            'class' => 'btn btn-info',
                            'data' => [
                                'confirm' => 'Отметить посещение использованными?',
                            ],
                        ]) ?>
                    </div>
                <?php } else { ?>
                    <p class="pull-right" style="color: #000; font-weight: 700">Карточка помечена использованной</p>
                <?php } ?>
                <br>
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <div class="box">
                            <p><b>Номер карты:</b></p>
                            <p><?= $item->card_number ?></p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="box">
                            <p><b>Номер посещения:</b></p>
                            <p><?= $item->id ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="box">
                            <p><b>Анамнез:</b></p>
                            <br>
                            <p><?= $item->anamnes == null ? 'Не заполнено' : $item->manipulation ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box">
                            <p><b>Манипуляции:</b></p>
                            <br>
                            <p><?= $item->manipulation == null ? 'Не заполнено' : $item->manipulation ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="box">
                            <p><b>Рекомендации:</b></p>
                            <br>
                            <p><?= $item->recommendation == null ? 'Не заполнено' : $item->recommendation ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box">
                            <p><b>Комментарий:</b></p>
                            <br>
                            <p><?= $item->description == null ? 'Не заполнено' : $item->description ?></p>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="box">
                            <h4>Фото ДО</h4>
                            <?php foreach ($item->photo as $photo) { ?>
                                <?php if ($photo->made == 'before') { ?>
                                    <div class="photo" style="float: left; margin:0 0 20px 20px">
                                        <?= Html::a('<img src="' . $photo->thumbnail . '">', $photo->url, ['target' => '_blank']) ?>
                                        <br>
                                        <?= Html::a('<span class="glyphicon glyphicon-download-alt"></span> Скачать', ['photo/download', 'id' => $photo->id]) ?>
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
                                    <div class="photo" style="float: left; margin:0 0 20px 20px">
                                        <?= Html::a('<img src="' . $photo->thumbnail . '">', $photo->url, ['target' => '_blank']) ?>
                                        <br>
                                        <?= Html::a('<span class="glyphicon glyphicon-download-alt"></span> Скачать', ['photo/download', 'id' => $photo->id]) ?>
                                        <?php ?>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <hr style="margin: 35px 0;border: 2px solid #7ba335;">
                </div>
            </div>
        <?php } ?>
        <div class="pull-right">
            <?= LinkPager::widget([
                'pagination' => $pages,
                'maxButtonCount' => 5,
            ]); ?>
        </div>

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

