<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CardSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-search">
    <div class="box">
        <div class="col-sm-12">

            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
            ]); ?>
            <?= Html::button('Сбросить', ['class' => 'btn btn-default resetFormButton pull-right']) ?>

            <p class="titleNormal">Фильтр</p>
            <hr>
            <!--    --><? //= $form->field($model, 'id')->textInput(['class' => 'autoSearchSubmit']) ?>
            <!---->
            <!--    --><? //= $form->field($model, 'user_id')->textInput(['class' => 'autoSearchSubmit']) ?>
            <div class="row">
                <div class="col-md-2">
                    <div class="c-field">
                        <?= $form->field($model, 'number')->textInput(['class' => 'autoSearchSubmit c-input'])->label('Номер карты', ['class' => 'c-field__label']) ?>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="c-field">
                        <?= $form->field($model, 'city')
                            ->dropDownList(['' => '', 'Москва' => 'Москва', 'Калининград' => 'Калининград', 'Химки' => 'Химки'], ['class' => 'autoSearchSubmit c-input'])
                            ->label('Город', ['class' => 'c-field__label']) ?>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="c-field">
                        <?= $form->field($model, 'address_point_id')
                            ->dropDownList(['' => '', 'Самуила Маршака 20' => 'Самуила Маршака 20', 'Кирова 7' => 'Кирова 7'], ['class' => 'autoSearchSubmit c-input'])
                            ->label('Точка', ['class' => 'c-field__label']) ?>
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
                        <?php echo $form->field($model, 'birthday')->textInput(['type' => 'date', 'class' => 'autoSearchSubmit c-input'])->label('Дата рождения', ['class' => 'c-field__label']) ?>
                    </div>
                </div>
            </div>

            <!--            <div class="c-field">-->
            <!--                --><?php //echo $form->field($model, 'description')->textInput(['class' => 'autoSearchSubmit c-input']) ?>
            <!--            </div>-->
            <!--            <div class="c-field">-->
            <!--                --><?php //echo $form->field($model, 'created_at')->textInput(['class' => 'autoSearchSubmit c-input']) ?>
            <!--            </div>-->
            <!--    <div class="form-group">-->
            <!--        --><? //= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <!--        --><? //= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
            <!--    </div>-->

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
