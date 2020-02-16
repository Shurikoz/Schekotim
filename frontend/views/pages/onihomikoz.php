<?php

use yii\helpers\Html;

$this->title = 'Онихомикоз (грибок)';
$header = 'Онихомикоз (грибок)';
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
                    <span class="image fit"><img src="images/uslugi/7.jpg" alt=""/></span>
                </div>
                <div class="col-8 col-12-small">
                    <ul>
                        <li>Жжение, зуд</li>
                        <li>Микротрещины на ногтевой пластине</li>
                        <li>Легкая бугристость</li>
                        <li>Изменение цвета ногтя</li>
                        <li>Утолщение ногтевой пластины</li>
                        <li>Чешуйки на ногтях</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-6 col-12-medium">
            <h3>Что делать?</h3>
            <div class="row">
                <div class="col-4 col-12-small">
                    <span class="image fit"><img src="images/uslugi/8.jpg" alt=""/></span>
                </div>
                <div class="col-8 col-12-small">
                    <ul>
                        <li>Обратиться к специалисту</li>
                        <li>Сдать анализ на посев</li>
                        <li>Регулярно зачищать пораженные ткани</li>
                        <li>Следовать рекомендациям подолога и дерматолога (в сложных случаях)</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-6 col-12-medium">
            <h3>Сроки избавления от грибка:
            </h3>
            <div class="row">
                <div class="col-4 col-12-small">
                    <span class="image fit"><img src="images/uslugi/6.jpg" alt=""/></span>
                </div>
                <div class="col-8 col-12-small">
                    <ul>
                        <li>2-3 месяца при раннем обращении к специалисту</li>
                        <li>От 6 месяцев в других случаях</li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-6 col-12-medium">
            <h3>Как ускорить избавление от грибка?</h3>
            <div class="row">
                <div class="col-4 col-12-small">
                    <span class="image fit"><img src="images/uslugi/time-left.png" alt=""/></span>
                </div>
                <div class="col-8 col-12-small">
                    <ul>
                        <li>Коррекция питания (снизить потребление сахара)</li>
                        <li>Дезинфекция обуви и носков</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

</section>
