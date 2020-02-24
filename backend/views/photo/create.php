<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Photo */

$this->title = 'Create Photo Visit';
$this->params['breadcrumbs'][] = ['label' => 'Photo Visits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photo-visit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
