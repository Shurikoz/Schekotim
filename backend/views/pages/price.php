<?php
use dosamigos\ckeditor\CKEditor;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<h3>Прайс-лист</h3>

<?php $form = ActiveForm::begin(['id' => 'price-form']); ?>

<?= $form->field($model, 'text')->label('')->widget(CKEditor::className(), [
    'options' => [
        'rows' => 6,
        ],
    'clientOptions' => [
        'fullPage' => true,
        'extraPlugins' => 'docprops',
        'allowedContent' => true,
        'height' => 700,

    ],
    'preset' => 'full'
]) ?>
<?= Html::submitButton('Сохранить', [
    'class' => 'btn btn-lg btn-green pull-right',
    'data' => [
        'confirm' => 'Сохранить прайс-лист?',
        'method' => 'post',
    ]
]) ?>
<?php ActiveForm::end(); ?>
