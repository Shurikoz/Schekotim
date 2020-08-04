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
                <h1>Ошибка</h1>
                <h3>Карты с таким номером не существует</h3>
                <p><?= Html::a('Вернуться к списку карт', ['card/index']) ?></p>

            </div>
        </div>
    </div>
</section>