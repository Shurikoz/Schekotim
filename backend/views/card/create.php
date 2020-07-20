<?php

use kartik\date\DatePicker;
use rmrevin\yii\fontawesome\FAS;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = 'Создание новой карты пациента';

$admin = Yii::$app->user->can('admin');

?>
<div class="card-create">
    <?= Html::a(FAS::icon('angle-left', ['class' => 'big', 'data-role' => 'arrow']) . '&nbsp Отмена', ['card/index'], ['class' => 'btn btn-default']) ?>
    <br>
    <br>
    <div class="row">
        <div class="col-md-12">
            <p class="titleNormal"><?= Html::encode($this->title) ?></p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <b>Город:</b> <?= $user->city->name;?>

        </div>
        <div class="col-md-4 col-sm-6">
            <b>Точка:</b> <?= $user->address_point->address_point; ?>

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
        <?php //TODO убрать блок ?>
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="box">
                    <?= $form->field($cardModel, 'number')->textInput() ?>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <p>Номер последней введенной карты: <b><?= $card->number ?></b></p>
            </div>
        </div>
        <?php //TODO убрать блок ?>

        <?= $form->field($cardModel, 'user_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false); ?>
        <?php if (!$admin) { ?>
            <?= $form->field($cardModel, 'city_id')->hiddenInput(['value' => Yii::$app->user->identity->city_id])->label(false); ?>
            <?= $form->field($cardModel, 'address_point_id')->hiddenInput(['value' => Yii::$app->user->identity->address_point_id])->label(false); ?>
        <?php } ?>
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
            <div class="col-md-4 col-sm-6">
                <div class="box">
                    <?php echo $form->field($cardModel, 'birthday')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Дата рождения'],
                        'removeButton' => false,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'todayHighlight' => true,
                            'endDate' => date('Ymd'),
                        ],
                        'options' => ['placeholder' => 'дд.мм.гггг', 'onchange' => 'checkCard()', 'id' => 'birthday']
                    ]);
                    ?>
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
                    <?= $form->field($cardModel, 'representative', ['labelOptions' => ['class' => 'control-label']])->textarea()->label(''); ?>
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

            <?php if ($admin) { ?>
                <!--для администратора сделаем доступным отдельный ввод города, точки и специалиста
                    сначала выбираем город, затем адрес точки -->
                <div class="col-md-4 col-sm-6">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="titleMin">Выбор города</p>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <?= $form->field($cardModel, 'city')->dropDownList($cityList, ['prompt' => 'Выберите город',])->label('Город') ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
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
                                <?= $form->field($cardModel, 'address_point')->dropDownList([])->label('Адрес точки <div id="errorData" class="" style="float: right"></div>') ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if (!$admin) { ?>
                <div class="col-md-4 col-sm-6">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="titleMin">Выбор специалиста</p>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <?= $form->field($visitModel, 'specialist_id')->dropDownList($specialistList, ['prompt' => '-'])->label('Специалист') ?>

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
                    <?= Html::submitButton('Сохранить', [
                            'class' => 'btn btn-green pull-right',
                            'data' => [
                                'confirm' => 'Вы уверены что все заполнено верно? Дальнейшие изменения возможны только модератором!',
                                'method' => 'post',
                            ]
                        ]) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>
