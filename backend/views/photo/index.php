<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use newerton\fancybox3\FancyBox;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VisitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фотографии работ';
$count_visits = (isset($_GET['per-page'])) ? $_GET['per-page'] : 10;

?>
<?= FancyBox::widget();?>

<div class="row">
    <div class="col-md-12">
        <h3><?= Html::encode($this->title) ?></h3>
        <hr>
    </div>
</div>
<div class="photo-index">
    <div class="visit-search">
        <div class="box">
            <div class="col-sm-12">
                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                ]); ?>
                <?= Html::button('Сбросить фильтры', ['class' => 'btn btn-default resetFormButton pull-right']) ?>
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
                            <?= $form->field($searchModel, 'number')->textInput(['class' => 'autoSearchSubmit c-input'])->label('Номер посещения', ['class' => 'c-field__label']) ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="c-field">
                            <?= $form->field($searchModel, 'problem')->dropDownList($problem, ['prompt' => 'Все','class' => 'autoSearchSubmit c-input'])->label('Проблема', ['class' => 'c-field__label']) ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="c-field">
                            <?= $form->field($searchModel, 'used_photo')->dropDownList($filter, ['prompt' => 'Все', 'class' => 'autoSearchSubmit c-input'])->label('Фильтр использованных фотографий', ['class' => 'c-field__label']) ?>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <br>
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
            ]); ?>
        </div>
        <br>
        <br>
        <br>

        <?php // TODO Исправить timeout?>
        <?php if ($dataProvider->models) { ?>
            <?php foreach ($dataProvider->models as $item) { ?>
                <?php if ($item->photo != null) { ?>
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
                            <p class="pull-right" style="color: #000; font-weight: 700">Карточка помечена
                                использованной</p>
                        <?php } ?>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="box">
                                    <p><b>Номер карты:</b></p>
                                    <p><?= $item->card_number ?></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="box">
                                    <p><b>Номер посещения:</b></p>
                                    <p><?= $item->number ?></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="box">
                                    <p><b>Проблема:</b></p>
                                    <?php if ($item->problem_id == '0') { ?>
                                        <span class="text-red">Не указана</span>
                                    <?php } else { ?>
                                        <p><?= $item->problem->name ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?= Html::button('Показать информацию <span class="glyphicon glyphicon-arrow-down"></span>', [
                                    'class' => 'btn btn-default infoHiddenBlockBtn',
                                    'style' => 'margin: 3px;',
                                    'data' => ['id' => $item->id]
                                ]) ?>
                            </div>
                        </div>
                        <div class="infoHiddenBlock<?= $item->id ?>" hidden>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="box">
                                        <p><b>Анамнез:</b></p>
                                        <br>
                                        <p><?= $item->anamnes == null ? 'Не заполнено' : nl2br($item->manipulation) ?></p>
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
                                <div class="col-md-6">
                                    <div class="box">
                                        <p><b>Комментарий:</b></p>
                                        <br>
                                        <p><?= $item->description == null ? 'Не заполнено' : nl2br($item->description) ?></p>
                                    </div>
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
                                                <?= Html::a(Html::img($photo->thumbnail), $photo->url, ['data-fancybox' => true]);?>
                                                <br>
                                                <?= Html::a('<span class="glyphicon glyphicon-download-alt"></span> Обработанное', ['photo/download', 'id' => $photo->id, 'type' => 'processed']) ?>                                                <br>
                                                <?= Html::a('<span class="glyphicon glyphicon-download-alt"></span> Оригинал', ['photo/download', 'id' => $photo->id, 'type' => 'original']) ?>
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
                                                <?= Html::a(Html::img($photo->thumbnail), $photo->url, ['data-fancybox' => true]);?>
                                                <br>
                                                <?= Html::a('<span class="glyphicon glyphicon-download-alt"></span> Обработанное', ['photo/download', 'id' => $photo->id, 'type' => 'processed']) ?>                                                <br>
                                                <?= Html::a('<span class="glyphicon glyphicon-download-alt"></span> Оригинал', ['photo/download', 'id' => $photo->id, 'type' => 'original']) ?>
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
                <?php } else { ?>
                    <div class="blockCard <?= $item->used_photo == 1 ? 'usingCard' : '' ?>">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="box">
                                    <p><b>Номер карты:</b></p>
                                    <p><?= $item->card_number ?></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="box">
                                    <p><b>Номер посещения:</b></p>
                                    <p><?= $item->number ?></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="box">
                                    <p><b>Проблема:</b></p>
                                    <?php if ($item->problem_id == '0') { ?>
                                        <span class="text-red">Не указана</span>
                                    <?php } else { ?>
                                        <p><?= $item->problem->name ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?= Html::button('Показать информацию <span class="glyphicon glyphicon-arrow-down"></span>', [
                                    'class' => 'btn btn-default infoHiddenBlockBtn',
                                    'style' => 'margin: 3px;',
                                    'data' => ['id' => $item->id]
                                ]) ?>
                            </div>
                        </div>
                        <div class="infoHiddenBlock<?= $item->id ?>" hidden>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="box">
                                        <p><b>Анамнез:</b></p>
                                        <br>
                                        <p><?= $item->anamnes == null ? 'Не заполнено' : nl2br($item->manipulation) ?></p>
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
                                <div class="col-md-6">
                                    <div class="box">
                                        <p><b>Комментарий:</b></p>
                                        <br>
                                        <p><?= $item->description == null ? 'Не заполнено' : nl2br($item->description) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box">
                                    <p style="color: red" align="center">Фотографии не добавлены!</p>
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
            <?php } ?>

        <?php } else {?>
            <div align="center">Ничего не найдено</div>
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

