<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PhotoSearch */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="visit-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-sm-6 col-xs-6">
            <p class="titleNormal">Фильтр</p>
        </div>
        <div class="col-sm-6 col-xs-6">
            <div class="pull-right">
                <!--                    <span class="openNewWindow">-->
                <!--                        <input type="checkbox" id="openNewWindow" name="openNewWindow">-->
                <!--                        <label for="openNewWindow" style="cursor:pointer;">Открывать карты в новом окне</label>-->
                <!--                    </span>-->
                <?= Html::button('Сбросить фильтры', ['class' => 'btn btn-default resetFormButton pull-right']) ?>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-2 col-sm-12">
            <div class="c-field">
                <?= $form->field($searchModel, 'card_number')->textInput(['placeholder' => 'Номер карты', 'class' => 'autoSearchSubmit c-input'])->label(false) ?>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="c-field">
                <?= $form->field($searchModel, 'problem')->dropDownList($problem, ['prompt' => 'Проблема', 'class' => 'autoSearchSubmit c-input'])->label(false) ?>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="c-field">
                <?= $form->field($searchModel, 'used_photo')->dropDownList($filter, ['prompt' => 'Фильтр фотографий', 'class' => 'autoSearchSubmit c-input'])->label(false) ?>
            </div>
        </div>
    </div>
    <hr>

    <?php ActiveForm::end(); ?>

