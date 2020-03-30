<?php

use yii\helpers\Html;
use backend\models\Photo;
/* @var $this yii\web\View */
/* @var $model backend\models\Visit */

$this->title = 'Редактирование посещения, карта №: ' . $model->card_number;

?>
<div class="visit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formUpdate', [
        'model' => $model,
        'location' => $location,
        'podolog' => $podolog,
        'problem' => $problem,
        'photoBefore' => $photoBefore,
        'photoAfter' => $photoAfter,
        'onePhotoBefore' => new Photo(),
        'onePhotoAfter' => new Photo()
    ]) ?>

</div>
