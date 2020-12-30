<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CardSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-search">
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
                <?= Html::button('Сбросить фильтр', ['class' => 'btn btn-default resetFormButton pull-right']) ?>
            </div>
        </div>
    </div>
    <br>

    <div class="row">
        <div class="col-md-4 col-sm-4">
            <div class="c-field">
                <?php echo $form->field($model, 'surname')->textInput(['class' => 'autoSearchSubmit c-input', 'placeholder' => 'Фамилия'])->label(false) ?>
            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="c-field">
                <?php echo $form->field($model, 'name')->textInput(['class' => 'autoSearchSubmit c-input', 'placeholder' => 'Имя'])->label(false) ?>
            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="c-field">
                <?php echo $form->field($model, 'middle_name')->textInput(['class' => 'autoSearchSubmit c-input', 'placeholder' => 'Отчество'])->label(false) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2 col-sm-4">
            <div class="c-field">
                <?= $form->field($model, 'number')->textInput(['class' => 'autoSearchSubmit c-input', 'placeholder' => 'Номер карты'])->label(false) ?>
            </div>
        </div>
        <div class="col-md-2 col-sm-4">
            <div class="c-field has-addon-left">
                <?php echo $form->field($model, 'birthday')->widget(DatePicker::classname(), [
                    'options' => [
                        'placeholder' => 'Дата рождения',
                        'class' => 'autoSearchSubmit c-input'
                    ],
                    'removeButton' => false,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'endDate' => date('Ymd'),
                        'todayHighlight' => true,
                    ]
                ])->label(false)
                ?>
            </div>
        </div>
    </div>
    <?= $form->field($model, 'city_id')->dropDownList($city, ['prompt' => 'Все', 'class' => 'autoSearchSubmit c-input'])->label(false)->hiddenInput() ?>
    <?= $form->field($model, 'address_point_id')->dropDownList($addressPoint, ['prompt' => 'Все', 'class' => 'autoSearchSubmit c-input'])->label(false)->hiddenInput() ?>

    <?php
    //todo скрыты инпуты фильтра по городу/точке
    if (false) { ?>
        <div class="col-md-3 col-sm-4">
            <div class="c-field">
                <?= $form->field($model, 'city_id')->dropDownList($city, ['prompt' => 'Все', 'class' => 'autoSearchSubmit c-input'])->label('Город', ['class' => 'c-field__label']) ?>
            </div>
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="c-field">
                <?= $form->field($model, 'address_point_id')->dropDownList($addressPoint, ['prompt' => 'Все', 'class' => 'autoSearchSubmit c-input'])->label('Адрес', ['class' => 'c-field__label']) ?>
            </div>
        </div>
    <?php } ?>
</div>
<hr>
<?php ActiveForm::end(); ?>
