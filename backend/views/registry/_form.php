<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

?>

<div class="registry-create">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <?= $form->field($model, 'number')->textInput() ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-6 col-sm-12">
            <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
                'options' => [
                    'placeholder' => 'дд.мм.гггг',
                    'class' => 'c-input'
                ],
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
//                    'startDate' => date('Ymd'),
//                    'endDate' => date('Ymd'),
                    'todayHighlight' => true,
                ]
            ]) ?>

            <?= $form->field($model, 'course')->textInput(['maxlength' => true]) ?>

        </div>

        <div class="col-md-12 col-sm-12">
            <div class="form-group pull-right">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-green']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

