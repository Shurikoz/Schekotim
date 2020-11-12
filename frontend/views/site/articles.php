<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Статьи';
$header = 'Статьи';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Центр маникюра, педикюра и подологии «Щекотливая тема» - Статьи'
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
                <?php foreach ($articles as $item) { ?>
                <article>
                    <a href="<?= Url::base() . '/article/' . $item->id ?>" class="image"><img src="<?= Url::base() . '/' . $item->image ?>" alt="" /></a>
                    <h3><?= $item->title ?></h3>
                    <p><?= $item->description ?></p>
                    <p class="artical-info"><span><?= date('d.m.Y', $item->created_at) ?></span><span class="article-sep"><span class="glyphicon glyphicon-eye-open"></span> <?= $item->count_view ?></span></p>

                    <ul class="actions">
                        <li><a href="<?= Url::base() . '/article/' . $item->id ?>" class="button">Подробнее</a></li>
                    </ul>

                </article>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-12-medium">
            <div class="text-center">
                <?= LinkPager::widget([
                    'pagination' => $pages,
                    'maxButtonCount' => 5
                ]); ?>
            </div>
        </div>
    </div>
</section>