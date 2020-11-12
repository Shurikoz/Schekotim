<?php

use yii\helpers\Html;
use common\widgets\Alert;

$this->title = 'Реестр сертификатов об обучении';
?>

<div class="row">
    <div class="col-md-12">
        <h3><?= Html::encode($this->title) ?></h3>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= Html::a('Добавить новый сертификат', ['create'], ['class' => 'btn btn-green pull-right']) ?>
    </div>
</div>
<hr>
<br>

<div class="row">
    <div class="col-md-12">
        <table class="c-table">
            <thead class="c-table__head c-table__head--slim">
            <tr class="c-table__row">
                <th class="c-table__cell c-table__cell--head" width="5%">Номер</th>
                <th class="c-table__cell c-table__cell--head" width="10%">Дата</th>
                <th class="c-table__cell c-table__cell--head" width="35%">ФИО</th>
                <th class="c-table__cell c-table__cell--head" width="35%">Курс</th>
                <th class="c-table__cell c-table__cell--head" width="15%"></th>
            </tr>
            </thead>
            <tbody>
            <?= Alert::widget() ?>
            <?php if (count($model) != 0) { ?>
                <?php foreach (array_reverse($model) as $item) { ?>
                    <tr class="c-table__row">
                        <td class="c-table__cell">
                            <?= $item->number ?>
                        </td>
                        <td class="c-table__cell">
                            <?= $item->date ?>
                        </td>
                        <td class="c-table__cell">
                            <?= $item->name ?>
                        </td>
                        <td class="c-table__cell">
                            <?= $item->course ?>
                        </td>
                        <td class="c-table__cell cardBtn">
                            <?= Html::a('<span class="glyphicon glyphicon-pencil" title="Редактировать"></span>', ['registry/update', 'id' => $item->id], ['class' => 'btn']) ?>
                            <?= Html::a('<span class="glyphicon glyphicon-trash" title="Удалить"></span>', ['registry/delete', 'id' => $item->id], [
                                'class' => 'btn',
                                'data-confirm' => 'Удалить сертификат №' . $item->number . '?'
                            ]) ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr class="c-table__row">
                    <td colspan="10" class="c-table__cell--empty">Записей нет</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>