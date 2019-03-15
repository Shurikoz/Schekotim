<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

$this->title = 'Контакты';
$header = 'Контакты';
?>

        <!-- Header -->
<?= $this->render('/partials/_header',compact('header')); ?>


<!-- Content -->
<section>
    <header class="main">
        <h1><?= Html::encode($this->title) ?></h1>
    </header>
</section>
<div class="site-contact">
    <div class="row">
        <div class="col-5 col-12-medium">
            <p>
                Если у вас есть вопросы или предложения, пожалуйста, заполните следующую форму, чтобы связаться с нами.
                Спасибо.
            </p>
            <hr class="major"/>
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

            <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'subject') ?>

            <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'button primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-7 col-12-medium">
            <p>
                Мой кабинет находится в помещении Мед Центра Гемотест <br>
                Адрес: Лукинская, д.16.
            </p>
            <hr class="major"/>
            <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Ace4d3e9f5ed9d4fad35f1035617d5ce6b81c05ef092077f346afe2a87622216f&amp;width=900&amp;height=500&amp;lang=ru_RU&amp;scroll=true"></script>
        </div>
    </div>
</div>
