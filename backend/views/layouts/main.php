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
$administrator = Yii::$app->user->can('administrator');
$smm = Yii::$app->user->can('smm');
$podolog = Yii::$app->user->can('podolog');
$leader = Yii::$app->user->can('leader');
$dermatolog = Yii::$app->user->can('dermatolog');

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
//        $menuItems[] = [
//            'label' => 'Задачи',
//            'url' => ['/task/index'],
//            'visible' => $admin || $administrator || $smm || $podolog || $leader
//
//        ];
        $menuItems[] = [
            'label' => 'Фото работ',
            'url' => ['/photo/index'],
            'visible' => $smm,
        ];
        $menuItems[] = [
            'label' => 'Сайт',
            'visible' => $admin || $leader,
            'items' => [
                ['label' => 'Прайс-лист', 'visible' => $admin || $leader, 'url' => '/pages/price'],
                ['label' => 'Акции и скидки', 'visible' => $admin || $leader, 'url' => '/stock/index'],
                ['label' => 'Галерея', 'visible' => $admin, 'url' => '/gallery/index'],
                ['label' => 'Отзывы', 'visible' => $admin || $leader, 'url' => '/review/index'],

            ],
        ];
        $menuItems[] = [
            'label' => 'Система учета',
            'items' => [
                ['label' => 'Карты', 'url' => '/card/index', 'visible' => $admin || $leader || $administrator || $podolog || $dermatolog],
                ['label' => 'Календарь', 'url' => '/event', 'visible' => $podolog || $dermatolog],
                ['label' => 'Фото работ', 'url' => '/photo/index', 'visible' => $admin || $leader || $smm],
                ['label' => 'Пропущенные посещения', 'url' => '/visit/missed', 'visible' => $admin || $leader || $administrator],
                ['label' => 'Запланированные посещения', 'url' => '/visit/planned', 'visible' => $admin || $leader || $administrator],
                ['label' => 'Шаблоны для специалистов', 'url' => '/problem/index', 'visible' => $admin || $leader],
                ['label' => 'Пользователи', 'url' => '/user/index', 'visible' => $admin || $leader],
            ],
        ];
        $menuItems[] = [
            'label' => 'Управление',
            'visible' => $admin,
            'items' => [
                ['label' => 'RBAC', 'url' => '/admin/user/index'],
                ['label' => 'Служба поддержки', 'url' => '/pages/support'],
            ],
        ];
        $menuItems[] = [
            'label' => Yii::$app->user->identity->username,
            'items' => [
                ['label' => 'Настройки', 'url' => '/settings'],
                ['label' => 'Выход',  'url' => '/site/logout'],
            ],
        ];
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
        <?php if (!Yii::$app->user->isGuest) { ?>
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <?php if (!$admin) { ?>
                        <?= Html::a('<button type="button" class="btn btn-default">Служба поддержки</button>', ['/support']) ?>
                    <?php } ?>
                </div>
                <div class="col-md-4 col-sm-4">
                    <?= Html::a('<button type="button" class="btn btn-default pull-right">Справка</button>', ['/tutorial']) ?>
                </div>
            </div>
            <hr>
        <?php } ?>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
            </div>
            <div class="col-md-6 col-sm-6">
                <p class="pull-right"><?= Html::a('Политика конфиденциальности', ['/policy']) ?></p>
            </div>
        </div>
        <br>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
