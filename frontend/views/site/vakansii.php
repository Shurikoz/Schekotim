<?php

use yii\helpers\Html;

$this->title = 'Вакансии';
$header = 'Вакансии';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Центр маникюра, педикюра и подологии «Щекотливая тема» - Вакансии'
]);
?>
<!-- Header -->
<?= $this->render('/partials/_header', compact('header')); ?>


<!-- Content -->
<section>
    <header class="main">
        <h1><?= Html::encode($this->title) ?></h1>
        <h3>Вакансий нет</h3>
    </header>
</section>
