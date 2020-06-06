<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">
    <!--    --><? //= Html::encode($this->title) ?>
    <h1>Ошибка #404</h1>
    <h3>Страница не найдена</h3>
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Вышеуказанная ошибка произошла, когда веб-сервер обрабатывал ваш запрос.
    </p>
    <p>
        Пожалуйста, свяжитесь с администратором сервиса, если считаете, что это ошибка сервера.
    </p>

</div>
