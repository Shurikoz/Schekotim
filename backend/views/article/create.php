<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Url;
use kartik\file\FileInput;
use kartik\select2\Select2;

$this->title = 'Создание новой статьи';

$data = [
    "red" => "red",
    "green" => "green",
    "blue" => "blue",
    "orange" => "orange",
    "white" => "white",
    "black" => "black",
    "purple" => "purple",
    "cyan" => "cyan",
    "teal" => "teal"
];

?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-left">
            <?= Html::a('Отмена', ['/article/index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3><?= Html::encode($this->title) ?></h3>
        <hr>
    </div>
</div>
<div class="article-create">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
                <br>
                <?= $form->field($model, 'mainPhoto')->fileInput() ?>
                <br>
                <?= $form->field($articleImage, 'secondPhoto[]')
                    ->widget(FileInput::classname(), [
                        'options' => [
                            'multiple' => true,
                            'accept' => 'image/*',
                        ],
                        'pluginOptions' => [
                            'showUpload' => false,
                            'previewFileType' => 'image',
                            'allowedFileExtensions' => ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'PNG'],
                            'maxFileCount' => 8,
                            'uploadUrl' => Url::to(['']),
                            'fileActionSettings' => [
                                'showUpload' => false,
                                'showZoom' => false,

                            ],
                            'showPreview' => true,
                            'showRemove' => false,
                            'showCaption' => false,
                            'browseClass' => 'btn btn-default btn-block',
                        ]
                    ])?>
                <br>

                <?= $form->field($model, 'status')->checkbox(['value' => '1', 'checked ' => true])->label(false); ?>
                <br>
<!--                --><?//= $form->field($model, 'tags')->textarea(['rows' => 3]) ?>

                <?php $model->tags =  []; // initial value?>
                <?= $form->field($model, 'tags')->widget(Select2::classname(), [
                'data' => $data,
                'options' => [
                    'placeholder' => 'Выберите теги ...',
                    'multiple' => true
                ],
                'pluginOptions' => [
                'tags' => true,
                'tokenSeparators' => [',', ' '],
                'maximumInputLength' => 10
                ],
                ]);
                ?>

            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'content')->widget(Widget::className(), [
                    'settings' => [
                        'lang' => 'ru',
                        'minHeight' => 400,
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
        <div class="col-md-12 col-sm-12">
            <div class="form-group pull-right">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-green']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
