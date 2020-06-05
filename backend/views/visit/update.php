<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Visit */

$this->title = 'Редактирование посещения, карта №: ' . $model->card_number;

?>
<div class="visit-update">
<div class="row">
    <div class="col-md-12">
        <?= Html::a('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Отмена', ['/card/view', 'number' => $model->card_number], ['class' => 'btn btn-default']) ?>
    </div>
</div>
    <br>
    <p class="titleNormal"><?= Html::encode($this->title) ?></p>
    <?= $this->render('_formUpdate', [
        'card' => $card,
        'model' => $model,
        'podolog' => $podolog,
        'problem' => $problem,
        'photoBefore' => $photoBefore,
        'photoAfter' => $photoAfter,
        'addPhotoBefore' => $addPhotoBefore,
        'addPhotoAfter' => $addPhotoAfter
    ]) ?>
</div>
