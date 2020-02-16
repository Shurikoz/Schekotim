<?php

use yii\helpers\Html;

$this->title = 'Акции и скидки';
$header = 'Акции и скидки';
?>
<!-- Header -->
<?= $this->render('/partials/_header', compact('header')); ?>
<!-- Content -->
<section>
    <header class="main">
        <h1><?= Html::encode($this->title) ?></h1>
    </header>

    <div class="row">
        <div class="row">
            <div class="col-12 col-12-small">
                <h3>Укрепление ногтей в подарок!</h3>
                <div class="row">
                    <div class="col-2 col-12-small">
                        <span class="image fit"><img src="images/stock/nail.jpg" alt=""/></span>
                    </div>
                    <div class="col-10 col-12-small">
                        <p><b>Весь январь</b> выравнивание и укрепление ногтей биогелем в подарок!</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-12-small">
                <hr class="major"/>
            </div>

            <div class="col-12 col-12-small">
                <h3>Бесплатная консультация подолога</h3>
                <div class="row">
                    <div class="col-2 col-12-small">
                        <span class="image fit"><img src="images/stock/podology.jpg" alt=""/></span>
                    </div>
                    <div class="col-10 col-12-small">
                        <p><b>Каждую среду</b> наши подологи консультируют Вас бесплатно! <br />
                            Не забудьте записаться.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-12-small">
                <hr class="major"/>
            </div>


            <div class="col-12 col-12-small">
                <h3>Знакомство на 5!</h3>
                <div class="row">
                    <div class="col-2 col-12-small">
                        <span class="image fit"><img src="images/stock/5.jpg" alt=""/></span>
                    </div>
                    <div class="col-10 col-12-small">
                        <p>Запишитесь впервые и получите скидку <b>5%</b> на любую услугу Центра во время своего визита к мастеру или подологу. <br />
                            Вы сами выбираете, на какую услугу распространяется Ваша скидка.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-12-small">
                <hr class="major"/>
            </div>


            <div class="col-12 col-12-small">
                <h3>Подготовь руки к холоду!</h3>
                <div class="row">
                    <div class="col-2 col-12-small">
                        <span class="image fit"><img src="images/stock/parafin.jpg" alt=""/></span>
                    </div>
                    <div class="col-10 col-12-small">
                        <p><b>Парафинотерапия</b> - это увлажнение, питание и защита кожи рук от холода и сухости. <br /><b>Весь январь и февраль</b> мы дарим парафинотерапию для рук, пока Вы делаете педикюр у наших мастеров.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-12-small">
                <hr class="major"/>
            </div>

            <div class="col-12 col-12-small">
                <h3>Антимикробная фотодинамическая терапия в подарок!</h3>
                <div class="row">
                    <div class="col-2 col-12-small">
                        <span class="image fit"><img src="images/stock/pakt.jpg" alt=""/></span>
                    </div>
                    <div class="col-10 col-12-small">
                        <p><b>Антимикробная фотодинамическая терапия</b> заметно улучшает регенерацию тканей, поэтому она становится незаменимым помощником для:
                        <ul>
                            <li>Ускорения грануляции и заживления ран</li>
                            <li>Профилактика присоединения вторичной инфекции в местах травмирования валиков при врастающих ногтях</li>
                            <li>Ускорение процесса выведения бородавок</li>
                            <li>Ускорение регенерации ногтевых пластин при лечении микоза</li>
                        </ul>
                        До 31 марта 2020 года каждая третья процедура для наших клиентов - <b>БЕСПЛАТНО!</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
