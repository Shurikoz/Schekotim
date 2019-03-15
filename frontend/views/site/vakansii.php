<?php
use yii\helpers\Html;

$this->title = 'Вакансии';
$header = 'Вакансии';
?>
        <!-- Header -->
<?= $this->render('/partials/_header',compact('header')); ?>


        <!-- Content -->
        <section>
            <header class="main">
                <h1><?= Html::encode($this->title) ?></h1>
                <h4>Страница находится в разработке</h4>
            </header>
        </section>
