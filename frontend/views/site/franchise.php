<?php

use yii\helpers\Html;

$this->title = 'Франчайзинг';
$header = 'Франчайзинг';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Центр маникюра, педикюра и подологии «Щекотливая тема» - Франчайзинг «Щекотливая тема»'
]);
?>
<!-- Header -->
<?= $this->render('/partials/_header', compact('header')); ?>


<!-- Content -->
<section>
    <header class="main">
        <h1><?= Html::encode($this->title) ?></h1>
        <h3>Скоро</h3>
    </header>
</section>
