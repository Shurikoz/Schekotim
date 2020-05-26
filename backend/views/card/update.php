<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Card */

$this->title = 'Редактирование карты №: ' . $cardModel->number;


?>
<div class="card-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formUpdate', [
        'cardModel' => $cardModel,
//        'podologModel' => $podologModel,
    ]) ?>

</div>
