<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="visit-search">
<!--    --><?//= $form->field($model, 'id') ?>

<!--    --><?//= $form->field($model, 'number') ?>

<!--    --><?//= $form->field($model, 'specialist_id') ?>

<!--    --><?//= $form->field($model, 'card_number')->textInput(['class' => 'autoSearchSubmit c-input'])->label('Номер карты', ['class' => 'c-field__label']) ?>

    <!--    --><?//= $form->field($model, 'city_id') ?>

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

    <div class="box">
        <div class="col-sm-12">
            <?php $form = ActiveForm::begin([
                'method' => 'get',
            ]); ?>
            <div class="pull-right">
                <?= Html::button('Сбросить', ['class' => 'btn btn-default resetFormButton pull-right']) ?>
            </div>
            <p class="titleNormal">Фильтр</p>
            <hr>
            <div class="row">
                <div class="col-md-2">
                    <div class="c-field">
                        <?= $form->field($model, 'card_number')->textInput(['class' => 'autoSearchSubmit c-input'])->label('Номер карты', ['class' => 'c-field__label']) ?>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="c-field">

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="c-field">

                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <div class="c-field">
                        <?php echo $form->field($model, 'surname')->textInput(['class' => 'autoSearchSubmit c-input'])->label('Фамилия', ['class' => 'c-field__label']) ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="c-field">
                        <?php echo $form->field($model, 'name')->textInput(['class' => 'autoSearchSubmit c-input'])->label('Имя', ['class' => 'c-field__label']) ?>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="c-field">
                        <?php echo $form->field($model, 'middle_name')->textInput(['class' => 'autoSearchSubmit c-input'])->label('Отчество', ['class' => 'c-field__label']) ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="c-field has-addon-left">

                    </div>
                </div>

            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
