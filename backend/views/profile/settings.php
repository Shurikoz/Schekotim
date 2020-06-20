<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="row">
    <div class="col-md-12">
        <h3>Настройки</h3>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <h4>Сменить пароль</h4>
        <div class="box">
            <div class="col-md-12">
                <?php $form = ActiveForm::begin([
                    'id' => 'password-form',
                    'options' => [
                        'class' => 'form-horizontal',
                        'data-pjax' => true,
                    ],
                ]); ?>

                <?= $form->field($model, 'oldPassword')->passwordInput(['class' => 'c-input'])->label('Старый пароль') ?>
                <?= $form->field($model, 'newPassword')->passwordInput(['class' => 'c-input'])->label('Новый пароль') ?>
                <?= $form->field($model, 'retypePassword')->passwordInput(['class' => 'c-input'])->label('Повторите новый пароль') ?>

                <div class="form-group">
                    <?= Html::submitButton('Изменить', ['class' => 'btn btn-primary pull-right']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
