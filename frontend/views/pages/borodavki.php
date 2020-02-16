<?php

use yii\helpers\Html;

$this->title = 'Бородавки подошвенные';
$header = 'Бородавки подошвенные';
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
                    <span class="image fit"><img src="images/uslugi/4.jpg" alt=""/></span>
                </div>
                <div class="col-8 col-12-small">
                    <ul>
                        <li>Дискомфорт</li>
                        <li>Утолщение кожи</li>
                        <li>Черные точки</li>
                        <li>Нарушение рисунка кожи</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-6 col-12-medium">
            <h3>Что делать?</h3>
            <div class="row">
                <div class="col-4 col-12-small">
                    <span class="image fit"><img src="images/uslugi/5.jpg" alt=""/></span>
                </div>
                <div class="col-8 col-12-small">
                    <ul>
                        <li>Не заниматься самолечением</li>
                        <li>Обратиться к специалисту</li>
                        <li>Следовать рекомендациям подолога</li>
                        <li>Принимать цинк-содержащие препараты (по рекомендации врача)</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-6 col-12-medium">
            <h3>Сроки избавления от бородавок:</h3>
            <div class="row">
                <div class="col-4 col-12-small">
                    <span class="image fit"><img src="images/uslugi/6.jpg" alt=""/></span>
                </div>
                <div class="col-8 col-12-small">
                    <ul>
                        <li>2-3 недели при раннем обращении к специалисту</li>
                        <li>От 1 месяца в других случаях</li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-6 col-12-medium">
            <h3>Как ускорить избавление от бородавок?</h3>
            <div class="row">
                <div class="col-4 col-12-small">
                    <span class="image fit"><img src="images/uslugi/time-left.png" alt=""/></span>
                </div>
                <div class="col-8 col-12-small">
                    <ul>
                        <li>Коррекция питания (восполнение витаминов и минералов)</li>
                        <li>Дезинфекция обуви и носков</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

</section>
