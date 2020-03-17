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

    <p class="titleNormal"><?= Html::encode($this->title) ?></p>

    <?= $this->render('_formCreateFirst', [
        'modelFirst' => $modelFirst,
        'modelSecond' => $modelSecond,
        'location' => $location,
        'podolog' => $podolog,
        'problem' => $problem,
    ]) ?>

</div>
