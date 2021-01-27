<?php

use yii\helpers\Url;

$this->title = 'Центр подологии Щекотливая тема';
$header = 'Центр маникюра, педикюра и подологии';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Центр маникюра, педикюра и подологии поможет Вам раз и навсегда решить проблемы стоп и ногтей. Лечение вросшего ногтя, лечение бородавок, лечение грибка стопы и многих других видов заболеваний в центре подологии "Щекотливая тема"'
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'подолог, центр подологии, центр подологии новопеределкино, подолог новопеределкино, подолог солнцево, подолог переделкино, подолог москва, вросший ноготь, лечение вросшего ногтя, '
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
        <p><strong>Центр маникюра, педикюра и подологии «Щекотливая тема» помогает пациентам решать следующие вопросы:</strong></p>
        <ul>
            <li><a href="/nogot">Вросшие или деформированные ногти <i class="fa fa-external-link" aria-hidden="true"></i></a></li>
            <li><a href="/borodavki">Бородавки <i class="fa fa-external-link" aria-hidden="true"></i></a></li>
            <li><a href="/onihomikoz">Грибковые поражения ногтей и кожи ног и рук <i class="fa fa-external-link" aria-hidden="true"></i></a></li>
            <li><a href="/mozol">Утолщение кожи на стопе разной этиологии, грубые мозоли, стержневые мозоли, натоптыши <i class="fa fa-external-link" aria-hidden="true"></i></a></li>
            <li>Диабетическая стопа или другие нарушения, возникающие в результате заболеваний</li>
            <li>Необходимость протезирования ногтей</li>
            <li>Подбор или индивидуальное изготовление ортезов</li>
            <li>Болезненные ощущения в области стоп</li>
        </ul>
    </div>

    <span class="image object">
		<img src="images/20190705-MTRN1138.jpg" alt=""/>
	</span>

</section>

<section style="padding:2em 0 0 0">
    <div class="features">
        <article style="width: calc(100% - 3em);">
            <a href="https://persono.ru/blog/beauty/anastasiya-artanova-i-natalya-trofimova-centr-shekotlivaya-tema/"
               target="_blank">
                <img src="images/temp/persono.png" alt=""/>
            </a>
            <a href="https://persono.ru/blog/beauty/anastasiya-artanova-i-natalya-trofimova-centr-shekotlivaya-tema/"
               target="_blank">
                <div class="content">
                    <h3>Читайте о нас в журнале «Persono» <i class="fa fa-external-link" aria-hidden="true"></i></h3>
                    <p>
                        Учредители Центра подологии «Щекотливая тема» Трофимова Наталья и Артанова Анастасия рассказали
                        о своём детище и об услугах, предоставляемых специалистами Центра.
                    </p>
                </div>
            </a>
        </article>
    </div>
</section>

<section>
    <br>
    <div class="row">
        <div class="col-7 col-12-small">
            <header class="major">
                <h3>Тактичное и безболезненное решение щекотливых вопросов</h3>
            </header>
            <ul>
                <li>Грибок стоп и ногтей</li>
                <li>Вросший ноготь</li>
                <li>Стержневая мозоль</li>
                <li>Натоптыши</li>
                <li>Трещины на пятках</li>
                <li>Мозоли</li>
                <li>Изменение цвета ногтевых пластин</li>
            </ul>
        </div>
        <div class="col-5 col-12-small">
            <header class="major">
                <h3>Безопасные для здоровья красивые ногти</h3>
            </header>
            <ul>
                <li>Аппаратный или классический</li>
                <li>Маникюр или педикюр</li>
                <li>Биогель</li>
                <li>Сертифицированные материалы</li>
                <li>Любой дизайн</li>
                <li>Бессрочная гарантия на работу …и вкусный кофе!</li>
            </ul>
        </div>
    </div>
</section>

<section>
    <br>
    <div class="row">
        <div class="col-12 col-12-small text-center">
            <h3>100% гарантия стерильности и безопасности инструментов</h3>
        </div>
    </div>
</section>
<section>
    <br>


    <div class="row">
        <div class="col-12 col-12-small">
            <header class="major">
                <h3>Почему вам к нам?</h3>
            </header>
            <ul class="alt">
                <li>Мы честно скажем, что Вам не нужна помощь подолога, если это так. Мы не исправляем того, чего нет.</li>
                <li>Мы не гонимся за адресом на *ском проспекте, поэтому наши цены намного доступнее, хотя от метро до нас всего 7 минут.</li>
                <li>У нас всегда: 1 пациент — 1 кабинет — 1 подолог, ведь мы желаем здоровья ногам и рукам каждого нашего пациента, поэтому соблюдаем все нормы, и не размещаем 2х и более пациентов в 1 помещении!</li>
                <li>Наши подологи — фанаты своего дела: пока не помогут, не будут спать — в прямом смысле этого слова.</li>
                <li>Мы используем только профессиональную косметику, материалы, оборудование и инструменты.</li>
                <li>Мы рекомендуем нашим клиентам и пациентам средства по уходу только после испытания этих средств на себе.</li>
                <li>Мы сотрудничаем с лучшими врачами: дерматологами, ортопедами и хирургами.</li>
                <li>Мы помешаны на стерилизации: приходите, покажем! Мы стерилизуем и дезинфицируем всё: воздух, полы, все поверхности, а для инструментов у нас целая стерилизационная с автоклавом.</li>
                <li>Наши мастера знают не только строение кожи и ногтевой пластины, ежедневно меняют дез.растворы по четкой формуле, но и дают бессрочную гарантию на покрытие!</li>
                <li>У нас всегда есть акции или приятные бонусы.</li>
                <li>Мы не покрываем лаком или гель-лаком грибок, онихолизис и т.п., потому что мы желаем здоровья всем нашим клиентам и не ставим никого под угрозу!</li>
                <li>А пока вы ждёте свою запись, мы угостим вас вкуснейшим кофе: с кофеином или без, с молоком или нет, сладким или горьким, но всегда с шоколадками :)</li>
            </ul>
        </div>
    </div>
</section>
<section>
    <br>
    <header class="major">
        <h2>Мы в Instagram</h2>
    </header>
    <iframe src='inwidget/index.php?adaptive=true&width=100%&inline=3&view=9&toolbar=false&preview=large' data-inwidget scrolling='no' frameborder='no' style='border:none;width:800px;height:850px;overflow:hidden;'></iframe>
</section>
<section>
    <br>
    <header class="major">
        <h2>Дополнительные направления нашей работы</h2>
    </header>
    <div class="features">
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

