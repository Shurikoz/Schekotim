<?php

use yii\helpers\Html;

?>
<div class="row">
    <div class="col-md-12">
        <h3>Акции и скидки</h3>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= Html::a('Создать новую акцию', ['create'], ['class' => 'btn btn-green pull-right']) ?>
    </div>
</div>
<hr>
<br>

<div class="row">
    <div class="col-md-12">
        <table class="c-table">
            <thead class="c-table__head c-table__head--slim">
            <tr class="c-table__row">
                <th class="c-table__cell c-table__cell--head" width="25%">Заголовок</th>
                <th class="c-table__cell c-table__cell--head" width="25%">Время завершения</th>
                <th class="c-table__cell c-table__cell--head" width="25%">Публикация</th>
                <th class="c-table__cell c-table__cell--head" width="25%">Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php if (count($model) != 0) { ?>
                <?php foreach (array_reverse($model) as $item) { ?>
                    <tr class="c-table__row">
                        <td class="c-table__cell" width="30%">
                            <?= $item->title ?>
                        </td>
                        <td class="c-table__cell" width="25%">
                            <?php if ($item->endtime) { ?>
                                <?= $item->endtime ?>
                            <?php } else { ?>
                                Не установлено
                            <?php } ?>
                        </td>
                        <td class="c-table__cell" width="25%">
                            <?= $item->public == 1 ? '<span style="color: #7ba335;">Активный</span>' : '<span style="color: #c55;">Неактивный</span>' ?>
                        </td>
                        <td class="c-table__cell cardBtn" width="15%">

                            <?= Html::a('<span class="glyphicon glyphicon-pencil" title="Редактировать"></span>', ['stock/update', 'id' => $item->id], ['class' => 'btn']) ?>
                            <?= Html::a('<span class="glyphicon glyphicon-trash" title="Удалить"></span>', ['stock/delete', 'id' => $item->id], [
                                'class' => 'btn',
                                'data-confirm' => 'Удалить акцию?'
                            ]) ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr class="c-table__row">
                    <td colspan="10" class="c-table__cell--empty">Акций нет</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>