<?php
$manager = Yii::$app->user->can('manager');
$admin = Yii::$app->user->can('admin');
$smm = Yii::$app->user->can('smm');
$user = Yii::$app->user->can('user');
$leader = Yii::$app->user->can('leader');
?>
<div class="row">
    <div class="col-md-12">
        <h3>Как это работает?</h3>
        <hr>
    </div>
</div>
<div class="panel-group" id="accordion">

    <?php if ($user) { ?>
        <?= $this->render('tutorial/user') ?>
    <?php } ?>

    <?php if ($smm) { ?>
        <?= $this->render('tutorial/smm') ?>
    <?php } ?>

    <?php if ($manager) { ?>
        <?= $this->render('tutorial/manager') ?>
    <?php } ?>

    <?php if ($leader || $admin) { ?>
        <h4>Подолог</h4>
        <?= $this->render('tutorial/user') ?>
        <hr>
        <h4>Менеджер</h4>
        <?= $this->render('tutorial/manager') ?>
        <hr>
        <h4>SMM</h4>
        <?= $this->render('tutorial/smm') ?>
    <?php } ?>

</div>