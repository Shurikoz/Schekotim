<?php

use yii\helpers\Html;

$this->title = 'Франшиза';
$header = 'Франшиза';
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
