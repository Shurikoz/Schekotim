<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = 'Уведомления';

?>
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