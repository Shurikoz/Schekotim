<?php

use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Visit */
/* @var $form yii\widgets\ActiveForm */

$problemName = ArrayHelper::map($problem, 'id', 'name');
array_unshift($problemName, '');
?>
<div class="visit-form">
    <div class="row">
        <div class="col-md-4">
            <div class="box">
                <b>Город:</b> <?= $location->city->name ?>
            </div>
        </div>
        <div class="col-md-5">
            <div class="box">
                <b>Точка:</b> <?= $location->address_point ?>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="box">
                <b>Подолог:</b> <?= $podolog->name ?>
            </div>
        </div>
    </div>
    <hr>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'card_number')->hiddenInput(['value' => (int)Yii::$app->request->get('card_number')])->label(false); ?>
    <?= $form->field($model, 'city_id')->hiddenInput(['value' => $location->city->id])->label(false); ?>
    <?= $form->field($model, 'address_point_id')->hiddenInput(['value' => $location->id])->label(false); ?>
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
                <?= $form->field($model, 'anamnes')->textarea(['value' => $problem->anamnes, 'rows' => 6]) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <?= $form->field($model, 'manipulation')->textarea(['value' => $problem->manipulation, 'rows' => 6]) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <?= $form->field($model, 'recommendation')->textarea(['value' => $problem->recommendation, 'rows' => 6]) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
            </div>
        </div>
    </div>
    <hr>
    <p class="titleNormal">Фотографии работ (максимум по 5 фотографий)</p>
    <br>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <?= $form->field($photoBefore, 'before[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('До обработки') ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <?= $form->field($photoAfter, 'after[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('После обработки') ?>
            </div>
        </div>
    </div>
    <hr>
    <div class="form-group pull-right">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'id' => 'submitFirstVisit']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>