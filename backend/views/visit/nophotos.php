<?php

use backend\models\Photo;
use yii\helpers\Html;

?>
<?php foreach ($visit as $item) { ?>
    <?php if (Photo::countPhotoBefore($item->photo) == 0 || Photo::countPhotoAfter($item->photo) == 0) { ?>

    <?php } ?>
<?php } ?>

<table class="c-table">
    <caption class="c-table__title">
        Лист посещений без фотографий
    </caption>
    <thead class="c-table__head c-table__head--slim">
    <tr class="c-table__row">
        <th class="c-table__cell c-table__cell--head">Карта</th>
        <th class="c-table__cell c-table__cell--head">ФИО</th>
        <th class="c-table__cell c-table__cell--head">Город / Точка</th>
        <th class="c-table__cell c-table__cell--head">Проблема</th>
        <th class="c-table__cell c-table__cell--head">Подолог</th>
        <th class="c-table__cell c-table__cell--head">Дата визита</th>
        <th class="c-table__cell c-table__cell--head">Отметки</th>
        <th class="c-table__cell c-table__cell--head">Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($visit as $item) { ?>
    <?php if (Photo::countPhotoBefore($item->photo) == 0 || Photo::countPhotoAfter($item->photo) == 0) { ?>
            <tr class="c-table__row">
                <td class="c-table__cell">
                    <?= $item->card_number?>
                </td>
                <td class="c-table__cell">
                    <p><?= $item->card->surname?></p>
                    <p><?= $item->card->name?></p>
                    <p><?= $item->card->middle_name?></p>
                </td>
                <td class="c-table__cell">
                    <p><?= $item->city->name ?></p>
                    <p><?= $item->address_point->address_point?></p>
                </td>
                <td class="c-table__cell">
                    <?php if ($item->problem_id == 0) { ?>
                        <span class="text-red">Не указана</span>
                    <?php } else { ?>
                        <?= $item->problem->name ?>
                    <?php } ?>
                </td>
                <td class="c-table__cell">
                    <?= $item->specialist->name ?>
                </td>
                <td class="c-table__cell">
                    <?php if ($item->next_visit_from != null && $item->next_visit_by != null && $item->has_come == 0) { ?>
                        <p>с <?= Yii::$app->formatter->asDate($item->next_visit_from) ?></p>
                        <p>до <?= Yii::$app->formatter->asDate($item->next_visit_by) ?></p>
                    <?php } else if ($item->has_come == 1) { ?>
                        <span> <?= Yii::$app->formatter->asDate($item->visit_date) ?></span>
                    <?php } else if ($item->has_come == 2) { ?>
                        <span>-</span>
                    <?php } ?>
                </td>
                <td class="c-table__cell">
                    <span class="glyphicon glyphicon-camera"></span>
                </td>
                <td class="c-table__cell cardBtn">
                    <?= Html::a('<span class="glyphicon glyphicon-new-window"></span>', ['card/view', 'number' => $item->card_number], [
                        'class' => 'btn linkNewWindow',
                        'title' => 'Открыть карту пациента'
                    ]) ?>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>


