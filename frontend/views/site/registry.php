<?php

use yii\helpers\FileHelper;
use yii\helpers\Html;

//получим все сертификаты из папки certificates
$files = FileHelper::findFiles('images/sertificates');

$this->title = 'Реестр сертификатов';
$header = 'Реестр сертификатов';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Центр маникюра, педикюра и подологии «Щекотливая тема» - Реестр сертификатов об обучении'
]);
?>
<!-- Header -->
<?= $this->render('/partials/_header', compact('header')); ?>
<!-- Content -->
<section>
    <header class="main">
        <div class="row">
            <div class="col-12 col-12-medium">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
        </div>
    </header>
    <div class="row">
        <div class="col-12 col-12-medium">
            <p>Реестр сертификатов, выданных в Центре подологии «Щекотливая тема»</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-12-medium">
            <div class="table-wrapper">
                <table>
                    <thead>
                    <tr>
                        <th width="5%" >№</th>
                        <th width="10%">Дата</th>
                        <th width="35%">ФИО</th>
                        <th width="50%">Курс</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (count($model) != 0) { ?>
                        <?php foreach (array_reverse($model) as $item) { ?>
                            <tr>
                                <td><?= $item->number ?></td>
                                <td><?= $item->date ?></td>
                                <td><?= $item->name ?></td>
                                <td><?= $item->course ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="4" class="text-center">Сертификатов нет</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
