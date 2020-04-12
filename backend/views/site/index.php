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

$this->title = 'Панель учета';
?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="site-index">
                <div class="jumbotron">
                    <h2>Система учета центра «Щекотливая тема»</h2>
                    <h3>Внимание! После 2 часов бездействия происходит автоматический выход из аккаунта!</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('manager')) { ?>
        <div class="col-md-6">
            <div class="box">
                <h3 class="text-center">Создать карту пациента</h3>
                <br>
                <?= Html::a('Создать карту', ['card/create'], ['class' => 'btn btn-lg btn-green center-block']) ?>
            </div>
        </div>

    <?php } ?>

    <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('user') || Yii::$app->user->can('manager')) { ?>
        <div class="col-md-6">
            <div class="box">
                <h3 class="text-center">Просмотр карт пациентов</h3>
                <br>
                <?= Html::a('Все карты', ['card/index'], ['class' => 'btn btn-lg btn-info center-block']) ?>
            </div>
        </div>
    <?php } ?>


    <?php if (Yii::$app->user->can('admin')) { ?>
        <div class="col-md-6">
            <div class="box">
                <h3 class="text-center">Отзывы</h3>
                <br>
                <?= Html::a('Показать все отзывы', ['review/index'], ['class' => 'btn btn-lg btn-primary center-block']) ?>
            </div>
        </div>
    <?php } ?>

    <?php if (Yii::$app->user->can('admin')) { ?>
        <div class="col-md-6">
            <div class="box">
                <h3 class="text-center">Галерея</h3>
                <br>
                <?= Html::a('Показать галерею сайта', ['gallery/index'], ['class' => 'btn btn-lg btn-primary center-block']) ?>
            </div>
        </div>
    <?php } ?>

    <?php if (Yii::$app->user->can('admin') || Yii::$app->user->can('smm')) { ?>
        <div class="col-md-6">
            <div class="box">
                <h3 class="text-center">Фото работ (из карт клиентов)</h3>
                <br>
                <?= Html::a('Показать фото работ', ['photo/index'], ['class' => 'btn btn-lg btn-info center-block']) ?>
            </div>
        </div>
    <?php } ?>

    <?php if (Yii::$app->user->can('admin')) { ?>
        <div class="col-md-6">
            <div class="box">
                <h3 class="text-center">Настройка прав доступа</h3>
                <br>
                <?= Html::a('Пользователи', ['admin/user/index'], ['class' => 'btn btn-lg btn-warning center-block']) ?>
            </div>
        </div>
    <?php } ?>
</div>