<?php

use rmrevin\yii\fontawesome\FAS;
use yii\helpers\Html;

$admin = Yii::$app->user->can('admin');
$leader = Yii::$app->user->can('leader');

\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="col-md-12">
        <div class="pull-left">
            <?= Html::a(FAS::icon('angle-left', ['class' => 'big', 'data-role' => 'arrow']) . '&nbsp Назад', ['/'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>
<hr>
<table class="c-table">
    <caption class="c-table__title">
        Лист запланированных посещений
        <small>Всего пропущенных посещений: <?= count($model) ?></small>
    </caption>
    <thead class="c-table__head c-table__head--slim">
    <tr class="c-table__row">
        <th class="c-table__cell c-table__cell--head">ID</th>
        <th class="c-table__cell c-table__cell--head">ФИО</th>
        <th class="c-table__cell c-table__cell--head">Город / Точка</th>
        <th class="c-table__cell c-table__cell--head">Проблема</th>
        <th class="c-table__cell c-table__cell--head">Подолог</th>
        <th class="c-table__cell c-table__cell--head">Дата визита</th>
        <th class="c-table__cell c-table__cell--head">Время</th>
        <th class="c-table__cell c-table__cell--head">Отметки</th>
    </tr>
    </thead>
    <tbody>
    <?php // TODO Исправить timeout?>
    <?php if (count($model) != 0) { ?>
        <?php foreach (array_reverse($model) as $item) { ?>
            <tr class="c-table__row openBox">
                <td class="c-table__cell">
                    <p><?= $item->id ?></p>
                </td>
                <td class="c-table__cell">
                    <p><?= $item->card->surname ?></p>
                    <p><?= $item->card->name ?></p>
                    <p><?= $item->card->middle_name ?></p>
                </td>
                <td class="c-table__cell">
                    <p><?= $item->city->name ?></p>
                    <p><?= $item->address_point->address_point ?></p>
                </td>

                <td class="c-table__cell">
                    <?php if ($item->problem_id == 0) { ?>
                        <span class="text-red">Не указана</span>
                    <?php } else { ?>
                        <?= $item->problem->name ?>
                    <?php } ?>
                </td>
                <td class="c-table__cell">
                    <?= $item->podolog->name ?>
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
                    <?php if ($item->visit_time != null) { ?>
                        <span><b><?= Yii::$app->formatter->asTime($item->visit_time) ?></b></span>
                    <?php } else { ?>
                        <span>-</span>
                    <?php } ?>
                </td>
                <td class="c-table__cell">
                    <?= $item->contacted == 1 ? '<span class="glyphicon glyphicon-earphone"></span>' : '' ?>
                    <?= $item->recorded == 1 ? '<span class="glyphicon glyphicon-floppy-saved"></span>' : '' ?>
                    <?= $item->cancel == 1 ? '<span class="glyphicon glyphicon-floppy-remove"></span>' : '' ?>
                    <span class="glyphicon glyphicon-hourglass" title="ожидание посещения"></span>
                </td>
            </tr>
            <tr class="c-table__row infoBlock hide hideBox">
                <td colspan="10" class="c-table__infoBlock">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <?php if ($item->contacted == 0) { ?>
                                    <?= Html::a('Связались с клиентом', ['visit/contacted', 'id' => $item->id], [
                                        'class' => 'btn btn-green linkNewWindow',
                                    ]) ?>
                                <?php } ?>

                                <?php if ($item->recorded == 0 && $item->cancel == 0) { ?>
                                    <?= Html::a('Записали клиента', ['visit/recorded', 'id' => $item->id], [
                                        'class' => 'btn btn-green linkNewWindow',
                                    ]) ?>
                                <?php } ?>

                                <?php if ($item->cancel == 0 && $item->recorded == 0) { ?>
                                    <?= Html::a('Отказ от записи', ['visit/cancel', 'id' => $item->id], [
                                        'class' => 'btn btn-warning linkNewWindow',
                                    ]) ?>
                                <?php } ?>

                                <?= Html::a('<span class="glyphicon glyphicon-new-window"></span> Открыть карту пациента', ['card/view', 'number' => $item->card_number], [
                                    'target' => '_blank',
                                    'class' => 'btn btn-default linkNewWindow',
                                ]) ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($admin || $leader) { ?>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <?php if ($item->contacted == 1) { ?>
                                        <?= Html::a('Снять отметку "Связались с клиентом"', ['visit/contacted-unmark', 'id' => $item->id], [
                                            'class' => 'btn btn-default linkNewWindow',
                                        ]) ?>
                                    <?php } ?>

                                    <?php if ($item->recorded == 1) { ?>
                                        <?= Html::a('Снять отметку "Записали клиента"', ['visit/recorded-unmark', 'id' => $item->id], [
                                            'class' => 'btn btn-default linkNewWindow',
                                        ]) ?>
                                    <?php } ?>

                                    <?php if ($item->cancel == 1) { ?>
                                        <?= Html::a('Снять отметку "Отказ от записи"', ['visit/cancel-unmark', 'id' => $item->id], [
                                            'class' => 'btn btn-default linkNewWindow',
                                        ]) ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr class="c-table__row">
            <td colspan="10" class="c-table__cell--empty">Запланированных посещений нет.</td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<br>
<div class="pull-right">
<!--    <p><span class="glyphicon glyphicon-remove"></span> - пациент не пришел в указанное время</p>-->
    <p><span class="glyphicon glyphicon-hourglass"></span> - ожидание посещения</p>
    <p><span class="glyphicon glyphicon-earphone"></span> - связались с клиентом</p>
    <p><span class="glyphicon glyphicon-floppy-saved"></span> - записали клиента</p>
    <p><span class="glyphicon glyphicon-floppy-remove"></span> - отказ от записи</p>



</div>