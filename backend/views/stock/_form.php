<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use dosamigos\ckeditor\CKEditor;

?>

<div class="stock-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'text')->label('Текст')->widget(CKEditor::className(), [
                'options' => [
                    'rows' => 6,
                ],
                'clientOptions' => [
                    'fullPage' => true,
                    'extraPlugins' => 'docprops',
                    'allowedContent' => true,
                    'height' => 300,
                ],
                'preset' => 'full'
            ])?>
<!--            --><?php //if (!$model->image) {?>
            <?= $form->field($model, 'file')->fileInput() ?>
            <p>* Изображение должно быть равностороннее (квадратное) любого разрешения. Оно будет автоматически уменьшено до необходимого (246x246 px) для корректного отображения н сайте</p>
            <br>
<!--            --><?php //} else { ?>
<!--                <p>Изображение акции</p>-->
<!--                <img src="--><?//= Yii::getAlias('https://schekotim.ru/') . $model->image ?><!--" alt="">-->
<!--                <br>-->
<!--                <br>-->
<!--            --><?php //}  ?>
            <?= $form->field($model, 'endtime')->widget(DatePicker::classname(), [
                'options' => [
                    'placeholder' => 'дд.мм.гггг',
                    'class' => 'c-input'
                ],
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
                    'startDate' => date('Ymd'),
                    'todayHighlight' => true,
                ]
            ])?>
            <?= $form->field($model, 'public')->checkbox(['value' => '1', 'checked ' => false])->label(false); ?>
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
