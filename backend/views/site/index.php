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
$dermatolog = Yii::$app->user->can('dermatolog');
$leader = Yii::$app->user->can('leader');

?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <p>По вопросам работы программы, ошибкам и прочим багам обращаться в <b><a href="https://api.whatsapp.com/send?phone=+79262643854">WhatsApp</a></b> или по телефону <b><a href="tel:+79262643854">+7(926)264-38-54</a></b> Александр</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <p>По вопросам редактирования введенных данных, удалению/редактированию посещения или карты обращаться к руководству Центра.</p>
        </div>
    </div>
</div>
    <hr>
    <br>

<?php if ($admin) { ?>
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="box">
                <?= Html::a('Обращения', ['pages/support'], ['class' => 'btn btn-lg btn-green center-block']) ?>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="box">
                <p>Новых обращений: <b><?= $viewed ?></b></p>
                <p>Нерешенных обращений: <b><?= $result ?></b></p>
            </div>
        </div>
    </div>
    <hr>
<?php } ?>
<div class="row">
    <?php if ($admin || $administrator || $leader) { ?>
        <div class="col-md-6 col-sm-6">
            <div class="box">
                <?= Html::a('Создать карту клиента', ['card/create'], ['class' => 'btn btn-lg btn-green center-block']) ?>
            </div>
        </div>
    <?php } ?>

    <?php if ($admin || $podolog || $dermatolog || $administrator || $leader) { ?>
        <div class="col-md-6 col-sm-6">
            <div class="box">
                <?= Html::a('Карты клиентов', ['card/index'], ['class' => 'btn btn-lg btn-info center-block']) ?>
            </div>
        </div>
        <?php if ($admin || $leader || $podolog || $dermatolog) { ?>
            <div class="col-md-6 col-sm-6 col-sm-6">
                <div class="box">
                    <?= Html::a('Календарь', ['/event'], ['class' => 'btn btn-lg btn-primary center-block']) ?>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

    <?php if ($admin || $smm || $leader) { ?>
        <div class="col-md-6 col-sm-6">
            <div class="box">
                <?= Html::a('Фото работ (из карт клиентов)', ['photo/index'], ['class' => 'btn btn-lg btn-info center-block']) ?>
            </div>
        </div>
    <?php } ?>

    <?php if ($admin || $administrator || $leader) { ?>
        <div class="col-md-6 col-sm-6">
            <div class="box">
                <?= Html::a('Пропущенные посещения', ['visit/missed'], ['class' => 'btn btn-lg btn-danger center-block']) ?>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="box">
                <?= Html::a('Запланированные посещения', ['visit/planned'], ['class' => 'btn btn-lg btn-warning center-block']) ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($admin || $administrator || $leader) { ?>
        <div class="col-md-6  col-sm-6 col-sm-6">
            <div class="box">
                <?= Html::a('Посещения без фото', ['visit/nophotos'], ['class' => 'btn btn-lg btn-default center-block']) ?>
            </div>
        </div>
    <?php } ?>
</div>
<?php if ($admin || $leader) { ?>
    <hr>
    <div class="row">
        <div class="col-md-6 col-sm-6 col-sm-6">
            <div class="box">
                <?= Html::a('Логи', ['logs/index'], ['class' => 'btn btn-lg btn-info center-block']) ?>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-sm-6">
            <div class="box">
                <?= Html::a('Шаблоны для специалистов', ['problem/index'], ['class' => 'btn btn-lg btn-info center-block']) ?>
            </div>
        </div>
    </div>
<?php } ?>