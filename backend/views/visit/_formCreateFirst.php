<?php

use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Visit */
/* @var $form yii\widgets\ActiveForm */

$problemName = ArrayHelper::map($problem, 'id', 'name');
array_unshift($problemName, '');
?>
<br>
<div class="visit-form">
    <div class="row">
        <div class="col-md-4">
            <b>Город:</b> <?= Yii::$app->user->identity->city ?>
        </div>
        <div class="col-md-4">
            <b>Точка:</b> <?= Yii::$app->user->identity->address_point ?>
        </div>
        <div class="col-md-4">
            <b>Подолог:</b> <?= $podolog->name ?>
        </div>
    </div>
    <hr>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'card_number')->hiddenInput(['value' => (int)Yii::$app->request->get('card_number')])->label(false); ?>
    <?= $form->field($model, 'city')->hiddenInput(['value' => Yii::$app->user->identity->city])->label(false); ?>
    <?= $form->field($model, 'address_point')->hiddenInput(['value' => Yii::$app->user->identity->address_point])->label(false); ?>
    <?= $form->field($model, 'podolog_id')->hiddenInput(['value' => $podolog->id])->label(false); ?>
    <div class="row">
        <div class="col-md-4">
            <div class="box">
                <?= $form->field($model, 'problem_id')
                    ->dropDownList($problemName)
                    ->label('Проблема <div id="errorData" class="" style="float: right"></div>') ?>
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
            <div class="box">
                <?= $form->field($photoBefore, 'before[]')
                    ->widget(FileInput::classname(), [
                        'options' => [
                            'multiple' => true,
                            'accept' => 'image/*'
                        ],
                        'pluginOptions' => [
                            'previewFileType' => 'image',
                            'allowedFileExtensions' => ['jpg', 'jpeg'],
                            'showUpload' => false,
                            'maxFileCount' => 5
                        ]
                    ])
                    ->label('До обработки') ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <?= $form->field($photoAfter, 'after[]')
                    ->widget(FileInput::classname(), [
                        'options' => [
                            'multiple' => true,
                            'accept' => 'image/*'
                        ],
                        'pluginOptions' => [
                            'previewFileType' => 'image',
                            'allowedFileExtensions' => ['jpg', 'jpeg'],
                            'showUpload' => false,
                            'maxFileCount' => 5
                        ]
                    ])
                    ->label('После обработки') ?>

            </div>
        </div>
    </div>
    <hr>
    <div class="form-group pull-right">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
