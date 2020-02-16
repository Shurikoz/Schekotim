<?php

use yii\helpers\Html;

$this->title = 'Стержневая мозоль';
$header = 'Стержневая мозоль';
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
                    <span class="image fit"><img src="images/uslugi/9.jpg" alt=""/></span>
                </div>
                <div class="col-8 col-12-small">
                    <ul>
                        <li>Дискомфорт, боль</li>
                        <li>Точка на стопе</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-6 col-12-medium">
            <h3>Что делать?</h3>
            <div class="row">
                <div class="col-4 col-12-small">
                    <span class="image fit"><img src="images/uslugi/10.jpg" alt=""/></span>
                </div>
                <div class="col-8 col-12-small">
                    <ul>
                        <li>Исключить самолечение </li>
                        <li>Не делать педикюр перед посещением подолога</li>
                        <li>Обратиться к специалисту</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-6 col-12-medium">
            <h3>Сроки избавления от стержневых мозолей:</h3>
            <div class="row">
                <div class="col-4 col-12-small">
                    <span class="image fit"><img src="images/uslugi/11.jpg" alt=""/></span>
                </div>
                <div class="col-8 col-12-small">
                    <ul>
                        <li>1 день – удаление мозоли в технике «глазки» без крови и боли </li>
                        <li>При глубоких стержневых мозолях может понадобиться повторное посещение через 7-10 дней</li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-6 col-12-medium">
            <h3>Как ускорить процесс восстановления?
            </h3>
            <div class="row">
                <div class="col-4 col-12-small">
                    <span class="image fit"><img src="images/uslugi/time-left.png" alt=""/></span>
                </div>
                <div class="col-8 col-12-small">
                    <ul>
                        <li>Использовать разгрузку</li>
                        <li>Следовать рекомендациям подолога</li>
                        <li>Ортопедические стельки и/или удобная обувь</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

</section>

