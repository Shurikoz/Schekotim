<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h2 class="text-center">Форма для связи с администратором системы</h2>
        <p>Если у вас в процессе работы с системой учета возникли проблемы или вы нашли ошибку - пожалуйста, напишите об
            этом администратору через эту форму обратной связи. Это поможет не только решить проблему, но и
            поспособствует улучшению работы сервиса.</p>
    </div>
</div>
<br>
<div class="col-md-6 col-md-offset-3">
    <?php $form = ActiveForm::begin(['id' => 'support-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput()->label('Тема обращения *') ?>

    <?= $form->field($model, 'text')->textarea()->label('Описание проблемы *') ?>

    <?= $form->field($model, 'file')->fileInput()->label('Скриншот проблемы') ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary btn-green btn-border-green pull-right', 'name' => 'support-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

