<?php

use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model backend\models\Visit */

$this->title = 'Редактирование посещения, карта №: ' . $model->card_number;

$problemName = ArrayHelper::map($problem, 'id', 'name');
array_unshift($problemName, '');
$card_id = (int)Yii::$app->request->get('number');

//посчитаем возраст пациента по дате рождения
$born = new DateTime($card->birthday); // дата рождения
$age = $born->diff(new DateTime)->format('%y');
?>
<div class="visit-update">
<div class="row">
    <div class="col-md-12">
        <?= Html::a('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Отмена', ['/card/view', 'number' => $model->card_number], ['class' => 'btn btn-default']) ?>
    </div>
</div>
    <br>
    <p class="titleNormal"><?= Html::encode($this->title) ?></p>
    <hr>
    <div class="visit-form">
        <div class="row">
            <div class="col-md-4">
                <b>Пациент:</b> <?= $card->surname ?> <?= $card->name ?> <?= $card->middle_name ?></p>
            </div>
            <div class="col-md-4">
                <b>Возраст:</b> <?= $age ?>
            </div>
            <div class="col-md-4">
                <b>Дата посещения:</b> <?= date('d.m.Y H:i', $model->visit_date)?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <b>Город:</b> <?= $model->city->name ?>
            </div>
            <div class="col-md-4">
                <b>Точка:</b> <?= $model->address_point->address_point ?>
            </div>
            <div class="col-md-4">
                <b>Подолог:</b> <?= $podolog->name ?>
            </div>
        </div>
        <hr>
        <?php $form = ActiveForm::begin(['id' => 'formUpdate']); ?>
        <?= $form->field($model, 'card_number')->hiddenInput(['value' => $card_id])->label(false); ?>
        <?= $form->field($model, 'city_id')->hiddenInput(['value' => $model->city_id])->label(false); ?>
        <?= $form->field($model, 'address_point_id')->hiddenInput(['value' => $model->address_point_id])->label(false); ?>
        <?= $form->field($model, 'podolog_id')->hiddenInput(['value' => $podolog->id])->label(false); ?>
        <div class="row">
            <div class="col-md-4">
                <div class="box">
                    <?= $form->field($model, 'problem_id')
                        ->dropDownList($problemName)
                        ->label('Проблема') ?>
                    <div id="errorData" style="color:red"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box">
                    <?= Html::checkbox('secondVisit', false, ['label' => 'Назначить повторное посещение', 'id' => 'secondVisit', 'onchange' => 'dateVisitUpdate()']) ?>
                </div>
            </div>
            <div class="col-md-4 dateVisit hide">
                <div class="box">
                    <?php
                    echo '<p><label class="control-label">Назначение даты</label></p>';
                    echo DatePicker::widget([
                        'model' => $secondVisit,
                        'name' => 'next_visit_from',
                        'attribute' => 'next_visit_from',
                        'value' => date("m.d.y"),
                        'type' => DatePicker::TYPE_RANGE,
                        'name2' => 'next_visit_by',
                        'attribute2' => 'next_visit_by',
                        'value2' => date("m.d.y"),
                        'separator' => 'по',
                        'options' => [
                            'placeholder' => 'с день.мес.год',
                            'required' => false,
                        ],
                        'options2' => [
                            'placeholder' => 'по день.мес.год',
                            'required' => false,
                        ],
                        'pluginOptions' => [
                            'autoclose' => false,
                            'format' => 'dd.mm.yyyy',
                            'todayHighlight' => true,
                            'startDate' => date('Ymd'),
                        ]
                    ]);
                    ?>
                </div>
            </div>

        </div>
        <div class="row">

            <div class="col-md-3">
                <div class="box">
                    <?= $form->field($model, 'has_come')->checkbox(['value' => '1', 'checked ' => false])->label(false); ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box">
                    <?= $form->field($model, 'resolve')->checkbox(['value' => '1', 'checked ' => false, 'onchange' => 'visitResolve()'])->label(false); ?>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <?= $form->field($model, 'anamnes')->textarea(['rows' => 6]) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <?= $form->field($model, 'manipulation')->textarea(['rows' => 6]) ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box">
                    <?= $form->field($model, 'recommendation')->textarea(['rows' => 6]) ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box">
                    <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
                </div>
            </div>
        </div>
        <hr>
        <p class="titleNormal">Рекомендовано посещение</p>
        <br>
        <div class="row">
            <div class="col-md-3">
                <div class="box">
                    <?= $form->field($model, 'dermatolog', ['options' => ['class' => 'form-checkbox']])->checkbox(); ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box">
                    <?= $form->field($model, 'immunolog', ['options' => ['class' => 'form-checkbox']])->checkbox(); ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box">
                    <?= $form->field($model, 'ortoped', ['options' => ['class' => 'form-checkbox']])->checkbox(); ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box">
                    <?= $form->field($model, 'hirurg', ['options' => ['class' => 'form-checkbox']])->checkbox(); ?>
                </div>
            </div>
        </div>
        <hr>
        <?php Pjax::begin(['timeout' => 30000, 'id' => 'photoEdit', 'enablePushState' => false]); ?>
        <div id="photoForm">
            <div class="row">
                <div class="col-md-12">
                    <div class="titleNormal">Фотографии работ (максимум по 5 фотографий)</div>
                    <br>
                </div>
                <div class="col-md-6">
                    <p><b>До манипуляций</b></p>
                    <?php if (count($photoBefore) < 5) { ?>
                        <div class="col-md-12">
                            <?= $form->field($addPhotoBefore, 'before[]')
                                ->widget(FileInput::classname(), [
                                    'options' => [
                                        'multiple' => true,
                                        'accept' => 'image/*'
                                    ],
                                    'pluginOptions' => [
                                        'previewFileType' => 'image',
                                        'allowedFileExtensions' => ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'PNG'],
                                        'showUpload' => false,
                                        'maxFileCount' => 5 - count($photoBefore),
                                        'uploadUrl' => Url::to(['']),
                                        'fileActionSettings' => [
                                            'showUpload' => false,
                                            'showZoom' => false,

                                        ],
                                        'showPreview' => true,
                                        'showRemove' => false,
                                        'showCaption' => false,
                                        'browseClass' => 'btn btn-primary btn-block',
                                    ]
                                ]) ?>
                        </div>
                    <?php } ?>
                    <?php for ($i = 0; $i <= 4; $i++) { ?>
                        <?php if (isset($photoBefore[$i])) { ?>
                            <div class="col-md-6" style="margin-bottom: 20px ">
                                <div id="box_<?= $i ?>" class="box">
                                    <span><?= Html::a('<img src="' . $photoBefore[$i]->thumbnail . '">', $photoBefore[$i]->url, ['target' => '_blank', 'data-pjax' => '0']) ?></span>
                                    <span style="margin-left: 20px">
                                <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['#'], [
                                    'class' => 'btn btn-sm btn-info',
                                    'onclick' =>
                                        "
                                    if (confirm('Вы уверены, что хотите удалить эту фотографию?')) {    
                                        $.ajax({
                                        type:'POST',
                                        cache: false,
                                        url: '" . Url::to(['visit/delete-photo', 'id' => $photoBefore[$i]->id]) . "',
                                        complete: function() {
                                            $.pjax.reload({container:'#photoEdit'});
                                        }
                                        });
                                    }
                                    return false;
                                ",
                                ]); ?>
                            </span>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="col-md-6">
                    <p><b>После манипуляций</b></p>
                    <?php if (count($photoAfter) < 5) { ?>
                        <div class="col-md-12">
                            <?= $form->field($addPhotoAfter, 'after[]')->widget(FileInput::classname(), [
                                'options' => [
                                    'multiple' => true,
                                    'accept' => 'image/*'
                                ],
                                'pluginOptions' => [
                                    'previewFileType' => 'image',
                                    'allowedFileExtensions' => ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'PNG'],
                                    'showUpload' => false,
                                    'maxFileCount' => 5 - count($photoAfter),
                                    'uploadUrl' => Url::to(['']),
                                    'fileActionSettings' => [
                                        'showUpload' => false,
                                        'showZoom' => false,

                                    ],
                                    'showPreview' => true,
                                    'showRemove' => false,
                                    'showCaption' => false,
                                    'browseClass' => 'btn btn-primary btn-block',
                                ]
                            ]) ?>
                        </div>
                    <?php } ?>
                    <?php for ($i = 0; $i <= 4; $i++) { ?>
                        <?php if (isset($photoAfter[$i])) { ?>
                            <div class="col-md-6" style="margin-bottom: 20px ">
                                <div class="box">
                                    <span><?= Html::a('<img src="' . $photoAfter[$i]->thumbnail . '">', $photoAfter[$i]->url, ['target' => '_blank', 'data-pjax' => '0']) ?></span>
                                    <span style="margin-left: 20px">
                            <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['#'], [
                                'class' => 'btn btn-sm btn-info',
                                'onclick' =>
                                    "
                                    if (confirm('Вы уверены, что хотите удалить эту фотографию?')) {    
                                        $.ajax({
                                        type:'POST',
                                        cache: false,
                                        url: '" . Url::to(['visit/delete-photo', 'id' => $photoAfter[$i]->id]) . "',
                                        complete: function() {
                                            $.pjax.reload({container:'#photoEdit'});
                                        }
                                        });
                                    }
                                    return false;
                                ",
                            ]); ?></span>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php Pjax::end(); ?>
        <hr>
        <div class="form-group pull-right">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-green']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
