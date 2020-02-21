<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\VisitSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="visit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'card_number') ?>

    <?= $form->field($model, 'city') ?>

    <?= $form->field($model, 'address_point') ?>

    <?= $form->field($model, 'reason') ?>

    <?php // echo $form->field($model, 'manipulation') ?>

    <?php // echo $form->field($model, 'recommendation') ?>

    <?php // echo $form->field($model, 'next_visit_from') ?>

    <?php // echo $form->field($model, 'next_visit_by') ?>

    <?php // echo $form->field($model, 'has_come') ?>

    <?php // echo $form->field($model, 'description') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
