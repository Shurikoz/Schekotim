<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;

$this->title = 'Создать новую акцию';
?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-left">
            <?= Html::a('Отмена', ['/stock/index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3><?= Html::encode($this->title) ?></h3>
        <hr>
    </div>
</div>
<div class="stock-create">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'text')->widget(Widget::className(), [
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 200,
                    'plugins' => [
                        'clips',
                        'fullscreen',
                    ],
                    'clips' => [
                        ['Lorem ipsum...', 'Lorem...'],
                        ['red', '<span class="label-red">red</span>'],
                        ['green', '<span class="label-green">green</span>'],
                        ['blue', '<span class="label-blue">blue</span>'],
                    ],
                ],
            ]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'endtime')->widget(DatePicker::classname(), [
                'options' => [
                    'placeholder' => 'дд.мм.гггг',
                    'class' => 'c-input'
                ],
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
                    'startDate' => date('Ymd'),
                    'todayHighlight' => true,
                ]
            ]) ?>
            <br>
            <?= $form->field($model, 'public')->checkbox(['value' => '1', 'checked ' => false])->label(false); ?>
            <br>
            <?= $form->field($model, 'file')->fileInput() ?>
            <br>

        </div>
        <div class="col-md-12 col-sm-12">
            <div class="form-group pull-right">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-green']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
