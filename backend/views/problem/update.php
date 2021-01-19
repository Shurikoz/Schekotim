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
        <div class="pull-right">
            <span style="display: block;margin-top: 5px;" class="titleNormal"><?= Html::encode($this->title) ?></span>
        </div>
    </div>
</div>
<hr>
<div class="problem-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
