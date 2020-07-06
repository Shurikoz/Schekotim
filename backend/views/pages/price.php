<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use vova07\imperavi\Widget;

?>
<div class="row">
    <div class="col-md-12">
        <h3>Прайс-лист</h3>
        <hr>
    </div>
</div>
<?php $form = ActiveForm::begin(['id' => 'price-form']); ?>
<?= $form->field($model, 'text')->label('')->widget(Widget::className(), [
    'settings' => [
        'lang' => 'ru',
        'minHeight' => 200,
        'plugins' => [
            'clips',
            'fullscreen',
        ],
        'clips' => [
            ['Lorem ipsum...', 'Lorem...'],
            ['red', '<span class="label-red">red</span>'],
            ['green', '<span class="label-green">green</span>'],
            ['blue', '<span class="label-blue">blue</span>'],
        ],
    ],
]); ?>
<?= Html::submitButton('Сохранить', [
    'class' => 'btn btn-green pull-right',
    'data' => [
        'confirm' => 'Сохранить прайс-лист?',
        'method' => 'post',
    ]
]) ?>
<?php ActiveForm::end(); ?>
