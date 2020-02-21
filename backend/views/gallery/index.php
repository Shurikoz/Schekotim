<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

?>
<div class="box">

<h1>Галерея</h1>

<p>
    <?php echo Html::a('Загрузить фото', ['gallery/upload'], ['class' => 'btn btn-primary']) ?>
</p>

<hr class="major"/>
<h3>#подология</h3>
<div class="row">
    <?php foreach ($podolog as $photo) { ?>
        <div class="col-md-3">
            <div class="photo-block">
                <img width="180" src="<?= 'http://schekotim.ru/images/gallery/thumbnail/' . $photo->filename; ?>"
                     alt="">
                <p><?= $photo->title ?></p>
                <?php echo Html::a('Удалить', ['gallery/delete', 'id' => $photo->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить фото?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?php echo Html::a('Изменить', ['gallery/edit', 'id' => $photo->id], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    <?php } ?>
</div>

<hr class="major"/>
<h3>#маникюр</h3>

<div class="row">
    <?php foreach ($manicure as $photo) { ?>
        <div class="col-md-3">
            <div class="photo-block">
                <img width="180" src="<?= 'http://schekotim.ru/images/gallery/thumbnail/' . $photo->filename; ?>"
                     alt="">
                <p><?= $photo->title ?></p>
                <?php echo Html::a('Удалить', ['gallery/delete', 'id' => $photo->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить фото?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?php echo Html::a('Изменить', ['gallery/edit', 'id' => $photo->id], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    <?php } ?>
</div>

<hr class="major"/>
<h3>#педикюр</h3>

<div class="row">
    <?php foreach ($pedicure as $photo) { ?>
        <div class="col-md-3">
            <div class="photo-block">
                <img width="180" src="<?= 'http://schekotim.ru/images/gallery/thumbnail/' . $photo->filename; ?>"
                     alt="">
                <p><?= $photo->title ?></p>
                <?php echo Html::a('Удалить', ['gallery/delete', 'id' => $photo->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить фото?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?php echo Html::a('Изменить', ['gallery/edit', 'id' => $photo->id], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    <?php } ?>
</div>
</div>