<?php

use kartik\date\DatePicker;
use rmrevin\yii\fontawesome\FAS;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

?>
<hr>
<div class="row">
    <div class="col-md-4">
            <b>Город:</b> <?= Yii::$app->user->identity->city ?>
        </div>
    <div class="col-md-4">
            <b>Точка:</b> <?= Yii::$app->user->identity->address_point ?>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <p class="titleMin">Общие данные</p>
    </div>
</div>
<div class="card-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($cardModel, 'user_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false); ?>
    <?= $form->field($cardModel, 'city')->hiddenInput(['value' => Yii::$app->user->identity->city])->label(false); ?>
    <?= $form->field($cardModel, 'address_point')->hiddenInput(['value' => Yii::$app->user->identity->address_point])->label(false); ?>

    <div class="row">
        <div class="col-md-4">
            <div class="box">
                <?= $form->field($cardModel, 'surname')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box">
                <?= $form->field($cardModel, 'name')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box">
                <?= $form->field($cardModel, 'middle_name')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="col-md-4">
            <div class="box">
                <?php echo $form->field($cardModel, 'birthday')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Дата рождения'],
                    'removeButton' => false,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'todayHighlight' => true,
                        'endDate' => date('Ymd'),
                    ],
                    'options' => ['placeholder' => 'дд.мм.гггг']
                ]);
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box">
                <?= $form->field($cardModel, 'phone', ['labelOptions' => ['class' => 'control-label']])
                    ->widget(MaskedInput::className(), ['mask' => '+7 (999) 999 99 99'])
                    ->textInput(['placeholder' => $cardModel->getAttributeLabel('phone'), 'style' => 'width:150px']); ?>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Сохранить', [
                    'class' => 'btn btn-lg btn-green pull-right',
                    'data' => [
                        'method' => 'post',
                    ]
                ]) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
