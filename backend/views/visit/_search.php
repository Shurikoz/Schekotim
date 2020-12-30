<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<? //= $form->field($model, 'id') ?>
<? //= $form->field($model, 'number') ?>
<? //= $form->field($model, 'specialist_id') ?>
<? //= $form->field($model, 'card_number')->textInput(['class' => 'autoSearchSubmit c-input'])->label('Номер карты', ['class' => 'c-field__label']) ?>
<? //= $form->field($model, 'city_id') ?>
<?php // echo $form->field($model, 'address_point_id') ?>
<?php // echo $form->field($model, 'problem_id') ?>
<?php // echo $form->field($model, 'anamnes') ?>
<?php // echo $form->field($model, 'manipulation') ?>
<?php // echo $form->field($model, 'recommendation') ?>
<?php // echo $form->field($model, 'dermatolog') ?>
<?php // echo $form->field($model, 'immunolog') ?>
<?php // echo $form->field($model, 'ortoped') ?>
<?php // echo $form->field($model, 'hirurg') ?>
<?php // echo $form->field($model, 'next_visit_from') ?>
<?php // echo $form->field($model, 'next_visit_by') ?>
<?php // echo $form->field($model, 'planned') ?>
<?php // echo $form->field($model, 'visit_date') ?>
<?php // echo $form->field($model, 'has_come') ?>
<?php // echo $form->field($model, 'resolve') ?>
<?php // echo $form->field($model, 'used_photo') ?>
<?php // echo $form->field($model, 'description') ?>
<?php // echo $form->field($model, 'timestamp') ?>
<?php // echo $form->field($model, 'edit') ?>
<?php // echo $form->field($model, 'contacted') ?>
<?php // echo $form->field($model, 'recorded') ?>
<?php // echo $form->field($model, 'cancel') ?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
]); ?>
<div class="row">
    <div class="col-sm-6 col-xs-6">
        <p class="titleNormal">Фильтр</p>
    </div>
    <div class="col-sm-6 col-xs-6">
        <div class="pull-right">
            <!--                                            <span class="openNewWindow">-->
            <!--                                                <input type="checkbox" id="openNewWindow" name="openNewWindow">-->
            <!--                                                <label for="openNewWindow" style="cursor:pointer;">Открывать карты в новом окне</label>-->
            <!--                                            </span>-->
            <?= Html::button('Сбросить фильтр', ['class' => 'btn btn-default resetFormButton pull-right']) ?>
        </div>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-4 col-sm-4">
        <div class="c-field">
            <?= $form->field($model, 'surname')->textInput(['class' => 'autoSearchSubmit c-input', 'placeholder' => 'Фамилия'])->label(false) ?>
        </div>
    </div>
    <div class="col-md-4 col-sm-4">
        <div class="c-field">
            <?= $form->field($model, 'name')->textInput(['class' => 'autoSearchSubmit c-input', 'placeholder' => 'Имя'])->label(false) ?>
        </div>
    </div>
    <div class="col-md-4 col-sm-4">
        <div class="c-field">
            <?= $form->field($model, 'middle_name')->textInput(['class' => 'autoSearchSubmit c-input', 'placeholder' => 'Отчество'])->label(false) ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-2 col-sm-4">
        <div class="c-field">
            <?= $form->field($model, 'card_number')->textInput(['class' => 'autoSearchSubmit c-input', 'placeholder' => 'Номер карты'])->label(false) ?>
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
    <?php ActiveForm::end(); ?>
</div>
<hr>

