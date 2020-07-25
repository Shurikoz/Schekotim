<?php

use rmrevin\yii\fontawesome\FAS;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Радактирование пользователя';


?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-left">
            <?= Html::a(FAS::icon('angle-left', ['class' => 'big', 'data-role' => 'arrow']) . '&nbsp Вернуться к списку пользователей', ['/user/index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3>Радактирование ползователя: <?= $user->username ?></h3>
        <hr>
    </div>
</div>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-4">
        <?= $form->field($user, 'username')->textInput(['class' => 'c-input'])->label('Логин'); ?>
        <?= $form->field($user, 'email')->textInput(['class' => 'c-input'])->label('Email'); ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($user, 'city_id')->dropDownList($city, ['prompt' => 'Выберите город', 'class' => 'c-input', 'options' => [$user->city_id => ["Selected" => true]]])->label('Город') ?>
        <?= $form->field($user, 'address_point_id')->dropDownList($addressPoint, ['prompt' => 'Выберите точку', 'class' => 'c-input'])->label('Точка'); ?>
    </div>
    <div class="col-md-4">
        <?//= $form->field($user, 'email')->dropDownList($allRoles, ['prompt' => '-', 'class' => 'c-input', 'options' => [$userRole => ["Selected" => true]]])->label('Роль'); ?>
        <?= Html::label('Роль пользователя', 'role') ?>
        <?= Html::dropDownList('role', 'null', $allRoles, ['prompt' => '-', 'class' => 'c-input', 'options' => [$userRole => ["Selected" => true]]]); ?>
        <br>
        <?= $form->field($user, 'name')->label('Имя пользователя *') ?>
        <p>* Введите имя пользователя в формате - <br><b>Фамилия И.О.</b></p>
        <p>Если пользователю будет присвоена роль "Подолог", это имя будет отображаться в списке подологов</p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-green']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
