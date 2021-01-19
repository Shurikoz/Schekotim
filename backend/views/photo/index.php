<?php

use newerton\fancybox3\FancyBox;
use rmrevin\yii\fontawesome\FAS;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VisitCardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фотографии работ';
$count_visits = (isset($_GET['per-page'])) ? $_GET['per-page'] : 10;

?>
<?= FancyBox::widget(); ?>
<div class="photo-index">
    <div class="row">
        <div class="col-md-12">
            <div class="pull-left">
                <?= Html::a(FAS::icon('angle-left', ['class' => 'big', 'data-role' => 'arrow']) . '&nbsp В главное меню', ['/'], ['class' => 'btn btn-default']) ?>
            </div>
            <div class="pull-right">
                <span style="display: block;margin-top: 5px;" class="titleNormal">Фотографии работ</span>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <?= $this->render('_search', [
                'searchModel' => $searchModel,
                'problem' => $problem,
                'filter' => $filter
            ]) ?>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="pull-left visitsOnPage">
                <span>Посещений на странице:</span>
                <?= Html::a(10, Url::current(['per-page' => 10]), ['class' => ($count_visits == 10) ? 'active' : '']) ?>
                <?= Html::a(20, Url::current(['per-page' => 20]), ['class' => ($count_visits == 20) ? 'active' : '']) ?>
                <?= Html::a(40, Url::current(['per-page' => 40]), ['class' => ($count_visits == 40) ? 'active' : '']) ?>
            </div>
            <div class="pull-right perPage">
                <?= LinkPager::widget([
                    'pagination' => $pages,
                    'maxButtonCount' => 5,
                    'firstPageLabel' => true,
                    'lastPageLabel' => true,
                ]); ?>
            </div>
            <br>
            <br>
            <br>
            <?php if ($dataProvider->models) { ?>
                <?php foreach ($dataProvider->models as $item) { ?>
                    <div class="blockCard <?= $item->used_photo == 1 ? 'usingCard' : '' ?>">
                        <div class="row">
                            <div class="col-md-7 col-sm-5">
                                <div class="row">
                                    <div class="col-md-3">
                                        <p><b>Карта: </b><?= $item->card_number ?></p>
                                    </div>
                                    <div class="col-md-3">
                                        <p><b>ID: </b><?= $item->id ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><b>Проблема: </b><?= $item->problem_id == '0' ? '<span class="text-red">Не указана</span>' : $item->problem->name ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-7">
                                <?php if ($item->used_photo == 0) { ?>
                                    <div class="pull-right">
                                        <?= Html::button('Показать информацию <span class="glyphicon glyphicon-arrow-down"></span>', [
                                            'class' => 'btn btn-default infoHiddenBlockBtn',
                                            'style' => 'margin: 3px;',
                                            'data' => ['id' => $item->id]
                                        ]) ?>
                                        <?= Html::a('<span class="glyphicon glyphicon-check"></span> Использовано', ['photo/used', 'id' => $item->id], [
                                            'class' => 'btn btn-green',
                                            'data' => [
                                                'confirm' => 'Отметить посещение использованными?',
                                            ],
                                        ]) ?>
                                    </div>
                                <?php } else { ?>
                                    <p class="pull-right" style="color: #000; font-weight: 700">Карточка помечена
                                        использованной</p>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="infoHiddenBlock<?= $item->id ?>" hidden>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="box">
                                        <p><b>Анамнез:</b></p>
                                        <br>
                                        <p><?= $item->anamnes == null ? 'Не заполнено' : nl2br($item->anamnes) ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="box">
                                        <p><b>Манипуляции:</b></p>
                                        <br>
                                        <p><?= $item->manipulation == null ? 'Не заполнено' : nl2br($item->manipulation) ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="box">
                                        <p><b>Рекомендации:</b></p>
                                        <br>
                                        <p><?= $item->recommendation == null ? 'Не заполнено' : nl2br($item->recommendation) ?></p>
                                    </div>
                                </div>
                                <?php if ($item->diagnosis) { ?>
                                    <div class="col-md-6">
                                        <div class="box">
                                            <p><b>Диагноз:</b></p>
                                            <br>
                                            <p><?= $item->diagnosis == null ? 'Не заполнено' : nl2br($item->diagnosis) ?></p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="box">
                                        <p><b>Комментарий:</b></p>
                                        <br>
                                        <p><?= $item->description == null ? 'Не заполнено' : nl2br($item->description) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                    <h4>Фото ДО</h4>
                                    <?php foreach ($item->photo as $photo) { ?>
                                        <?php if ($photo->made == 'before') { ?>
                                            <div class="photo" style="float: left; margin:0 0 20px 20px">
                                                <?= Html::a(Html::img($photo->thumbnail), $photo->url, ['data-fancybox' => true]); ?>
                                                <br>
                                                <br>
                                                <?= Html::a('<span class="glyphicon glyphicon-download-alt"></span> Обработанное', ['photo/download', 'id' => $photo->id, 'type' => 'processed']) ?>
                                                <br>
                                                <?= Html::a('<span class="glyphicon glyphicon-download-alt"></span> Оригинал', ['photo/download', 'id' => $photo->id, 'type' => 'original']) ?>
                                                <?php if ($photo->template) { ?>
                                                    <br>
                                                    <?= Html::a('<span class="glyphicon glyphicon-download-alt"></span> Шаблон', ['photo/download', 'id' => $photo->id, 'type' => 'template']) ?>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                    <h4>Фото ПОСЛЕ</h4>
                                    <?php foreach ($item->photo as $photo) { ?>
                                        <?php if ($photo->made == 'after') { ?>
                                            <div class="photo" style="float: left; margin:0 0 20px 20px">
                                                <?= Html::a(Html::img($photo->thumbnail), $photo->url, ['data-fancybox' => true]); ?>
                                                <br>
                                                <br>
                                                <?= Html::a('<span class="glyphicon glyphicon-download-alt"></span> Обработанное', ['photo/download', 'id' => $photo->id, 'type' => 'processed']) ?>
                                                <br>
                                                <?= Html::a('<span class="glyphicon glyphicon-download-alt"></span> Оригинал', ['photo/download', 'id' => $photo->id, 'type' => 'original']) ?>
                                                <?php if ($photo->template) { ?>
                                                    <br>
                                                    <?= Html::a('<span class="glyphicon glyphicon-download-alt"></span> Шаблон', ['photo/download', 'id' => $photo->id, 'type' => 'template']) ?>
                                                <?php } ?>

                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                            </div>
                        </div>
                    </div>
                    <br>
                <?php } ?>

            <?php } else { ?>
                <div align="center">Ничего не найдено</div>
            <?php } ?>
            <div class="pull-right">
                <?= LinkPager::widget([
                    'pagination' => $pages,
                    'maxButtonCount' => 5,
                    'firstPageLabel' => true,
                    'lastPageLabel' => true,
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
</div>

