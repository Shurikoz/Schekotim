<?php

use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\Visit */
/* @var $form yii\widgets\ActiveForm */

$problemName = ArrayHelper::map($problem, 'id', 'name');
array_unshift($problemName, '');
$card_id = (int)Yii::$app->request->get('card_number');
?>
<br>
<div class="visit-form">
    <div class="row">
        <div class="col-md-4">
            <span class="cardInfo"><b>Город:</b> <?= $model->city ?></span>
        </div>
        <div class="col-md-4">
            <span class="cardInfo"><b>Точка:</b> <?= $model->address_point ?></span>
        </div>
        <div class="col-md-4">
            <span class="cardInfo"><b>Подолог:</b> <?= $podolog->name ?></span>
        </div>
    </div>
    <hr>
    <?php $form = ActiveForm::begin(['id' => 'formUpdate']); ?>
    <?= $form->field($model, 'card_number')->hiddenInput(['value' => $card_id])->label(false); ?>
    <?= $form->field($model, 'city')->hiddenInput(['value' => $model->city])->label(false); ?>
    <?= $form->field($model, 'address_point')->hiddenInput(['value' => $model->address_point])->label(false); ?>
    <?= $form->field($model, 'podolog_id')->hiddenInput(['value' => $podolog->id])->label(false); ?>
    <div class="row">
        <div class="col-md-4">
            <div class="box">
                <?= $form->field($model, 'problem_id')
                    ->dropDownList($problemName)
                    ->label('Проблема') ?>
                <div id="errorData" style="color:red"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="box">
                <?= $form->field($model, 'has_come')->checkbox(['value' => '1', 'checked ' => true])->label(false); ?>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <?= $form->field($model, 'anamnes')->textarea(['rows' => 6]) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <?= $form->field($model, 'manipulation')->textarea(['rows' => 6]) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <?= $form->field($model, 'recommendation')->textarea(['rows' => 6]) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
            </div>
        </div>
    </div>
    <hr>
    <?php Pjax::begin(['timeout' => 5000, 'id' => 'photoEdit', 'enablePushState' => false]); ?>
    <div id="photoForm">
        <div class="row">
            <div class="col-md-12">
                <div class="titleNormal">Фотографии</div>
                <br>
            </div>
            <div class="col-md-6">
                <p><b>Фото до обработки</b></p>
                <?php if (count($photoBefore) < 5) { ?>
                    <div class="col-md-12">
                        <?= $form->field($addPhotoBefore, 'before[]')
                            ->widget(FileInput::classname(), [
                                'options' => [
                                    'multiple' => true,
                                    'accept' => 'image/*'
                                ],
                                'pluginOptions' => [
                                    'previewFileType' => 'image',
                                    'allowedFileExtensions' => ['jpg', 'jpeg'],
                                    'showUpload' => false,
                                    'maxFileCount' => 5 - count($photoBefore)
                                ]
                            ]) ?>
                    </div>
                <?php } ?>
                <?php for ($i = 0; $i <= 4; $i++) { ?>
                    <?php if (isset($photoBefore[$i])) { ?>
                        <div class="col-md-6" style="margin-bottom: 20px ">
                            <div id="box_<?= $i ?>" class="box">
                                <span><?= Html::a('<img src="' . $photoBefore[$i]->thumbnail . '">', $photoBefore[$i]->url, ['target' => '_blank', 'data-pjax' => '0']) ?></span>
                                <span style="margin-left: 20px">
                                <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['#'], [
                                    'class' => 'btn btn-sm btn-info',
                                    'onclick' =>
                                        "
                                    if (confirm('Вы уверены, что хотите удалить эту фотографию?')) {    
                                        $.ajax({
                                        type:'POST',
                                        cache: false,
                                        url: '" . Url::to(['visit/delete-photo', 'id' => $photoBefore[$i]->id]) . "',
                                        complete: function() {
                                            $.pjax.reload({container:'#photoEdit'});
                                        }
                                        });
                                    }
                                    return false;
                                ",
                                ]); ?>
                            </span>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="col-md-6">
                <p><b>Фото после обработки</b></p>
                <?php if (count($photoAfter) < 5) { ?>
                    <div class="col-md-12">
                        <?= $form->field($addPhotoAfter, 'after[]')->widget(FileInput::classname(), [
                            'options' => [
                                'multiple' => true,
                                'accept' => 'image/*'
                            ],
                            'pluginOptions' => [
                                'previewFileType' => 'image',
                                'allowedFileExtensions' => ['jpg', 'jpeg'],
                                'showUpload' => false,
                                'maxFileCount' => 5 - count($photoAfter)
                            ]
                        ]) ?>
                    </div>
                <?php } ?>
                <?php for ($i = 0; $i <= 4; $i++) { ?>
                    <?php if (isset($photoAfter[$i])) { ?>
                        <div class="col-md-6" style="margin-bottom: 20px ">
                            <div class="box">
                                <span><?= Html::a('<img src="' . $photoAfter[$i]->thumbnail . '">', $photoAfter[$i]->url, ['target' => '_blank', 'data-pjax' => '0']) ?></span>
                                <span style="margin-left: 20px">
                            <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['#'], [
                                'class' => 'btn btn-sm btn-info',
                                'onclick' =>
                                    "
                                    if (confirm('Вы уверены, что хотите удалить эту фотографию?')) {    
                                        $.ajax({
                                        type:'POST',
                                        cache: false,
                                        url: '" . Url::to(['visit/delete-photo', 'id' => $photoAfter[$i]->id]) . "',
                                        complete: function() {
                                            $.pjax.reload({container:'#photoEdit'});
                                        }
                                        });
                                    }
                                    return false;
                                ",
                            ]); ?></span>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
    <hr>
    <div class="form-group pull-right">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>