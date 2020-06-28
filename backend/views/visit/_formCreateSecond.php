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

//посчитаем возраст пациента по дате рождения
$born = new DateTime($card->birthday); // дата рождения
$age = $born->diff(new DateTime)->format('%y');
?>
<hr>
<div class="visit-form">
    <div class="row">
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
            <b>Город:</b> <?= $visit->city->name ?>
        </div>
        <div class="col-md-4">
            <b>Точка:</b> <?= $visit->address_point->address_point ?>
        </div>
        <div class="col-md-4">
            <b>Подолог:</b> <?= $podolog->name ?>
        </div>
    </div>
    <hr>
    <?php $form = ActiveForm::begin(); ?>

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
                <?php
                echo '<p><label class="control-label">Назначение даты (разделитель « . »)</label></p>';
                echo DatePicker::widget([
                    'model' => $model,
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
                        'required' => true,
                    ],
                    'options2' => [
                        'placeholder' => 'по день.мес.год',
                        'required' => true,
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
    <div class="form-group pull-right">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
