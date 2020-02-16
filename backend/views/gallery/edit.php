<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Gallery */
/* @var $form ActiveForm */
?>
<div class="gallery-upload">

    <img width="180" src="<?= 'http://schekotim.ru/images/gallery/thumbnail/' . $model->filename; ?>"
         alt="">
    <br>
    <br>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?=
    $form->field($model, 'category')->dropDownList([
        '0' => 'Подология',
        '1' => 'Маникюр',
        '2' => 'Педикюр'
    ]);
    ?>

    <?= $form->field($model, 'title') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
