<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Gallery */
/* @var $form ActiveForm */
?>
<div class="row">
    <div class="col-md-12">
        <h3>Загрузка фото</h3>
        <hr>
    </div>
</div>
<div class="gallery-upload">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($model, 'filename')->fileInput() ?>
        <?=
        $form->field($model, 'category')->dropDownList([
            '0' => 'Подология',
            '1' => 'Маникюр',
            '2' => 'Педикюр'
        ]);
        ?>

        <?= $form->field($model, 'title') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Загрузить', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
