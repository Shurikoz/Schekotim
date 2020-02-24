<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Card */

$this->title = 'Создание новой карты пациента';
$this->params['breadcrumbs'][] = ['label' => 'Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-create">
    <div class="box">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>
