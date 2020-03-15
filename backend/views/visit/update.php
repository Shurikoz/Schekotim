<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Visit */

$this->title = 'Редактирование посещения, карта №: ' . $model->card_number;

?>
<div class="visit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <pre>
        <?= print_r($model);?>
    </pre>

<!--    --><?//= $this->render('_formUpdate', [
//        'model' => $model,
//    ]) ?>

</div>
