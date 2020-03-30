<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php $photo = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>
<div class="row">
    <div class="col-md-12">
        <div class="titleNormal">Фотографии</div>
        <br>
    </div>
    <div class="col-md-6">
        <p><b>Фото до обработки</b></p>
        <?php for ($i = 0; $i <= 4; $i++) { ?>
            <?php if ($photoBefore[$i] != null) { ?>
                <div class="col-md-6" style="margin-bottom: 20px ">
                    <div class="box">
                        <span><?= Html::a('<img src="' . $photoBefore[$i]->thumbnail . '">', $photoBefore[$i]->url, ['target' => '_blank', 'data-pjax' => '0']) ?></span>
                        <span style="margin-left: 20px">
                            <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['photo/delete-photo', 'id' => $photoBefore[$i]->id], [
                                'class' => 'btn btn-sm btn-info',
                                'data-pjax' => true,
                                'data' => [
                                    'confirm' => 'Вы уверены, что хотите удалить эту фотографию?',
                                ],
                            ]) ?>
                            </span>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
        <?php if (count($photoBefore) < 5) { ?>
            <div class="col-md-6">
                <?= $photo->field($onePhotoBefore, 'onePhotoBefore')->fileInput(['class' => 'btn btn-default', 'style' => 'width: 100%;']) ?>
            </div>
        <?php } ?>

    </div>
    <div class="col-md-6">
        <p><b>Фото после обработки</b></p>
        <?php for ($i = 0; $i <= 4; $i++) { ?>
            <?php if ($photoAfter[$i] != null) { ?>
                <div class="col-md-6" style="margin-bottom: 20px ">
                    <div class="box">
                        <span><?= Html::a('<img src="' . $photoAfter[$i]->thumbnail . '">', $photoAfter[$i]->url, ['target' => '_blank', 'data-pjax' => '0']) ?></span>
                        <span style="margin-left: 20px">
                            <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['photo/delete-photo', 'id' => $photoAfter[$i]->id], [
                                'class' => 'btn btn-sm btn-info',
                                'data-pjax' => true,
                                'data' => [
                                    'confirm' => 'Вы уверены, что хотите удалить эту фотографию?',
                                ],
                            ]) ?>
                        </span>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
        <?php if (count($photoAfter) < 5) { ?>
            <div class="col-md-6">
                <?= $photo->field($onePhotoAfter, 'onePhotoAfter')->fileInput(['class' => 'btn btn-default', 'style' => 'width: 100%;']) ?>
            </div>
        <?php } ?>

    </div>
</div>
<?php ActiveForm::end(); ?>
