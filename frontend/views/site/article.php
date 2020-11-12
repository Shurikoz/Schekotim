<?php

use newerton\fancybox3\FancyBox;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->title;

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Центр маникюра, педикюра и подологии «Щекотливая тема» - ' . $model->title
]);
?>
<!-- Header -->
<?= $this->render('/partials/_header'); ?>
<!-- Content -->
<?= FancyBox::widget([
    'target' => '[data-fancybox]',
    'config' => [
        // Enable infinite gallery navigation
        'loop'              => true,
        // Enable keyboard navigation
        'keyboard'          => true,
        // Should display navigation arrows at the screen edges
        'arrows'            => true,
        // Should display infobar (counter and arrows at the top)
        'infobar'           => true,
        // Should display toolbar (buttons at the top)
        'toolbar'           => true,
        // What buttons should appear in the top right corner.
        // Buttons will be created using templates from `btnTpl` option
        // and they will be placed into toolbar (class="fancybox-toolbar"` element)
        'buttons' => [
            'slideShow',
            'fullScreen',
            'thumbs',
            'close'
        ],
    ]
]); ?>

<section>
    <header class="main">
        <div class="row">
            <div class="col-12 col-12-medium">
                <h1><?= $model->title ?></h1>
            </div>
        </div>
    </header>
    <div class="row">
        <div class="col-4 col-12-medium">
            <span class="image fit"><img src="<?= Url::base() . '/' . $model->image ?>" alt=""/></span>
            <br>
            <div class="row">
                <?php foreach ($model->articleImage as $photo) { ?>
                    <div class="col-3 col-3-medium">
                        <span class="image fit"><?= Html::a(Html::img($photo->url), $photo->url, ['data-fancybox' => 'photo']); ?></span>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-8 col-12-medium">
            <div><?= $model->content ?></div>
                <?php if ($model->tags) { ?>
                <hr>
                <p><?= $model->tags ?></p>
            <?php } ?>
            <hr>
            <p class="artical-info pull-right"><span><?= date('d.m.Y', $model->created_at) ?></span><span class="article-sep"><span class="glyphicon glyphicon-eye-open"></span> <?= $model->count_view ?></span></p>
        </div>
    </div>
</section>
