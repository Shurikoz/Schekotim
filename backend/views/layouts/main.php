<?php

/* @var $this \yii\web\View */

/* @var $content string */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

AppAsset::register($this);

$admin = Yii::$app->user->can('admin');
$manager = Yii::$app->user->can('manager');
$smm = Yii::$app->user->can('smm');
$user = Yii::$app->user->can('user');

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

<div class="wrap">
    <?php
    NavBar::begin([
//        'brandLabel' => Yii::$app->name,
        'brandLabel' => '<img src="/images/logo.png" class="pull-left" style="margin-top: -7px;height: 36px;"/>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top navbar-top-menu',
        ],
    ]);

    if (Yii::$app->user->isGuest) {
        $menuItems[] = [
            'label' => 'Вход',
            'url' => ['/login'],
//            'options'=>['class'=>'btn btn-info']
        ];
    } else {
        $menuItems[] = [
            'label' => 'Главная',
            'url' => ['/']
        ];
        $menuItems[] = [
            'label' => 'Картотека',
            'url' => ['/card/index'],
            'visible' => $user || $manager
        ];
        $menuItems[] = [
            'label' => 'Фото работ',
            'url' => ['/photo/index'],
            'visible' => $smm,
        ];
        $menuItems[] = [
            'label' => 'Система учета',
            'visible' => $admin,
            'items' => [
                ['label' => 'Картотека', 'url' => '/card/index'],
                ['label' => 'Фото работ', 'url' => '/photo/index'],
            ],
        ];
        $menuItems[] = [
            'label' => 'Сайт',
            'visible' => $admin,
            'items' => [
                ['label' => 'Отзывы', 'url' => '/review/index'],
                ['label' => 'Галерея', 'url' => '/gallery/index'],
                ['label' => 'Прайс-лист', 'url' => '/pages/price'],
            ],
        ];
        $menuItems[] = [
            'label' => 'Управление',
            'visible' => $admin,
            'items' => [
                ['label' => 'Пользователи', 'url' => '/admin/user/index'],
                ['label' => 'Регистрация', 'url' => '/site/signup'],
            ],
        ];
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Выход (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <?php if (!Yii::$app->user->isGuest && !$admin) {?>
        <p class="pull-right">О проблемах в работе просим <?= Html::a('сообщить администратору', ['/support']) ?></p>
        <?php } ?>

    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
