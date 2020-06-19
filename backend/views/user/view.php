<?php

use rmrevin\yii\fontawesome\FAS;
use yii\helpers\Html;

\yii\web\YiiAsset::register($this);

?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-left">
            <?= Html::a(FAS::icon('angle-left', ['class' => 'big', 'data-role' => 'arrow']) . '&nbsp Вернуться к списку пользователей', ['/user/index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3>Пользователь: <?= $model->username ?></h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
    </div>
</div>
<br>
<pre>
    <?= print_r($model) ?>
</pre>