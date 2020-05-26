<?php

use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$podologList = ArrayHelper::map($podologModel, 'id', 'name');
$cityList = ArrayHelper::map($cityModel, 'id', 'name');

?>
<div class="row">
    <div class="col-md-12">
        <p class="titleNormal"><?= Html::encode($this->title) ?></p>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-4">
            <b>Город:</b> <?= Yii::$app->user->identity->city == 'admin' ? 'Укажите город' : Yii::$app->user->identity->city;?>
        </div>
    <div class="col-md-4">
            <b>Точка:</b> <?= Yii::$app->user->identity->address_point == 'admin' ? 'Укажите адрес точки' : Yii::$app->user->identity->address_point; ?>
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
    <?php if (!Yii::$app->user->can('admin')) { ?>
        <?= $form->field($cardModel, 'city')->hiddenInput(['value' => Yii::$app->user->identity->city])->label(false); ?>
        <?= $form->field($cardModel, 'address_point')->hiddenInput(['value' => Yii::$app->user->identity->address_point])->label(false); ?>
    <?php } ?>
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

        <?php if (Yii::$app->user->can('admin')) { ?>
            <!--для администратора сделаем доступным отдельный ввод города, точки и специалиста
                сначала выбираем город, затем адрес точки -->
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <p class="titleMin">Выбор города</p>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <?= $form->field($cardModel, 'city')
                                ->dropDownList($cityList)
                                ->label('Город') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <p class="titleMin">Адрес точки</p>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <!-- Получим список точек из AJAX запрса по выбранному городу -->
                            <?= $form->field($cardModel, 'address_point')
                                ->dropDownList([])
                                ->label('Адрес точки <div id="errorData" class="" style="float: right"></div>') ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if (!Yii::$app->user->can('admin')) { ?>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <p class="titleMin">Выбор специалиста</p>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <?= $form->field($visitModel, 'podolog_id')
                                ->dropDownList($podologList)
                                ->label('Подолог') ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php if (!Yii::$app->user->can('admin')) { ?>
                <?= Html::submitButton('Сохранить', [
                    'class' => 'btn btn-lg btn-green pull-right',
                    'data' => [
                        'confirm' => 'Вы уверены что все заполнено верно? Дальнейшие изменения возможны только модератором!',
                        'method' => 'post',
                    ]
                ]) ?>
                <?php } else {?>
                    <?= Html::submitButton('Сохранить', [
                        'class' => 'btn btn-lg btn-green pull-right',
                        'data' => [
                            'method' => 'post',
                        ]
                    ]) ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
