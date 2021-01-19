<?php

use kartik\date\DatePicker;
use rmrevin\yii\fontawesome\FAS;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = 'Создание карты пациента';

$admin = Yii::$app->user->can('admin');

?>
<div class="card-create">
    <div class="row">
        <div class="col-md-12">
            <div class="pull-left">
                <?= Html::a(FAS::icon('angle-left', ['class' => 'big', 'data-role' => 'arrow']) . '&nbsp Отмена', ['/'], ['class' => 'btn btn-default']) ?>
            </div>
            <div class="pull-right">
                <span style="display: block;margin-top: 5px;" class="titleNormal"><?= Html::encode($this->title) ?></span>
            </div>
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
<!--        --><?php //if (!$admin) { ?>
<!--            --><?//= $form->field($cardModel, 'city_id')->hiddenInput(['value' => Yii::$app->user->identity->city_id])->label(false); ?>
<!--            --><?//= $form->field($cardModel, 'address_point_id')->hiddenInput(['value' => Yii::$app->user->identity->address_point_id])->label(false); ?>
<!--        --><?php //} ?>
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="box">
                    <?= $form->field($cardModel, 'surname')->textInput(['maxlength' => true, 'id' => 'surname']) ?>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="box">
                    <?= $form->field($cardModel, 'name')->textInput(['maxlength' => true, 'onchange' => 'checkCard()', 'id' => 'name']) ?>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="box">
                    <?= $form->field($cardModel, 'middle_name')->textInput(['maxlength' => true, 'onchange' => 'checkCard()', 'id' => 'middle_name']) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="box">
                    <?php echo $form->field($cardModel, 'birthday')->widget(DatePicker::classname(), [
                        'removeButton' => false,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'todayHighlight' => true,
                            'endDate' => date('Ymd'),
                            'startDate' => '01.01.1930'
                        ],
                        'options' => [
                            'placeholder' => 'дд.мм.гггг',
                            'onchange' => 'checkCard()',
                            'id' => 'birthday'
                        ]
                    ]);?>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="box">
                    <?= $form->field($cardModel, 'phone', ['labelOptions' => ['class' => 'control-label']])
                        ->widget(MaskedInput::className(), ['mask' => '+7 (999) 999 99 99'])
                        ->textInput(['placeholder' => $cardModel->getAttributeLabel('phone'), 'style' => 'width:150px']); ?>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="box">
                    <?= Html::checkbox('representative', false, ['label' => 'Представитель клиента', 'onchange' => 'cardRepresentative()']) ?>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 representative hide">
                <div class="box">
                    <?= $form->field($cardModel, 'representative', ['labelOptions' => ['class' => 'control-label']])->textarea()->label('Информация о представителе'); ?>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div id="checkCard"></div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', [
                            'class' => 'btn btn-green pull-right',
                            'data' => [
//                                'confirm' => 'Вы уверены что все заполнено верно? Дальнейшие изменения возможны только модератором!',
                                'method' => 'post',
                            ]
                        ]) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
