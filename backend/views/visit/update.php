<?php

use yii\helpers\Html;
use backend\models\Photo;
use rmrevin\yii\fontawesome\FAS;
/* @var $this yii\web\View */
/* @var $model backend\models\Visit */

$this->title = 'Редактирование посещения, карта №: ' . $model->card_number;

?>
<div class="visit-update">
<div class="row">
    <div class="col-md-12">
        <?= Html::a('Отмена', ['/card/view?id=' . $card->id], ['class' => 'btn btn-default']) ?>
    </div>
</div>
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_formUpdate', [
        'model' => $model,
        'location' => $location,
        'podolog' => $podolog,
        'problem' => $problem,
        'photoBefore' => $photoBefore,
        'photoAfter' => $photoAfter,
        'addPhotoBefore' => $addPhotoBefore,
        'addPhotoAfter' => $addPhotoAfter
    ]) ?>
</div>
