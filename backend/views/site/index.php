<?php

/* @var $this yii\web\View */

/*
 * 4 типа пользователей:
 *  admin
 *	user
 *	smm
 *	administrator
 */

use yii\helpers\Html;

$this->title = 'Учет пациентов';

$admin = Yii::$app->user->can('admin');
$administrator = Yii::$app->user->can('administrator');
$smm = Yii::$app->user->can('smm');
$podolog = Yii::$app->user->can('podolog');
$leader = Yii::$app->user->can('leader');

?>
<!--<div class="row">-->
<!--    <div class="col-md-12">-->
<!--        <div class="box">-->
<!--            <div class="jumbotron">-->
<!--                <h2>Учет и ведение пациентов Центра подологии «Щекотливая тема»</h2>-->
<!--                <h3>Подразделение: <b>--><?//=Yii::$app->user->identity->city?><!--, --><?//=Yii::$app->user->identity->address_point?><!--</b></h3>-->
<!--                <p>Внимание! После 2 часов бездействия происходит автоматический выход из аккаунта!</p>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!--<hr>-->
<!--<br>-->
<div class="row">
    <?php if ($admin || $administrator || $leader) { ?>
        <div class="col-md-6">
            <div class="box">
                <?= Html::a('Создать карту клиента', ['card/create'], ['class' => 'btn btn-lg btn-green center-block']) ?>
            </div>
        </div>
    <?php } ?>

    <?php if ($admin || $podolog || $administrator || $leader) { ?>
        <div class="col-md-6">
            <div class="box">
                <?= Html::a('Карты клиентов', ['card/index'], ['class' => 'btn btn-lg btn-info center-block']) ?>
            </div>
        </div>
    <?php } ?>

    <?php if ($admin || $smm || $leader) { ?>
        <div class="col-md-6">
            <div class="box">
                <?= Html::a('Фото работ (из карт клиентов)', ['photo/index'], ['class' => 'btn btn-lg btn-info center-block']) ?>
            </div>
        </div>
    <?php } ?>

    <?php if ($admin || $administrator || $leader) { ?>
        <div class="col-md-6">
            <div class="box">
                <?= Html::a('Пропущенные посещения', ['visit/missed'], ['class' => 'btn btn-lg btn-danger center-block']) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <?= Html::a('Запланированные посещения', ['visit/planned'], ['class' => 'btn btn-lg btn-warning center-block']) ?>
            </div>
        </div>
    <?php } ?>
</div>
<?php if ($admin) { ?>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <h3>Управление сайтом</h3>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <?= Html::a('Отзывы', ['review/index'], ['class' => 'btn btn-lg btn-primary center-block']) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <?= Html::a('Галерея сайта', ['gallery/index'], ['class' => 'btn btn-lg btn-primary center-block']) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <?= Html::a('Прайс-лист', ['pages/price'], ['class' => 'btn btn-lg btn-primary center-block']) ?>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <h3>Управление пользователями</h3>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <?= Html::a('Настройка прав доступа', ['admin/assignment'], ['class' => 'btn btn-lg btn-warning center-block']) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <?= Html::a('Создать нового пользователя', ['user/signup'], ['class' => 'btn btn-lg btn-warning center-block']) ?>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($admin) { ?>
    <hr>
    <br>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <?= Html::a('Обращения', ['pages/support'], ['class' => 'btn btn-lg btn-green center-block']) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <p>Новых обращений: <b><?= $viewed ?></b></p>
                <p>Нерешенных обращений: <b><?= $result ?></b></p>
            </div>
        </div>
    </div>
<?php } ?>