<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<section>
    <div class="site-error text-center">
        <div class="row">
            <div class="col-md-12 font-phenomena">
                <h1>Ошибка доступа</h1>
<!--                <p>Возможно, у вас нет прав доступа или не выполнен --><?//= Html::a('вход в систему', ['/login']) ?><!--.</p>-->
                <p><?= $exception->getMessage();?></p>
            </div>
        </div>
    </div>
</section>