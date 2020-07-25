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
        <hr>
        <div class="box">
            <div class="col-md-12">
                <?php $form = ActiveForm::begin(); ?>

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
    <div class="col-md-4">
        <h4>Информация о пользователе</h4>
        <hr>
        <div class="box">
            <?php $role = array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id))?>
            <p><b>Роль:</b> <?= Yii::$app->authManager->getRole($role)->description;?></p>
            <br>
            <p><b>Email:</b> <?= $user->email ?></p>
            <br>
            <p><b>Город:</b> <?= $user->city->name ?></p>
            <br>
            <p><b>Адрес:</b> <?= $user->address_point->address_point ?></p>
        </div>
    </div>
</div>