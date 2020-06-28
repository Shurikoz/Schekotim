<?php

use yii\helpers\Html;

$this->title = 'Акции и скидки';
$header = 'Акции и скидки';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Центр маникюра, педикюра и подологии «Щекотливая тема» - Акции и скидки'
]);
?>
<!-- Header -->
<?= $this->render('/partials/_header', compact('header')); ?>
<!-- Content -->
<section>
    <header class="main">
        <h1><?= Html::encode($this->title) ?></h1>
    </header>

    <div class="row">
        <?php foreach (array_reverse($model) as $item) { ?>
        <div class="col-12 col-12-small">
            <h3><?= $item->title ?></h3>
            <div class="row">
                <div class="col-2 col-12-small">
                    <span class="image fit">
                        <?php if (!$item->image) { ?>
                            <img src="images/nophoto.jpg" alt=""/>
                        <?php } else { ?>
                            <img src="<?= $item->image ?>" alt=""/>
                        <?php } ?>
                    </span>
                </div>
                <div class="col-10 col-12-small">
                    <?= $item->text ?>
                    <?php if ($item->endtime) {?>
                    <br>
                    <p><b>Акция действует до <?= $item->endtime ?></b></p>
                    <?php } ?>

                </div>
                <div class="col-10 col-12-small"></div>
            </div>
        </div>
        <div class="col-12 col-12-small">
            <hr class="major"/>
        </div>
    <?php } ?>

</section>
