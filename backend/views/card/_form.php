<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Card */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false); ?>

<!--    --><?//= $form->field($model, 'number')->textInput() ?>



    <?= $form->field($model, 'city')->textInput(['value' => Yii::$app->user->identity->city])->label(false); ?>

    <?= $form->field($model, 'address_point')->textInput(['value' => Yii::$app->user->identity->address_point])->label(false); ?>

    <?= $form->field($model, 'doctor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthday')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', [
                'class' => 'btn btn-success',
                'data' => [
                    'confirm' => 'Вы уверены что все заполнено верно? Дальнейшие изменения возможны только администратором ресурса!',
                    'method' => 'post',
                ],

        ]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
