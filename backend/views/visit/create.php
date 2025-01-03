<?php

use kartik\date\DatePicker;
use kartik\file\FileInput;
use nirvana\showloading\ShowLoadingAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use rmrevin\yii\fontawesome\FAS;

ShowLoadingAsset::register($this);

$this->title = 'Создание нового посещения. Карта № ' . $card->number;

//посчитаем возраст пациента по дате рождения
$born = new DateTime($card->birthday); // дата рождения
$age = $born->diff(new DateTime)->format('%y');

$specialistList = ArrayHelper::map($specialistModel, 'id', 'name');

$admin = Yii::$app->user->can('admin');
$leader = Yii::$app->user->can('leader');
$podolog = Yii::$app->user->can('podolog');
$dermatolog = Yii::$app->user->can('dermatolog');

?>
<div id="visit-create">
    <div class="row">
        <div class="col-md-12">
            <div class="pull-left">
                <?= Html::button('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Отмена', [
                    'class' => 'btn btn-default',
                    'onclick' => 'history.back();'
                ]) ?>
            </div>
            <div class="pull-right">
                <span style="display: block;margin-top: 5px;" class="titleNormal"><?= Html::encode($this->title) ?></span>
            </div>
        </div>
    </div>
    <hr>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="visit-form"><div class="row">
            <div class="col-md-4 col-sm-12">
                <b>Пациент:</b> <?= $card->surname ?> <?= $card->name ?> <?= $card->middle_name ?></p>
            </div>
            <div class="col-md-4 col-sm-12">
                <b>Возраст:</b> <?= $age ?>
            </div>
            <div class="col-md-4 col-sm-12">
                <?php if ($leader || $admin) { ?>
                    <?= $form->field($model, 'specialist_id')->dropDownList($specialistList, [
                        'prompt' => [
                            'text' => 'Выберите специалиста',
                            'options' => [
                                'value' => '0'
                            ]
                        ]
                    ])->label('<b>Специалист</b>') ?>
                <?php } else { ?>
                    <b>Специалист:</b> <?= $specialist->name ?>
                <?php } ?>
            </div>
        </div>
        <hr>
        <div class="panel panel-default" style="background-color: transparent">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#create_card">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">Данные пациента</div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="pull-right">+</div>
                            </div>
                        </div>
                    </a>
                </h4>
            </div>
            <div id="create_card" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="box">
                                <?= $form->field($card, 'profession')->textInput()->label('Профессия (Кем работает)') ?>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="box">
                                <?= $form->field($card, 'orthopedic_features')->textarea(['rows' => 4]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <?= $form->field($model, 'card_number')->hiddenInput(['value' => (int)Yii::$app->request->get('number')])->label(false); ?>
        <?php if (!$leader && !$admin) { ?>
            <?= $form->field($model, 'specialist_id')->hiddenInput(['value' => $specialist->id])->label(false); ?>
        <?php } ?>
        <?php if ($openProblem) {?>
            <ul class="list-group">
                <li class="list-group-item list-group-item-warning">
                    <p><em>Внимание, имеются незакрытые проблемы - <?php foreach ($openProblem as $item) { echo '<b>'. $item . '</b>; ';} ?></em></p>
                    <p><em>Создание нового посещения с этой проблемой (проблемами) невозможно!</em></p>
                </li>
            </ul>
        <?php } ?>
        <div class="row">
            <div class="col-md-4">
                <div class="box">
                    <?= $form->field($model, 'problem_id')->dropDownList($problem, [
                        'prompt' => [
                            'text' => '-',
                            'options' => [
                                'value' => '0'
                            ]
                        ]
                    ])->label('Проблема <div id="errorData" class="" style="float: right"></div>') ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box">
                    <div class="custom-checkbox">
                        <?= Html::checkbox('secondVisit', false, [
                            'label' => 'Назначить повторное посещение',
                            'labelOptions' => [
                                'class' => 'custom-checkbox'
                            ],
                            'onchange' => 'dateVisitCreate()'
                        ]) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 dateVisit hide">
                <div class="box">
                    <?php
                    echo '<p><label class="control-label">Назначение даты</label></p>';
                    echo DatePicker::widget([
                        'model' => $secondVisit,
                        'name' => 'next_visit_from',
                        'attribute' => 'next_visit_from',
                        'value' => time(),
                        'type' => DatePicker::TYPE_RANGE,
                        'name2' => 'next_visit_by',
                        'attribute2' => 'next_visit_by',
//                        'value2' => date("m.d.Y"),
                        'value2' => time(),
                        'separator' => 'по',
                        'options' => [
                            'placeholder' => 'с день.мес.год',
                            'required' => false,
                        ],
                        'options2' => [
                            'placeholder' => 'по день.мес.год',
                            'required' => false,
                        ],
                        'pluginOptions' => [
                            'autoclose' => false,
                            'format' => 'dd.mm.yyyy',
                            'todayHighlight' => true,
                            'startDate' => date('Ymd'),
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="box">
                    <?= $form->field($model, Html::encode('anamnes'))->textarea(['value' => '', 'rows' => 6]) ?>
                </div>
            </div>
            <?php if ($podolog) { ?>
                <div class="col-md-6 col-sm-6">
                    <div class="box">
                        <?= $form->field($model, 'manipulation')->textarea(['value' => '', 'rows' => 6]); ?>
                    </div>
                </div>
            <?php } elseif ($dermatolog) { ?>
                <div class="col-md-6 col-sm-6">
                    <div class="box">
                        <?= $form->field($model, 'diagnosis')->textarea(['value' => '', 'rows' => 6]); ?>
                    </div>
                </div>
            <?php } elseif ($admin || $leader) { ?>
                <div class="col-md-6 col-sm-6">
                    <div class="box">
                        <?= $form->field($model, 'manipulation')->textarea(['value' => '', 'rows' => 6]); ?>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="box">
                        <?= $form->field($model, 'diagnosis')->textarea(['value' => '', 'rows' => 6]); ?>
                    </div>
                </div>
            <?php } ?>
            <div class="col-md-12 col-sm-12">
                <div class="box">
                    <?= $form->field($model, 'recommendation')->textarea(['value' => '', 'rows' => 6]) ?>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="box">
                    <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
                </div>
            </div>
        </div>
        <hr>
        <p class="titleNormal">Рекомендовано посещение:</p>
        <br>
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="box">
                    <?= $form->field($model, 'dermatolog', ['options' => ['class' => 'form-checkbox']])->checkbox(); ?>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="box">
                    <?= $form->field($model, 'immunolog', ['options' => ['class' => 'form-checkbox']])->checkbox(); ?>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="box">
                    <?= $form->field($model, 'ortoped', ['options' => ['class' => 'form-checkbox']])->checkbox(); ?>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="box">
                    <?= $form->field($model, 'hirurg', ['options' => ['class' => 'form-checkbox']])->checkbox(); ?>
                </div>
            </div>
        </div>
        <hr>
        <p class="titleNormal">Отметить посещение:</p>
        <br>
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="box">
                    <?= $form->field($model, 'special', ['options' => ['class' => 'form-checkbox']])->checkbox(); ?>
                </div>
            </div>
        </div>
        <hr>
        <?php if ($podolog) { ?>
            <p class="titleNormal">Фотографии работ (максимум по 8 фотографий)</p>
            <br>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <p><b>До манипуляций</b></p>
                    <?= $form->field($photoBefore, 'before[]')
                        ->widget(FileInput::classname(), [
                            'options' => [
                                'multiple' => true,
                                'accept' => 'image/*',
                            ],
                            'pluginOptions' => [
                                'showUpload' => false,
                                'previewFileType' => 'image',
                                'allowedFileExtensions' => ['jpg', 'jpeg'],
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
                </div>
                <div class="col-md-6 col-sm-6">
                    <p><b>После манипуляций</b></p>
                    <?= $form->field($photoAfter, 'after[]')
                        ->widget(FileInput::classname(), [
                            'options' => [
                                'multiple' => true,
                                'accept' => 'image/*',
                            ],
                            'pluginOptions' => [
                                'previewFileType' => 'image',
                                'allowedFileExtensions' => ['jpg', 'jpeg'],
                                'showUpload' => false,
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
                                'layoutTemplates' => [
                                    'footer' => '<div class="file-thumbnail-footer" style="height: 0">{indicator}{actions}</div>'
                                ],
                            ]
                        ])?>
                </div>
            </div>
        <?php } ?>
        <?php if ($dermatolog) { ?>
            <p class="titleNormal text-center">Фотографии работ (максимум 8 фотографий)</p>
            <br>
            <div class="row">
                <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
                    <div class="box">
                        <?= $form->field($photoDermatolog, 'dermatolog[]')
                            ->widget(FileInput::classname(), [
                                'options' => [
                                    'multiple' => true,
                                    'accept' => 'image/*',
                                ],
                                'pluginOptions' => [
                                    'showUpload' => false,
                                    'previewFileType' => 'image',
                                    'allowedFileExtensions' => ['jpg', 'jpeg'],
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
                                    'layoutTemplates' => [
                                        'footer' => '<div class="file-thumbnail-footer" style="height: 0">{indicator}{actions}</div>'
                                    ],
                                ]
                            ])?>
                    </div>
                </div>
            </div>
            <hr>
        <?php } ?>
        <hr>
        <div class="form-group pull-right">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-green', 'id' => 'saveBtn']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
