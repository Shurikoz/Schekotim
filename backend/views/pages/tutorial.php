<?php
$manager = Yii::$app->user->can('manager');
$smm = Yii::$app->user->can('smm');
$user = Yii::$app->user->can('user');
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
    <?php } elseif ($smm) { ?>
        <?= $this->render('tutorial/smm') ?>
    <?php } elseif ($manager) { ?>
        <?= $this->render('tutorial/manager') ?>
    <?php } ?>
</div>