<?php

use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="problem-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'name')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'anamnes')->widget(Widget::className(), [
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 200,
                    'paragraphize' => false,
                    'pastePlainText'  => true,
                    'shortcodes' => false,
                    'showSource' => true,
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
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'manipulation')->widget(Widget::className(), [
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 200,
                    'paragraphize' => false,
                    'pastePlainText'  => true,
                    'shortcodes' => false,
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
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'recommendation')->widget(Widget::className(), [
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 200,
                    'paragraphize' => false,
                    'pastePlainText'  => true,
                    'shortcodes' => false,
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
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'diagnosis')->widget(Widget::className(), [
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 200,
                    'paragraphize' => false,
                    'pastePlainText'  => true,
                    'shortcodes' => false,
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
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-green pull-right']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
