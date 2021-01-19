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
        <div class="pull-right">
            <span style="display: block;margin-top: 5px;" class="titleNormal">Регистрация нового пользователя</span>
        </div>
    </div>
</div>
<hr>
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
<!--                <br>-->
<!--                --><?//= $form->field($model, 'city')->dropDownList($city, ['prompt' => 'Выберите город'])->label('Город') ?>
<!--                <!-- Получим список точек из AJAX запрса по выбранному городу -->
<!--                --><?//= $form->field($model, 'address_point')
//                    ->dropDownList(['prompt' => 'Сначала выберите город'])
//                    ->label('Адрес <div id="errorData" class="" style="float: right"></div>') ?>
                <br>
                <?= $form->field($model, 'name') ?>
                <p>Введите имя пользователя в формате - <br><b>Фамилия И.О.</b></p>
                <p>Если пользователю будет присвоена роль "Подолог" или "Дерматолог", это имя будет отображаться в списке специалистов</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::submitButton('Зарегистрировать', ['class' => 'btn btn-green pull-right', 'name' => 'signup-button']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>