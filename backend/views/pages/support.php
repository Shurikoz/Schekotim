<?php
?>

<?php

use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model backend\models\Visit */

YiiAsset::register($this);
?>
<table class="c-table">
    <caption class="c-table__title">
        Лист обращений в службу поддержки
        <small>Всего обращений: <?= count($model) ?></small>
    </caption>
    <thead class="c-table__head c-table__head--slim">
    <tr class="c-table__row">
        <th class="c-table__cell c-table__cell--head">ID</th>
        <th class="c-table__cell c-table__cell--head">Пользователь</th>
        <th class="c-table__cell c-table__cell--head">Заголовок</th>
        <th class="c-table__cell c-table__cell--head">Скриншот</th>
        <th class="c-table__cell c-table__cell--head">Дата / Время</th>
        <th class="c-table__cell c-table__cell--head">Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php if (count($model) != 0) { ?>
        <?php foreach (array_reverse($model) as $item) { ?>
            <tr class="c-table__row">
                <td class="c-table__cell">
                    <?= $item->id ?>
                </td>
                <td class="c-table__cell">
                    <?= $item->user->username ?>
                </td>
                <td class="c-table__cell">
                    <?= $item->title ?>
                </td>
                <td class="c-table__cell">
                    <?php if ($item->file_url != null) { ?>
                        <a href="<?= $item->file_url ?>" target="_blank"><img src="<?= $item->file_url ?>" alt="" width="65px" height="auto"></a>
                    <?php } else { ?>
                        <p>-</p>
                    <?php } ?>
                </td>
                <td class="c-table__cell">
                    <?= $item->date ?>
                    <br>
                    <?= $item->time ?>
                </td>
                <td class="c-table__cell cardBtn">
                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr class="c-table__row">
            <td colspan="10" class="c-table__cell--empty">Обращений нет</td>
        </tr>
    <?php } ?>
    </tbody>
</table>