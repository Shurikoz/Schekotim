<?php

use yii\helpers\Html;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Visit */
$this->title = 'Новое посещение, карта №: ' . $card->number;

$problemName = ArrayHelper::map($problem, 'id', 'name');
array_unshift($problemName, '');

//посчитаем возраст пациента по дате рождения
$born = new DateTime($card->birthday); // дата рождения
$age = $born->diff(new DateTime)->format('%y');

?>
<div class="visit-create">

    <div class="row">
        <div class="col-md-12">
            <?= Html::button('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Отмена', [
                'class' => 'btn btn-default',
                'onclick' => 'history.back();'
            ]) ?>        </div>
    </div>
    <br>
    <p class="titleNormal"><?= Html::encode($this->title) ?></p>
    <hr>
    <div class="visit-form"><div class="row">
            <div class="col-md-4">
                <b>Пациент:</b> <?= $card->surname ?> <?= $card->name ?> <?= $card->middle_name ?></p>
            </div>
            <div class="col-md-4">
                <b>Возраст:</b> <?= $age ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <b>Город:</b> <?= $user->city->name ?>
            </div>
            <div class="col-md-4">
                <b>Точка:</b> <?= $user->address_point->address_point ?>
            </div>
            <div class="col-md-4">
                <b>Подолог:</b> <?= $podolog->name ?>
            </div>
        </div>
        <hr>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $form->field($model, 'card_number')->hiddenInput(['value' => (int)Yii::$app->request->get('number')])->label(false); ?>
        <?= $form->field($model, 'city_id')->hiddenInput(['value' => Yii::$app->user->identity->city_id])->label(false); ?>
        <?= $form->field($model, 'address_point_id')->hiddenInput(['value' => Yii::$app->user->identity->address_point_id])->label(false); ?>
        <?= $form->field($model, 'podolog_id')->hiddenInput(['value' => $podolog->id])->label(false); ?>
        <div class="row">
            <div class="col-md-4">
                <div class="box">
                    <?= $form->field($model, 'problem_id')
                        ->dropDownList($problemName)
                        ->label('Проблема <div id="errorData" class="" style="float: right"></div>') ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box">
                    <?= Html::checkbox('secondVisit', false, ['label' => 'Назначить повторное посещение', 'onchange' => 'dateVisit()']) ?>
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
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <?= $form->field($model, 'anamnes')->textarea(['value' => '', 'rows' => 6]) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <?= $form->field($model, 'manipulation')->textarea(['value' => '', 'rows' => 6]) ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box">
                    <?= $form->field($model, 'recommendation')->textarea(['value' => '', 'rows' => 6]) ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box">
                    <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
                </div>
            </div>
        </div>
        <hr>
        <p class="titleNormal">Рекомендовано посещение:</p>
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

        <p class="titleNormal">Фотографии работ (максимум по 5 фотографий)</p>
        <br>
        <div class="row">
            <div class="col-md-6">
                <p><b>До манипуляций</b></p>
                <br>
                <div class="box">
                    <?= $form->field($photoBefore, 'before[]')
                        ->widget(FileInput::classname(), [
                            'options' => [
                                'multiple' => true,
                                'accept' => 'image/*',
                            ],
                            'pluginOptions' => [
                                'showUpload' => false,
                                'previewFileType' => 'image',
                                'allowedFileExtensions' => ['jpg', 'jpeg'],
                                'maxFileCount' => 5,
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
                        ])?>
                </div>
            </div>
            <div class="col-md-6">
                <p><b>После манипуляций</b></p>
                <br>
                <div class="box">
                    <?= $form->field($photoAfter, 'after[]')
                        ->widget(FileInput::classname(), [
                            'options' => [
                                'multiple' => true,
                                'accept' => 'image/*',
                            ],
                            'pluginOptions' => [
                                'previewFileType' => 'image',
                                'allowedFileExtensions' => ['jpg', 'jpeg'],
                                'showUpload' => false,
                                'maxFileCount' => 5,
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
                        ])?>

                </div>
            </div>
        </div>
        <hr>
        <div class="form-group pull-right">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>


</div>
