<?php

use yii\helpers\Html;
use yii\helpers\FileHelper;
//получим все сертификаты из папки certificates
$files = FileHelper::findFiles('images/certificates');
shuffle($files);
$this->title = 'Дипломы и сертификаты';
$header = 'Дипломы и сертификаты';
?>
        <!-- Header -->
<?= $this->render('/partials/_header',compact('header')); ?>
        <!-- Content -->
        <section>
            <header class="main">
                <h1><?= Html::encode($this->title) ?></h1>
                <section>
                    <div class="posts">
                        <?php foreach ($files as $file){?>
                        <article>
                            <a href="javascript:void(0);" class="image sertImage"><img src="<?= $file ?>" alt=""/></a>
                        </article>
                        <?php } ?>
                    </div>
                </section>
            </header>
