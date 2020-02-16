<?php

use yii\helpers\Html;
use yii\helpers\FileHelper;
//получим все сертификаты из папки certificates
$files = FileHelper::findFiles('images/certificates');
shuffle($files);
$this->title = 'Технологии и опыт';
$header = 'Технологии и опыт';
?>
        <!-- Header -->
<?= $this->render('/partials/_header',compact('header')); ?>
        <!-- Content -->
        <section>
            <header class="main">
                <h1><?= Html::encode($this->title) ?></h1>
                <section>
                    <header class="major">
                        <h2>Дипломы и сертификаты</h2>
                    </header>
                    <div class="posts">
                        <?php foreach ($files as $file){?>
                        <article>
                            <a href="javascript:void(0);" class="image sertImage"><img src="<?= $file ?>" alt=""/></a>
                        </article>
                        <?php } ?>
                    </div>
                </section>
            </header>
