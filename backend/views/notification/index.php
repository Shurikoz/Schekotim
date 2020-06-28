<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

?>
    <ul class="nav nav-tabs nav-justified">
        <li class="active"><a href="#">Меню 1</a></li>
        <li><a href="#">Меню 2</a></li>
        <li><a href="#">Меню 3</a></li>
    </ul>
<div class="row">
    <div class="col-md-12">
        <h3>Уведомления</h3>
        <hr>
    </div>
</div>
<p><?= date('H:i:s') ?></p>
<?php Pjax::begin(); ?>

<div class="form-group">
    <?= Html::a("Получить", ['/notification/notif'], ['class' => 'btn btn-primary']) ?>
</div>
<br>
<?= $result ?>

<?php Pjax::end(); ?>