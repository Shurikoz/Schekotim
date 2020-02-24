<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Visit */

$this->title = 'Новое посещение';
$this->params['breadcrumbs'][] = ['label' => 'Посещения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::button('Отмена', [
        'class' => 'btn btn-success',
        'onclick' => 'history.back();'
    ]) ?>

    <br>
    <br>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
