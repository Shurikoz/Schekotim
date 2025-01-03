<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \frontend\models\ContactForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Контакты';
$header = 'Контакты';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Центр маникюра, педикюра и подологии «Щекотливая тема», как нас найти и связаться.'
]);
?>

<!-- Header -->
<?= $this->render('/partials/_header', compact('header')); ?>


<!-- Content -->
<section>
<header class="main">
    <h1><?= Html::encode($this->title) ?></h1>
</header>
<div class="site-contact">
    <div class="row">
        <div class="col-7 col-12-medium">
            <ul class="contact">
                <li class="fa-whatsapp"><a
                            href="https://api.whatsapp.com/send?phone=+79100048558&text=Здравствуйте! Хочу записаться к вам на прием!">+7(910)004-85-58</a>
                </li>
                <li class="fa-phone"><a href="tel:+74951818780">+7(495)181-87-80</a></li>
                <li class="fa-envelope-o"><a href="mailto:info@schekotim.ru">info@schekotim.ru</a></li>
                <li class="fa-home">г. Москва, ул. Самуила Маршака 20, (вход со двора)</li>
                <li class="fa-clock-o">Работаем ежедневно с 10:00 до 21:00 по предварительной записи</li>
            </ul>
            <p>

            </p>
            <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Ace4d3e9f5ed9d4fad35f1035617d5ce6b81c05ef092077f346afe2a87622216f&amp;width=100%25&amp;height=500&amp;lang=ru_RU&amp;scroll=true"></script>        </div>
        <div class="col-5 col-12-medium">
            <div class="box">
                <p>
                    Если у вас есть вопросы или предложения, пожалуйста, заполните следующую форму, чтобы связаться с
                    нами.
                </p>
                <p>
                    Записаться к нам можно через <a href="https://api.whatsapp.com/send?phone=+79100048558&text=Здравствуйте! Хочу записаться к вам на прием!" class="icon fab fa-whatsapp">&nbsp;<span>WhatsApp</span></a> или позвонив по телефону <a href="tel:+74951818780" class="icon fas fa-phone">&nbsp;<span>+7(495)181-87-80</span></a>
                </p>
                <hr class="major"/>
                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'name')->textInput() ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'subject') ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'reCaptcha')->widget(
                    \himiklab\yii2\recaptcha\ReCaptcha::className(),
                    ['siteKey' => '6Lf4qbgUAAAAAJN00e-Jk_USGrubqMJxg3qmqbKw']
                ) ?>
                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'button primary', 'name' => 'contact-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
</section>
