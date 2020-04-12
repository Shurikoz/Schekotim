<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
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
                <?php if ($photoBefore[$i] != null) { ?>
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
                <?php if ($photoAfter[$i] != null) { ?>
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
