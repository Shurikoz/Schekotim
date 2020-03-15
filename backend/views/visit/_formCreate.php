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
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'card_number')->hiddenInput(['value' => (int)Yii::$app->request->get('card_number')])->label(false); ?>
    <?= $form->field($model, 'city_id')->hiddenInput(['value' => $location->city->id])->label(false); ?>
    <?= $form->field($model, 'address_point_id')->hiddenInput(['value' => $location->id])->label(false); ?>
    <?= $form->field($model, 'podolog_id')->hiddenInput(['value' => $podolog->id])->label(false); ?>

    <div class="row">
        <div class="col-md-4">
            <div class="box">
                <?= $form->field($model, 'problem_id')
                    ->dropDownList($problemName)
                    ->label('Проблема') ?>
                <div id="errorData"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box">
                <?= $form->field($model, 'has_come')->checkbox(['value' => '1', 'checked ' => true])->label(false); ?>
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
    <hr style="border-color: red">

    <?= Html::button('Назначить следующее посещение', ['class' => 'btn btn-primary setSecondVisit']) ?>
    <br>
    <br>
    <div class="secondVisit hide">
        <div class="row">
            <div class="col-md-4">
                <div class="box">
                    <?php
                    echo '<label class="control-label">Назначение даты (разделитель « - »)</label>';
                    echo DatePicker::widget([
                        'model' => $model,
                        'name' => 'next_visit_from',
                        'attribute' => 'next_visit_from',
                        'value' => 'день-месяц-год',
                        'type' => DatePicker::TYPE_RANGE,
                        'name2' => 'next_visit_by',
                        'attribute2' => 'next_visit_by',
                        'value2' => 'день-месяц-год',
                        'separator' => 'по',
                        'pluginOptions' => [
                            'autoclose' => false,
                            'format' => 'dd-mm-yyyy',
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <hr>
    </div>
    <div class="form-group pull-right">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
