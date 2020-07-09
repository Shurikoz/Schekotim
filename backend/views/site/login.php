<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login text-center">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните следующие поля для входа:</p>

    <div class="row">
        <div class="col-lg-offset-4 col-lg-4 text-center">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <br>
            <?= $form->field($model, 'username')->textInput() ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div style="color:#999;margin:1em 0">
                Забыли пароль? <?= Html::a('Восстановить', ['/request-password-reset']) ?>.
            </div>
            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-green btn-border-green', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
