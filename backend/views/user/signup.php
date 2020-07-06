<?php

use common\widgets\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use rmrevin\yii\fontawesome\FAS;

$this->title = 'Регистрация нового пользователя';

$addressPpointList = [];
array_unshift($addressPpointList, '');

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
        <h3>Регистрация нового пользователя</h3>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= Alert::widget() ?>
        <?= Html::errorSummary($model) ?>
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
        <div class="row">
            <div class="col-lg-4">
                <?= $form->field($model, 'username')->label('Логин') ?>
                <?= $form->field($model, 'email') ?>
                <br>
                <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
                <?= $form->field($model, 'retypePassword')->passwordInput()->label('Повторите пароль') ?>
            </div>
            <div class="col-lg-4">
                <?= Html::label('Роль пользователя', 'role') ?>
                <?= Html::dropDownList('role', 'null', $roles, ['prompt' => '-', 'class' => 'c-input', 'id' => 'signRole', 'label' => 'Роль']); ?>
                <br>
                <?= $form->field($model, 'city')->dropDownList($city, ['prompt' => 'Выберите город'])->label('Город') ?>

                <!-- Получим список точек из AJAX запрса по выбранному городу -->
                <?= $form->field($model, 'address_point')
                    ->dropDownList(['prompt' => 'Сначала выберите город'])
                    ->label('Адрес точки <div id="errorData" class="" style="float: right"></div>') ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'name') ?>
                <p>Введите имя пользователя в формате - <br><b>Фамилия И.О.</b></p>
                <p>Если пользователю будет присвоена роль "Подолог", это имя будет отображаться в списке подологов</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::submitButton('Зарегистрировать', ['class' => 'btn btn-green', 'name' => 'signup-button']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
