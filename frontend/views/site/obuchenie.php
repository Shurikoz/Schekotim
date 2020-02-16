<?php

use yii\helpers\Html;

$this->title = 'Обучение';
$header = 'Обучение';
?>
<!-- Header -->
<?= $this->render('/partials/_header', compact('header')); ?>


<!-- Content -->
<section>
    <header class="main">
        <h1><?= Html::encode($this->title) ?></h1>
        <h4>Курсов временно нет</h4>
        <div class="row">
            <div class="col-12 col-12-medium">
                        <span>
                           В настоящее время мы стараемся обучить Валеру... решили начать со школы!
                        </span>
                <span class="image left" style="max-width: 100% !important;"><img src="images/valera.jpg" alt=""/></span>


            </div>
        </div>
    </header>
</section>
