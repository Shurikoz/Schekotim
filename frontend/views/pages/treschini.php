<?php

use yii\helpers\Html;

$this->title = 'Трещины на пятках';
$header = 'Трещины на пятках';
?>
<!-- Header -->
<?= $this->render('/partials/_header', compact('header')); ?>


<!-- Content -->
<section>
    <header class="main">
        <h1><?= Html::encode($this->title) ?></h1>
    </header>
</section>
