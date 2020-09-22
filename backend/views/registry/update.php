<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Registry */

$this->title = 'Изменение сертификата №: ' . $model->number;

?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-left">
            <?= Html::a('Отмена', ['/registry/index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3><?= Html::encode($this->title) ?></h3>
        <hr>
    </div>
</div>
<div class="registry-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
