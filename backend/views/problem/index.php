<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use rmrevin\yii\fontawesome\FAS;

$this->title = 'Шаблоны для специалистов';
$num = 0;
?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-left">
            <?= Html::a(FAS::icon('angle-left', ['class' => 'big', 'data-role' => 'arrow']) . '&nbsp В главное меню', ['/'], ['class' => 'btn btn-default']) ?>
        </div>
        <div class="pull-right">
            <span style="display: block;margin-top: 5px;" class="titleNormal"><?= Html::encode($this->title) ?></span>
        </div>
    </div>
</div>
<hr>
<?php Pjax::begin(['enablePushState' => false]); ?>
<div class="row">
    <div class="col-md-12">
        <?= Html::a('Создать шаблон', ['create'], ['class' => 'btn btn-green pull-right']) ?>
    </div>
</div>
<br>
<div class="problem-index">
    <table class="c-table">
        <thead class="c-table__head c-table__head--slim">
        <tr class="c-table__row">
            <th class="c-table__cell c-table__cell--head" width="10%">Номер</th>
            <th class="c-table__cell c-table__cell--head" width="60%">Проблема</th>
            <th class="c-table__cell c-table__cell--head" width="10%">Порядок</th>
            <th class="c-table__cell c-table__cell--head" width="20%">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($dataProvider->getModels()) != 0) { ?>
            <?php foreach ($dataProvider->getModels() as $item) { ?>
                <tr class="c-table__row openBox" data-id="<?= $item->id ?>">
                    <td class="c-table__cell">
                        <?php $num++; ?>
                        <?= $num ?>
                    </td>
                    <td class="c-table__cell">
                        <?= $item->name ?>
                    </td>
                    <td class="c-table__cell">
                        <?php
                        if ($item->number != ($model)[0]["number"]) {
                            echo Html::a('<span style="font-size: 18px" class="glyphicon glyphicon-chevron-up"></span>', ['problem/up', 'id' => $item->id], ['title' => 'Поднять']) . '<br>';
                        }
                        if ($item->number != end($model)["number"]) {
                            echo Html::a('<span style="font-size: 18px" class="glyphicon glyphicon-chevron-down"></span>', ['problem/down', 'id' => $item->id], ['title' => 'Опустить']);
                        }
                        ?>
                    </td>
                    <td class="c-table__cell cardBtn">
                        <?= Html::a('<span style="font-size: 18px" class="glyphicon glyphicon-pencil"></span>', ['problem/update', 'id' => $item->id], ['title' => 'Редактировать', 'class' => 'btn']); ?>
                        <?= Html::a('<span style="font-size: 18px" class="glyphicon glyphicon-trash"></span>', ['problem/delete', 'id' => $item->id], [
                                'title' => 'Удалить',
                            'class' => 'btn',
                            'data' => [
                                    'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                                    'method' => 'post'
                            ]]); ?>
                    </td>
                </tr>
                <tr class="c-table__row infoBlock hide hideBox">
                    <td colspan="10" class="c-table__infoBlock">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box">
                                    <p><b>Анамнез:</b></p>
                                    <br>
                                    <p><?= $item->anamnes == null ? '<em>Не заполнено</em>' : nl2br($item->anamnes) ?></p>
                                </div>
                                <div class="box">
                                    <p><b>Манипуляции:</b></p>
                                    <br>
                                    <p><?= $item->manipulation == null ? '<em>Не заполнено</em>' : nl2br($item->manipulation) ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="box">
                                    <p><b>Рекомендации:</b></p>
                                    <br>
                                    <p><?= $item->recommendation == null ? '<em>Не заполнено</em>' : nl2br($item->recommendation) ?></p>
                                </div>
                                <div class="box">
                                    <p><b>Диагноз:</b></p>
                                    <br>
                                    <p><?= $item->diagnosis == null ? '<em>Не заполнено</em>' : nl2br($item->diagnosis) ?></p>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr class="c-table__row">
                <td colspan="10" class="c-table__cell--empty">Шаблонов нет</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<?php Pjax::end(); ?>