<?php

use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\widgets\Pjax;
use nirvana\showloading\ShowLoadingAsset;

ShowLoadingAsset::register($this);

$this->title = 'Создание копии посещения, карта №: ' . $model->card_number;

$problemName = ArrayHelper::map($problem, 'id', 'name');
array_unshift($problemName, '');
$card_id = (int)Yii::$app->request->get('number');

//посчитаем возраст пациента по дате рождения
$born = new DateTime($card->birthday); // дата рождения
$age = $born->diff(new DateTime)->format('%y');
?>
<div id="visit-copy">
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
                <b>Подолог:</b> <?= $specialist->name ?>
            </div>
        </div>
        <hr>
        <?php $form = ActiveForm::begin(['id' => 'formUpdate']); ?>
        <?= $form->field($model, 'card_number')->hiddenInput(['value' => $card_id])->label(false); ?>
        <?= $form->field($model, 'city_id')->hiddenInput(['value' => $model->city_id])->label(false); ?>
        <?= $form->field($model, 'address_point_id')->hiddenInput(['value' => $model->address_point_id])->label(false); ?>
        <?= $form->field($model, 'problem_id')->hiddenInput(['value' => $model->problem->id])->label(false); ?>
        <div class="row">
            <div class="col-md-4">
                <div class="box">
                    <b>Проблема:</b> <?= $model->problem->name ?>
                </div>
            </div>
        </div>
<!--        --><?//= $form->field($model, 'specialist_id')->hiddenInput(['value' => $specialist->id])->label(false); ?>
<!--        <div class="row">-->
<!--            <div class="col-md-4">-->
<!--                <div class="box">-->
<!--                    --><?//= $form->field($model, 'problem_id')
//                        ->dropDownList($problemName)
//                        ->label('Проблема') ?>
<!--                    <div id="errorData" style="color:red"></div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
        <div class="row">
            <div class="col-md-3">
                <div class="box">
                    <?= $form->field($copyVisit, 'has_come')->checkbox(['value' => '1', 'checked ' => false])->label(false); ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box">
                    <?= $form->field($copyVisit, 'resolve')->checkbox(['value' => '0', 'checked ' => false])->label(false); ?>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <?= $form->field($copyVisit, 'anamnes')->textarea(['value' =>$model->anamnes, 'rows' => 6]) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <?= $form->field($copyVisit, 'manipulation')->textarea(['value' =>$model->manipulation, 'rows' => 6]) ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box">
                    <?= $form->field($copyVisit, 'recommendation')->textarea(['value' =>$model->recommendation, 'rows' => 6]) ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box">
                    <?= $form->field($copyVisit, 'description')->textarea(['value' =>$model->description, 'rows' => 2]) ?>
                </div>
            </div>
        </div>
        <hr>
        <p class="titleNormal">Рекомендовано посещение</p>
        <br>
        <div class="row">
            <div class="col-md-3">
                <div class="box">
                    <?= $form->field($copyVisit, 'dermatolog', ['options' => ['class' => 'form-checkbox']])->checkbox(['checked' => $model->dermatolog == 1 ? true : false]); ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box">
                    <?= $form->field($copyVisit, 'immunolog', ['options' => ['class' => 'form-checkbox']])->checkbox(['checked' => $model->immunolog == 1 ? true : false]); ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box">
                    <?= $form->field($copyVisit, 'ortoped', ['options' => ['class' => 'form-checkbox']])->checkbox(['checked' => $model->ortoped == 1 ? true : false]); ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box">
                    <?= $form->field($copyVisit, 'hirurg', ['options' => ['class' => 'form-checkbox']])->checkbox(['checked' => $model->hirurg == 1 ? true : false]); ?>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-group pull-right">
            <?= Html::submitButton('Сохранить копию', ['class' => 'btn btn-green', 'id' => 'saveBtn']) ?>

        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
