<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
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

        <?= $content ?>
        </div>
    </div>
    <!-- Sidebar -->
    <div id="sidebar">
        <div class="inner">

            <!-- Logo -->
            <section id="logo">
                    <img src="images/logo.png" alt="Студия маникюра, педикюра и подологии">
            </section>

            <!-- Menu -->
            <nav id="menu">
                <header class="major">
                    <h2>Меню</h2>
                </header>
                <ul>
                    <li><a href="/">Главная</a></li>
                    <li>
                        <span class="opener">Услуги</span>
                        <ul>
                            <li><a href="/podolog">Подология</a></li>
                            <li><a href="/manicur">Маникюр</a></li>
                            <li><a href="/pedicur">Педикюр</a></li>
                        </ul>
                    </li>
                    <li><a href="/tehnolog">Технологии и опыт</a></li>
                    <li><a href="/raboty">Примеры работ</a></li>
                    <li><a href="/review">Отзывы</a></li>
                    <li><a href="/obuchenie">Обучение</a></li>
                    <li><a href="/vakansii">Вакансии</a></li>
                    <li><a href="/contact">Контакты</a></li>
                </ul>
            </nav>

            <!-- Section -->
            <section>
                <header class="major">
                    <h2>Контакты</h2>
                </header>
                <p>Мой кабинет находится в помещении Мед Центра Гемотест по адресу: Лукинская, д.16.</p>
                <ul class="contact">
                    <li class="fa-whatsapp"><a href="https://api.whatsapp.com/send?phone=+79100048558&text=Здравствуйте! Хочу записаться к вам на прием!">+7(910)004-85-58</a></li>
                    <li class="fa-phone"><a href="tel:+79100048558">+7(910)004-85-58</a></li>
                    <li class="fa-envelope-o"><a href="mailto:info@schekotim.ru">info@schekotim.ru</a></li>
                    <li class="fa-home">Лукинская, д.16 </li>
                </ul>
            </section>

            <!-- Footer -->
            <footer id="footer">
                <p class="copyright"> <?= date('Y') ?> &copy; «Щекотливая тема»<br>Все права защищены</p>
            </footer>

        </div>
    </div>
</div>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>