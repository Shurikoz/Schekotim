<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Visit */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box">

    <div class="visit-form">
        <?php $form = ActiveForm::begin(); ?>

<!--        --><?//= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false); ?>

        <?= $form->field($model, 'card_number')->hiddenInput(['value' => (int)Yii::$app->request->get('card_number')])->label(false); ?>

        <?= $form->field($model, 'city')->textInput([
            'maxlength' => true,
            'value' => Yii::$app->request->get('city')
        ]) ?>

        <?= $form->field($model, 'address_point')->textInput([
            'maxlength' => true,
            'value' => Yii::$app->request->get('address_point')
        ]) ?>

        <?= $form->field($model, 'podolog')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'reason')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'manipulation')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'recommendation')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'next_visit_from')->textInput(['type' => 'date']) ?>

        <?= $form->field($model, 'next_visit_by')->textInput(['type' => 'date']) ?>

        <!--    --><? //= $form->field($model, 'has_come')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'has_come')->checkbox(['value' => '1', 'checked ' => false])->label(''); ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
