<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="yandex-verification" content="b1fb9a0c61bbf3af" />
    <?php $this->registerLinkTag(['rel' => 'apple-touch-icon', 'size' => '180x180', 'href' => '/apple-touch-icon.png']);?>
    <?php $this->registerLinkTag(['rel' => 'manifest', 'href' => '/manifest.json']);?>
    <?php $this->registerLinkTag(['rel' => 'mask-icon', 'color' => '#0b9341', 'href' => '/safari-pinned-tab.svg']);?>

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(53045104, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true,
            ecommerce:"dataLayer"
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/53045104" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

</head>
<body>
<?php
$script = <<< JS
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(53045104, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
    });
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>
<noscript><div><img src="https://mc.yandex.ru/watch/53045104" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<?php $this->beginBody() ?>

<div id="wrapper">
    <?php
    //    NavBar::begin([
    //        'brandLabel' => Yii::$app->name,
    //        'brandUrl' => Yii::$app->homeUrl,
    //        'options' => [
    //            'class' => 'navbar-inverse navbar-fixed-top',
    //        ],
    //    ]);
    //    $menuItems = [
    //        ['label' => 'Home', 'url' => ['/site/index']],
    //        ['label' => 'About', 'url' => ['/site/about']],
    //        ['label' => 'Contact', 'url' => ['/site/contact']],
    //    ];
    //    if (Yii::$app->user->isGuest) {
    //        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
    //        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    //    } else {
    //        $menuItems[] = '<li>'
    //            . Html::beginForm(['/site/logout'], 'post')
    //            . Html::submitButton(
    //                'Logout (' . Yii::$app->user->identity->username . ')',
    //                ['class' => 'btn btn-link logout']
    //            )
    //            . Html::endForm()
    //            . '</li>';
    //    }
    //    echo Nav::widget([
    //        'options' => ['class' => 'navbar-nav navbar-right'],
    //        'items' => $menuItems,
    //    ]);
    //    NavBar::end();
    //    ?>

    <div id="main">
        <div class="inner">

            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>

            <?= $content?>
        </div>
    </div>
    <!-- Sidebar -->
    <div id="sidebar">
        <div class="inner">

            <!-- Logo -->
            <section id="logo">
                <img src="<?= Url::base()?>/images/main-logo.png"  style="width: 100%; height: auto;" alt="Центр маникюра, педикюра и подологии">
            </section>

            <!-- Menu -->
            <nav id="menu">
                <header class="major">
                    <h2>Меню</h2>
                </header>
                <ul>
                    <li><a href="/">Главная</a></li>
                    <li><a href="/articles">Статьи</a></li>
                    <li><a href="/services">Услуги и цены</a></li>
                    <li><a href="/stock">Акции и скидки</a></li>
                    <li>
                        <span class="opener">Дипломы и сертификаты</span>
                        <ul>
                            <li><a href="/certificates">Специалисты Центра</a></li>
                            <li><a href="/registry">Выпускники курсов</a></li>
                        </ul>
                    </li>
                    <li><a href="/work">Примеры работ</a></li>
                    <li><a href="/review">Отзывы</a></li>
                    <li><a href="/training">Повышение квалификации</a></li>
                    <li><a href="/vacancy">Вакансии</a></li>
                    <li><a href="/franchise">Франчайзинг</a></li>
                    <li><a href="/contacts">Контакты</a></li>
                </ul>
            </nav>

            <!-- Section -->
            <section>
                <header class="major">
                    <h2>Контакты</h2>
                </header>
                <ul class="contact">
                    <li class="fa-phone"><a href="tel:+74951818780">+7(495)181-87-80</a></li>
                    <li class="fa-whatsapp"><a href="https://api.whatsapp.com/send?phone=+79100048558&text=Здравствуйте! Хочу записаться к вам на прием!">+7(910)004-85-58</a></li>
                    <li class="fa-envelope-o"><a href="mailto:info@schekotim.ru">info@schekotim.ru</a></li>
                    <li class="fa-home">г. Москва, ул. Самуила Маршака 20, <br>(вход со двора)</li>
                    <li class="fa-clock-o">Работаем ежедневно <br>с 10:00 до 21:00<br>по предварительной записи</li>
                </ul>
            </section>

            <!-- Footer -->
            <footer id="footer">
                <iframe src="https://yandex.ru/sprav/widget/rating-badge/34151440370" width="150" height="50" frameborder="0"></iframe>
                <p class="copyright"> <?= date('Y') ?> &copy; «Щекотливая тема»<br>Все права защищены</p>
            </footer>

        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
