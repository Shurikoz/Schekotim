<?php
$this->title = 'Щекотливая тема';
$header = 'Студия маникюра, педикюра и подологии';
?>

<!-- Header -->
<?= $this->render('/partials/_header', compact('header')); ?>


<!-- Banner -->
<section id="banner">
    <div class="content">
        <header>

            <h1>Меня зовут<br/>
                Анастасия Артанова</h1>
            <p>Я - Подолог</p>
        </header>
        <p>Более 3 лет я работаю в области подологии. Кроме того, выполняю качественный и безопасный для здоровья моих
            клиентов маникюр и педикюр.</p>
        <p>Постоянно совершенствую свои знания и опыт: посещаю лекции, тренинги, семинары, практикумы ведущих
            специалистов в области подологии, дерматологии-микологии и nail-индустрии.</p>
        <p>Моя главная мотивация в работе – это улыбки и искренняя благодарность моих клиентов, которым я помогла
            избавиться от проблем стоп и ногтей.</p>
    </div>
    <span class="image object">
		<img src="images/pic10.jpg" alt=""/>
	</span>

</section>

<!-- Section -->
<section>
    <header class="major">
        <h2>Направления нашей работы</h2>
    </header>
    </article>
    <div class="features">
        <article>
            <span class="icon fa-diamond"></span>
            <div class="content">
                <h3>Подология</h3>
                <p>Деформация ногтей стопы, изменение ногтевой пластины, изменения стопы,мозоли и дефекты - все это
                    вопросы, которыми занимается подолог.</p>
            </div>
        </article>
        <article>
            <span class="icon fa-paper-plane"></span>
            <div class="content">
                <h3>Ортониксия</h3>
                <p>Ортониксия – безболезненный метод избавления от вросшего ногтя. Этот метод исправляет причину, а не
                    только снимает симптомы. </p>
            </div>
        </article>
        <article>
            <span class="icon fa-rocket"></span>
            <div class="content">
                <h3>Маникюр</h3>
                <p>Сотни оттенков гель-лаков, стразы, наклейки, краски, а главное, волшебные руки мастера и внимание
                    каждой детали – вот рецепт шикарного Nail-дизайна.</p>
            </div>
        </article>
        <article>
            <span class="icon fa-signal"></span>
            <div class="content">
                <h3>Педикюр</h3>
                <p>Педикюр - это специальный уход за пальцами ног (например, удаление мозолей, полировка ногтей). По
                    сути он представляет собой аналог маникюра для ног. </p>
            </div>
        </article>
    </div>
</section>

<!--<section>-->
<!--    <header class="major">-->
<!--        <h2>Статьи</h2>-->
<!--    </header>-->
<!--    <div class="posts">-->
<!--        <article>-->
<!--            <div class="video">-->
<!--                <video id="video_1" src="video/nkhqRwAAAAA.mp4" muted loop onclick="videoPlay(1);"></video>-->
<!--                <div id="buttonbar">-->
<!--                    <button id="play_1" onclick="videoPlay(1)"><i class="fa fa-play" aria-hidden="true"></i></button>-->
<!--                </div>-->
<!--            </div>-->
<!--            <h3>Аппаратный педикюр</h3>-->
<!--            <p>Это безопасный и современный уход за кожей стоп мужчин и женщин. Он подходит и пациентам с сахарным-->
<!--                диабетом или микозом стопы.</p>-->
<!--            <ul class="actions">-->
<!--                <li><a href="#" class="button">Подробнее</a></li>-->
<!--            </ul>-->
<!--        </article>-->
<!--        <article>-->
<!---->
<!--            <div class="video">-->
<!--                <video id="video_2" src="video/YJ7rTQAAAAA.mp4" muted loop onclick="videoPlay(2);"></video>-->
<!--                <div id="buttonbar">-->
<!--                    <button id="play_2" onclick="videoPlay(2)"><i class="fa fa-play" aria-hidden="true"></i></button>-->
<!--                </div>-->
<!--            </div>-->
<!--            <h3>Классический педикюр</h3>-->
<!--            <p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante-->
<!--                interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>-->
<!--            <ul class="actions">-->
<!--                <li><a href="#" class="button">Подробнее</a></li>-->
<!--            </ul>-->
<!--        </article>-->
<!--        <article>-->
<!--            <a href="#" class="image"><img src="images/podologia.jpg" alt=""/></a>-->
<!--            <h3>Подология</h3>-->
<!--            <p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante-->
<!--                interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>-->
<!--            <ul class="actions">-->
<!--                <li><a href="#" class="button">Подробнее</a></li>-->
<!--            </ul>-->
<!--        </article>-->
<!--        <article>-->
<!--            <a href="#" class="image"><img src="images/manicur.jpg" alt=""/></a>-->
<!--            <h3>Маникюр</h3>-->
<!--            <p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante-->
<!--                interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>-->
<!--            <ul class="actions">-->
<!--                <li><a href="#" class="button">Подробнее</a></li>-->
<!--            </ul>-->
<!--        </article>-->
<!--        <article>-->
<!--            <a href="#" class="image"><img src="images/pic05.jpg" alt=""/></a>-->
<!--            <h3>Feugiat lorem aenean</h3>-->
<!--            <p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante-->
<!--                interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>-->
<!--            <ul class="actions">-->
<!--                <li><a href="#" class="button">Подробнее</a></li>-->
<!--            </ul>-->
<!--        </article>-->
<!--        <article>-->
<!--            <a href="#" class="image"><img src="images/pic06.jpg" alt=""/></a>-->
<!--            <h3>Amet varius aliquam</h3>-->
<!--            <p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante-->
<!--                interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>-->
<!--            <ul class="actions">-->
<!--                <li><a href="#" class="button">Подробнее</a></li>-->
<!--            </ul>-->
<!--        </article>-->
<!--    </div>-->
<!--</section>-->
<!---->
<!---->
