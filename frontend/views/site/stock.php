<?php

use wbraganca\videojs\VideoJsWidget;
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
            <div class="col-12 col-12-small">
                <h3>Консультируем бесплатно!</h3>
                <div class="row">
                    <div class="col-5 col-12-small">
                        <?= VideoJsWidget::widget([
                            'options' => [
                                'class' => 'vjs-default-skin vjs-big-play-centered',
                                'poster' => "upload/stock/poster.png",
                                'controls' => true,
                                'preload' => 'auto',
                                'width' => '100%',
                                'height' => '400',
                            ],
                            'tags' => [
                                'source' => [
                                    ['src' => 'upload/stock/She_pn.mp4', 'type' => 'video/mp4']
                                ]
                            ]
                        ]); ?>
                    </div>
                    <div class="col-7 col-12-small">
                        <p>А мы продолжаем консультировать вас бесплатно🙌</p>
                        <p>
                            ✅ Как вернуть здоровье рукам, ногтям и ногам?<br>
                            ✅ Как сохранить их красивыми и ухоженными?<br>
                            ✅ Можно ли без боли избавиться от вросшего ногтя?<br>
                            ✅ Передаётся ли грибок по наследству?<br>
                            ✅ Почему изменился цвет ногтей?<br>
                            ✅ Как защитить себя от грибка и инфекций при посещении общественных мест?<br>
                            ✅ Как выбрать носки и обувь?<br>
                            ✅ Можно ли избавиться от трещин на пятках?<br>
                            ✅ Когда можно протезировать ногтевые пластины?<br>
                            ✅ Откуда берётся синегнойная палочка на ногтях?...<br>
                        </p>
                        <p>На эти и многие другие вопросы наши лучшие подологи отвечают БЕСПЛАТНО!</p>
                        <p>✍️ Запишитесь на консультацию по ссылке в шапке нашего сайта☝️</p>
                        <p>*Акция распространяется на первичную консультацию подолога. Подробности уточняйте у наших
                            администраторов. Количество мест ограничено.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-12-small">
                <hr class="major"/>
            </div>
    </div>

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
                    <p><b>Акция действует до <?= Yii::$app->formatter->asDate($item->endtime) ?></b></p>
                    <?php } ?>

                </div>
                <div class="col-10 col-12-small"></div>
            </div>
        </div>
        <div class="col-12 col-12-small">
            <hr class="major"/>
        </div>
    <?php } ?>
    </div>

</section>
