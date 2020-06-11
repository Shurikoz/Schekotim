<?php

use common\widgets\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \mdm\admin\models\form\Signup */

$this->title = 'Регистрация нового пользователя';
$cityList = ArrayHelper::map($city, 'id', 'name');

$addressPpointList = [];
array_unshift($addressPpointList, '');

?>

<div class="row">
    <div class="col-md-12">
        <?= Alert::widget() ?>
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::errorSummary($model)?>
        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'username')->label('Логин') ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
                <?= $form->field($model, 'retypePassword')->passwordInput()->label('Повторите пароль') ?>
                <?= $form->field($model, 'city')
                    ->dropDownList($cityList)
                    ->label('Город') ?>
                <!-- Получим список точек из AJAX запрса по выбранному городу -->
                <?= $form->field($model, 'address_point')
                    ->dropDownList([])
                    ->label('Адрес точки <div id="errorData" class="" style="float: right"></div>') ?>
                <div class="form-group">
                    <?= Html::submitButton('Зарегистрировать', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
