<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Visit */
$this->title = 'Новое посещение, карта №: ' . $card->number;

?>
<div class="visit-create">

    <div class="row">
        <div class="col-md-12">
            <?= Html::button('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Отмена', [
                'class' => 'btn btn-default',
                'onclick' => 'history.back();'
            ]) ?>        </div>
    </div>
    <br>
    <p class="titleNormal"><?= Html::encode($this->title) ?></p>

    <?= $this->render('_formCreateFirst', [
        'card' => $card,
        'model' => $model,
        'photoBefore' => $photoBefore,
        'photoAfter' => $photoAfter,
        'podolog' => $podolog,
        'problem' => $problem,
    ]) ?>

</div>
