<?php

use yii\helpers\Html;

$this->title = 'Наши цены';
$header = 'Наши цены';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Центр маникюра, педикюра и подологии «Щекотливая тема» - Услуги и цены'
]);
?>
<!-- Header -->
<?= $this->render('/partials/_header', compact('header')); ?>

<!-- Content -->
<section>
    <header class="main">
        <h1><?= Html::encode($this->title) ?></h1>
    </header>
    <!-- Content -->
    <?=$model->text?>
</section>