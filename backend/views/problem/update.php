<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Problem */

$this->title = 'Изменение шаблона: ' . $model->name;

?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-left">
            <?= Html::a('Отмена', ['problem/index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>
<div class="problem-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
