<?php
$administrator = Yii::$app->user->can('administrator');
$admin = Yii::$app->user->can('admin');
$smm = Yii::$app->user->can('smm');
$podolog = Yii::$app->user->can('podolog');
$leader = Yii::$app->user->can('leader');
?>
<div class="row">
    <div class="col-md-12">
        <h3>Как это работает?</h3>
        <hr>
    </div>
</div>
<div class="panel-group" id="accordion">

    <?php if ($podolog) { ?>
        <?= $this->render('tutorial/podolog') ?>
    <?php } ?>

    <?php if ($smm) { ?>
        <?= $this->render('tutorial/smm') ?>
    <?php } ?>

    <?php if ($administrator) { ?>
        <?= $this->render('tutorial/administrator') ?>
    <?php } ?>

    <?php if ($leader || $admin) { ?>
        <h4>Подолог</h4>
        <?= $this->render('tutorial/podolog') ?>
        <hr>
        <h4>Менеджер</h4>
        <?= $this->render('tutorial/administrator') ?>
        <hr>
        <h4>SMM</h4>
        <?= $this->render('tutorial/smm') ?>
    <?php } ?>

</div>