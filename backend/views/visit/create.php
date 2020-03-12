<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Visit */
$this->title = 'Новое посещение';

?>
<div class="visit-create">

    <?= Html::button('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Отмена', [
        'class' => 'btn btn-default',
        'onclick' => 'history.back();'
    ]) ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'location' => $location,
        'podolog' => $podolog,
        'problem' => $problem,
    ]) ?>

</div>
