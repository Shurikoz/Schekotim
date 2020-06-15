<?php

/* @var $this yii\web\View */

/*
 * 4 типа пользователей:
 *  admin
 *	user
 *	smm
 *	Manager
 */

use yii\helpers\Html;

$this->title = 'Учет пациентов';

$admin = Yii::$app->user->can('admin');
$manager = Yii::$app->user->can('manager');
$smm = Yii::$app->user->can('smm');
$user = Yii::$app->user->can('user');

?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="jumbotron">
                <h2>Учет и ведение пациентов Центра подологии «Щекотливая тема»</h2>
                <h3>Подразделение: <b><?=Yii::$app->user->identity->city?>, <?=Yii::$app->user->identity->address_point?></b></h3>
                <p>Внимание! После 2 часов бездействия происходит автоматический выход из аккаунта!</p>
            </div>
        </div>
    </div>
</div>
<?php if ($admin) { ?>
<hr>
<br>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <h3 class="text-center">Служба поддержки</h3>
            <br>
            <?= Html::a('Обращения', ['pages/support'], ['class' => 'btn btn-lg btn-green center-block']) ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box">
            <p>Новых обращений: 0</p>
        </div>
    </div>
</div>
<?php } ?>
<hr>
<br>
<div class="row">
    <?php if ($admin || $manager) { ?>
        <div class="col-md-6">
            <div class="box">
                <h3 class="text-center">Создать карту пациента</h3>
                <br>
                <?= Html::a('Создать карту', ['card/create'], ['class' => 'btn btn-lg btn-green center-block']) ?>
            </div>
        </div>
    <?php } ?>

    <?php if ($admin || $user || $manager) { ?>
        <div class="col-md-6">
            <div class="box">
                <h3 class="text-center">Просмотр карт пациентов</h3>
                <br>
                <?= Html::a('Все карты', ['card/index'], ['class' => 'btn btn-lg btn-info center-block']) ?>
            </div>
        </div>
    <?php } ?>

    <?php if ($admin || $smm) { ?>
        <div class="col-md-6">
            <div class="box">
                <h3 class="text-center">Фото работ (из карт клиентов)</h3>
                <br>
                <?= Html::a('Показать фото работ', ['photo/index'], ['class' => 'btn btn-lg btn-info center-block']) ?>
            </div>
        </div>
    <?php } ?>

    <?php if ($admin || $manager) { ?>
        <div class="col-md-6">
            <div class="box">
                <h3 class="text-center">Просмотр пропущенных посещений</h3>
                <br>
                <?= Html::a('Просмотр пропущенных посещений', ['visit/view'], ['class' => 'btn btn-lg btn-danger center-block']) ?>
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
                <h3 class="text-center">Отзывы</h3>
                <br>
                <?= Html::a('Показать все отзывы', ['review/index'], ['class' => 'btn btn-lg btn-primary center-block']) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <h3 class="text-center">Галерея</h3>
                <br>
                <?= Html::a('Показать галерею сайта', ['gallery/index'], ['class' => 'btn btn-lg btn-primary center-block']) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <h3 class="text-center">Прайс-лист</h3>
                <br>
                <?= Html::a('Редактировать прайс-лист', ['pages/price'], ['class' => 'btn btn-lg btn-primary center-block']) ?>
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
                <h3 class="text-center">Настройка прав доступа</h3>
                <br>
                <?= Html::a('Пользователи', ['admin/user/index'], ['class' => 'btn btn-lg btn-warning center-block']) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <h3 class="text-center">Создать нового пользователя</h3>
                <br>
                <?= Html::a('Создать', ['site/signup'], ['class' => 'btn btn-lg btn-warning center-block']) ?>
            </div>
        </div>
    </div>
<?php } ?>
