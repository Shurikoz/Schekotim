<?php

use yii\helpers\Html;

$this->title = 'Примеры работ';
$header = 'Примеры работ';

//перемешаем массивы с фото
//shuffle($pod);
//shuffle($man);
//shuffle($ped);

?>

<!-- Header -->
<?= $this->render('/partials/_header', compact('header')); ?>
<style>
    .instagram iframe {
        width: 100% !important;
        min-height: 235px !important;
    }

    @media screen and (max-width: 480px) {

        iframe .lightwidget__photo {
            width: 100px !important;
            height: 100px !important;
        }
    }
</style>

<!-- Content -->
<section>
    <header class="main">
        <h1><?= Html::encode($this->title) ?></h1>
    </header>
    <div class="linkGalleryAnchore">
        <a href="#podolog">#Подология</a>
        <a href="#manicure">#Маникюр</a>
        <a href="#pedicure">#Педикюр</a>
    </div>
    <hr class="major"/>
    <h3>#подология</h3>
    <div id="podolog" style="display:none;">
        <?php foreach ($podolog as $photo) { ?>
        <a href="http://schekotim.ru">
            <img alt="<?= $photo->title ?>"
                 src="images/gallery/thumbnail/<?= $photo->filename ?>"
                 data-image="images/gallery/<?= $photo->filename ?>"
                 data-description="<?= $photo->title ?>"
                 style="display:none">
        </a>
        <?php } ?>

    </div>
        <hr class="major"/>
    <h3>#маникюр</h3>
    <div id="manicure" style="display:none;">
        <?php foreach ($manicure as $photo) { ?>
            <a href="http://schekotim.ru">
                <img alt="<?= $photo->title ?>"
                     src="images/gallery/thumbnail/<?= $photo->filename ?>"
                     data-image="images/gallery/<?= $photo->filename ?>"
                     data-description="<?= $photo->title ?>"
                     style="display:none">
            </a>
        <?php } ?>
    </div>
    <hr class="major"/>
    <h3>#педикюр</h3>
    <div id="pedicure" style="display:none;">
        <?php foreach ($pedicure as $photo) { ?>
            <a href="http://schekotim.ru">
                <img alt="<?= $photo->title ?>"
                     src="images/gallery/thumbnail/<?= $photo->filename ?>"
                     data-image="images/gallery/<?= $photo->filename ?>"
                     data-description="<?= $photo->title ?>"
                     style="display:none">
            </a>
        <?php } ?>
    </div>
</section>

