<?php

use yii\helpers\FileHelper;
use yii\helpers\Html;

//получим все сертификаты из папки certificates
$files = FileHelper::findFiles('images/sertificates');
shuffle($files);
$this->title = 'Дипломы и сертификаты';
$header = 'Дипломы и сертификаты';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Центр маникюра, педикюра и подологии «Щекотливая тема» - Сертификаты и дипломы наших специалистов'
]);
?>
<!-- Header -->
<?= $this->render('/partials/_header', compact('header')); ?>
<!-- Content -->
<section>
    <header class="main">
        <div class="row">
            <div class="col-12 col-12-medium">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
    </header>
    <div class="row">
        <div class="col-12 col-12-medium">
            <div class="posts">
                <?php foreach ($files as $file) { ?>
                    <article>
                        <a href="javascript:void(0);" class="image sertImage"><img src="<?= $file ?>" alt=""/></a>
                    </article>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
