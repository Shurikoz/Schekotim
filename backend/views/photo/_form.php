<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Photo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="photo-visit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'visit_id')->textInput() ?>

    <?= $form->field($model, 'url')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'thumbnail')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'used')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
