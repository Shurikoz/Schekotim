<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Visit */
/* @var $form yii\widgets\ActiveForm */

$problem = ArrayHelper::map($problem, 'id', 'name');

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
                    ->dropDownList($problem)
                    ->label('Проблема') ?>
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
    </div>
    <hr>
    <div class="row">
        <div class="col-md-3">
            <div class="box">
                <?= $form->field($model, 'next_visit_from')->textInput(['type' => 'date']) ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box">
                <?= $form->field($model, 'next_visit_by')->textInput(['type' => 'date']) ?>
            </div>
        </div>
    </div>




    <?= $form->field($model, 'has_come')->checkbox(['value' => '1', 'checked ' => false])->label(''); ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
