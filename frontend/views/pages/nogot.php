<?php

use yii\helpers\Html;

$this->title = 'Вросший ноготь';
$header = 'Вросший ноготь';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Лечение вросшего ногтя недорого и качественно. После посещения подолога в нашем центре вросший ноготь больше не будет вас беспокоить, мы поможем вам вылечить вросший ноготь раз и навсегда!'
]);
?>
<!-- Header -->
<?= $this->render('/partials/_header', compact('header')); ?>

<!-- Content -->
<section>
    <header class="main">
        <h1><?= Html::encode($this->title) ?></h1>
    </header>
    <div class="row gtr-200">
        <div class="col-6 col-12-medium">
            <h3>Как распознать?</h3>
            <div class="row">
                <div class="col-4 col-12-small">
                    <span class="image fit"><img src="images/uslugi/1.jpg" alt=""/></span>
                </div>
                <div class="col-8 col-12-small">
                    <ul>
                        <li>Дискомфорт, боль</li>
                        <li>Отек, воспаление</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-6 col-12-medium">
            <h3>Что делать?</h3>
            <div class="row">
                <div class="col-4 col-12-small">
                    <span class="image fit"><img src="images/uslugi/2.jpg" alt=""/></span>
                </div>
                <div class="col-8 col-12-small">
                    <ul>
                        <li>Исключить самолечение</li>
                        <li>Не делать педикюр перед посещением подолога</li>
                        <li>Обратиться к специалисту</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-6 col-12-medium">
            <h3>Сроки исправления вросшего ногтя:</h3>
            <div class="row">
                <div class="col-4 col-12-small">
                    <span class="image fit"><img src="images/uslugi/3.jpg" alt=""/></span>
                </div>
                <div class="col-8 col-12-small">
                    <ul>
                        <li>Простые врастания решаются за 1-2 посещения специалиста</li>
                        <li>Лечение сложных деформаций может занимать до 1,5 лет</li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-6 col-12-medium">
            <h3>Как ускорить процесс?</h3>
            <div class="row">
                <div class="col-4 col-12-small">
                    <span class="image fit"><img src="images/uslugi/time-left.png" alt=""/></span>
                </div>
                <div class="col-8 col-12-small">
                    <ul>
                        <li>Соблюдение рекомендаций подолога</li>
                        <li>Свободная обувь и носки</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

</section>



