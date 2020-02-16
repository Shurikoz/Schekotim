<?php

use yii\helpers\Url;

$this->title = 'Щекотливая тема';
$header = 'Центр маникюра, педикюра и подологии';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Центр маникюра, педикюра и подологии поможет Вам раз и навсегда решить проблемы стоп и ногтей. Лечение вросшего ногтя, лечение бородавок, лечение грибка стопы и многих других видов заболеваний в центре подологии "Щекотливая тема"'
]);

?>

<!-- Header -->
<?= $this->render('/partials/_header', compact('header')); ?>


<!-- Banner -->
<section id="banner">
    <div class="content">
        <header>
            <h2>Чем занимается подолог?</h2>
        </header>
        <p><b>Подолог</b> - это специалист, осуществляющий полноценный уход за стопой.</p>
        <p>Во время процедуры парамедицинского педикюра подолог аккуратно удаляет натоптыши, загрубевшие старые мозоли, глубокие трещины на пятках, а также занимается проблемой диабетической стопы, протезированием ногтей, подбором индивидуальных ортопедических ортезов.</p>
        <p>С помощью корректирующих систем подолог безболезненно исправляет вросшие ногти и другие деформации ногтей.</p>
        <p>Благодаря работе подолога пациенты могут избежать дискомфорта и стеснения, избавившись от многих неприятных проблем, а также минимизировать разрушающие кожу и ногти последствия других заболеваний, влияющих на состояние рук и ног.</p>
        <p>Помимо этого, у подолога вы можете получить консультации по устранению излишней потливости ног, рекомендации по оптимальным средствам для ухода за кожей рук и ног, обработке пораженных тканей.</p>
        <br>
        <p><strong>Подологи Центра маникюра, педикюра и подологии «Щекотливая тема» помогают пациентам решать следующие вопросы:</strong></p>
        <ul>
            <li><a href="/nogot">Вросшие или деформированные ногти <i class="fa fa-external-link" aria-hidden="true"></i></a></li>
            <li><a href="/borodavki">Бородавки <i class="fa fa-external-link" aria-hidden="true"></i></a></li>
            <li><a href="/onihomikoz">Грибковые поражения ногтей и кожи ног и рук <i class="fa fa-external-link" aria-hidden="true"></i></a></li>
            <li><a href="/mozol">Утолщение кожи на стопе разной этиологии, грубые мозоли, стержневые мозоли, натоптыши <i class="fa fa-external-link" aria-hidden="true"></i></a></li>
            <li>Диабетическая стопа или другие нарушения, возникающие в результате заболеваний</li>
            <li>Необходимость протезирования ногтей</li>
            <li>Подбор или индивидуальное изготовление ортезов</li>
            <li>Болезненные ощущения в области стоп</li>
            <li>Лимфодренажное тейпирование</li>
        </ul>
    </div>

    <span class="image object">
		<img src="images/20190705-MTRN1138.jpg" alt=""/>
	</span>

</section>
<section>
    <br>
    <header class="major">
        <h2>Мы в Instagram</h2>
    </header>
    <iframe src='inwidget/index.php?adaptive=true&width=100%&inline=3&view=9&toolbar=false&preview=large' data-inwidget scrolling='no' frameborder='no' style='border:none;width:800px;height:850px;overflow:hidden;'></iframe>
</section>
<!-- Section -->
<section>
    <br>
    <header class="major">
        <h2>Дополнительные направления нашей работы</h2>
    </header>
    <div class="features">

<!--        <article>-->
<!--            <a href="--><?//= Url::to(['podolog']); ?><!--">-->
<!--                <span class="icon podology"></span>-->
<!--            </a>-->
<!--            <a href="--><?//= Url::to(['podolog']); ?><!--">-->
<!--                <div class="content">-->
<!--                    <h3>Подология</h3>-->
<!--                    <p>Деформация ногтей стопы, изменение ногтевой пластины, изменения стопы,мозоли и дефекты - все это-->
<!--                        вопросы, которыми занимается подолог.</p>-->
<!--                </div>-->
<!--            </a>-->
<!--        </article>-->
<!--        <article>-->
<!--            <a href="--><?//= Url::to(['podolog']); ?><!--">-->
<!---->
<!--                <span class="icon ortonexia"></span>-->
<!--            </a>-->
<!--            <a href="--><?//= Url::to(['podolog']); ?><!--">-->
<!---->
<!--                <div class="content">-->
<!--                    <h3>Ортониксия</h3>-->
<!--                    <p>Ортониксия – безболезненный метод избавления от вросшего ногтя. Этот метод исправляет причину, а-->
<!--                        не-->
<!--                        только снимает симптомы. </p>-->
<!--                </div>-->
<!--            </a>-->
<!--        </article>-->
        <article>
            <a href="<?= Url::to(['manicur']); ?>">
                <span class="icon manicur"></span>
            </a>
            <a href="<?= Url::to(['manicur']); ?>">
                <div class="content">
                    <h3>Маникюр</h3>
                    <p>Сотни оттенков гель-лаков, стразы, наклейки, краски, а главное, волшебные руки мастера и внимание
                        к каждой детали – вот рецепт шикарного Nail-дизайна.</p>
                </div>
            </a>
        </article>
        <article>
            <a href="<?= Url::to(['pedicur']); ?>">
                <span class="icon pedicur"></span>
            </a>
            <a href="<?= Url::to(['pedicur']); ?>">
                <div class="content">
                    <h3>Педикюр</h3>
                    <p>Педикюр - это специальный уход за пальцами ног (например, удаление мозолей, полировка ногтей). По
                        сути он представляет собой аналог маникюра для ног. </p>
                </div>
            </a>
        </article>
    </div>
</section>

