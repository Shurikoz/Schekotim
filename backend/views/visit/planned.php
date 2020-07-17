<?php

use common\widgets\Alert;
use kartik\datetime\DateTimePicker;
use rmrevin\yii\fontawesome\FAS;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$admin = Yii::$app->user->can('admin');
$leader = Yii::$app->user->can('leader');

$count_items = (isset($_GET['per-page'])) ? $_GET['per-page'] : 20;

$this->title = 'Лист запланированных посещений';

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
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_search', [
            'model' => $searchModel,
        ]) ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?= Alert::widget() ?>
        <div class="pull-left cardsOnPage">
            <span>Карт на странице:</span>
            <?= Html::a(20, Url::current(['per-page' => 20]), ['class' => ($count_items == 20) ? 'active' : '']) ?>
            <?= Html::a(40, Url::current(['per-page' => 40]), ['class' => ($count_items == 40) ? 'active' : '']) ?>
            <?= Html::a(60, Url::current(['per-page' => 60]), ['class' => ($count_items == 60) ? 'active' : '']) ?>
        </div>
        <div class="pull-right perPage">
            <?= LinkPager::widget([
                'pagination' => $pages,
                'maxButtonCount' => 5,
                'firstPageLabel' => true,
                'lastPageLabel' => true,
            ]); ?>
        </div>
    </div>
</div>
<table class="c-table">
    <caption class="c-table__title">
        Лист запланированных посещений
        <small>Всего запланированных посещений: <?= $dataProvider->getTotalCount() ?></small>
    </caption>
    <thead class="c-table__head c-table__head--slim">
    <tr class="c-table__row">
        <th class="c-table__cell c-table__cell--head">Карта</th>
        <th class="c-table__cell c-table__cell--head">ФИО</th>
        <th class="c-table__cell c-table__cell--head">Город / Точка</th>
        <th class="c-table__cell c-table__cell--head">Проблема</th>
        <th class="c-table__cell c-table__cell--head">Подолог</th>
        <th class="c-table__cell c-table__cell--head">Дата визита</th>
        <th class="c-table__cell c-table__cell--head text-center">Отметки</th>
    </tr>
    </thead>
    <tbody>
    <?php // TODO Исправить timeout?>
    <?php if ($dataProvider->getTotalCount() != 0) { ?>
        <?php foreach ($dataProvider->getModels() as $item) { ?>
            <tr class="c-table__row openBox">
                <td class="c-table__cell">
                    <p><?= $item->card_number ?></p>
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
                    <?php if ($item->next_visit_from != null && $item->next_visit_by != null && $item->has_come == 0 && $item->recorded == 0) { ?>
                        <p>с <?= date('d.m.Y', $item->next_visit_from) ?></p>
                        <p>до <?= date('d.m.Y', $item->next_visit_by) ?></p>
                    <?php } else if ($item->recorded == 1) { ?>
                        <span> <?= date('d.m.Y <b>H:i</b>', $item->visit_date) ?></span>
                    <?php } else if ($item->has_come == 2) { ?>
                        <span>-</span>
                    <?php } ?>
                </td>
                <td class="c-table__cell text-center">
                    <?= $item->recorded == 1 ? '<span class="glyphicon glyphicon-floppy-saved"></span>' : '' ?>
                    <?= $item->cancel == 1 ? '<span class="glyphicon glyphicon-floppy-remove"></span>' : '' ?>
                    <span class="glyphicon glyphicon-hourglass" title="ожидание посещения"></span>
                    <?= $item->not_in_time == 1 && ($administrator || $admin || $leader || $administrator) ? '<span class="glyphicon glyphicon-alert"></span>' : '' ?>
                    <br>
                    <?= $item->contacted != 0 && $item->recorded == 0 ? '<span class="glyphicon glyphicon-earphone"></span><span class="planned-call-time">' . date('d.m.Y H:i', $item->contacted) . '</span>' : '' ?>
                </td>
            </tr>
            <tr class="c-table__row infoBlock hide hideBox">
                <td colspan="10" class="c-table__infoBlock">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <?php if ($item->cancel == 0) { ?>
                                    <div class="form-modal">
                                        <?php $form = ActiveForm::begin([
                                            'method' => 'post',
                                        ]);
                                        Modal::begin([
                                            'header' => 'Указать время записи',
                                            'size' => 'modal-custom',
                                            'toggleButton' => [
                                                'label' => 'Связались, назначить время',
                                                'class' => 'btn btn-green',
                                            ],
                                            'footer' => Html::a('Сохранить', ['visit/record', 'id' => $item->id], [
                                                'class' => 'btn btn-green',
                                                'data' => [
                                                    'method' => 'post',
                                                ],
                                            ]),
                                        ]);
                                        echo DateTimePicker::widget([
                                            'model' => $item,
                                            'attribute' => 'visit_date',
                                            'type' => DateTimePicker::TYPE_INLINE,
                                            'options' => [
                                                'id' => 'visit_date_' . $item->id,
                                                'value' => $item->visit_date < 1 ? 'ДАТА И ВРЕМЯ ПОСЕЩЕНИЯ' : date('d.m.Y H:i', $item->visit_date)
                                            ],
                                            'pluginOptions' => [
                                                'startDate' => date('d.m.Y H:i'),
                                                'autoclose' => true,
                                                'todayHighlight' => true,
                                                'format' => 'dd.mm.yyyy H:i',
                                                'minuteStep' => 10,
                                                'hoursDisabled' => '0,1,2,3,4,5,6,7,8,9,21,22,23',
                                                'minTime' => 0
                                            ],
                                        ]);
                                        Modal::end();
                                        ActiveForm::end();
                                        ?>
                                    </div>
                                <?php } ?>

                                <?php if ($item->recorded == 0 && $item->cancel == 0 && $item->contacted == 0) { ?>
                                    <div class="form-modal">
                                        <?php $form = ActiveForm::begin([
                                            'method' => 'post',
                                        ]);
                                        Modal::begin([
                                            'header' => 'Указать время повторного звонка',
                                            'size' => 'modal-custom',
                                            'toggleButton' => [
                                                'label' => 'Связались, перезвонить',
                                                'class' => 'btn btn-info',
                                            ],
                                            'footer' => Html::a('Сохранить', ['visit/contacted', 'id' => $item->id], [
                                                'class' => 'btn btn-green',
                                                'data' => [
                                                    'method' => 'post',
                                                ],
                                            ]),
                                        ]);

                                        echo DateTimePicker::widget([
                                            'model' => $item,
                                            'attribute' => 'contacted',
                                            'type' => DateTimePicker::TYPE_INLINE,
                                            'options' => [
                                                'id' => 'contacted_' . $item->id,
                                                'value' => $item->contacted == 0 ? 'ДАТА И ВРЕМЯ ЗВОНКА' : date('d.m.Y H:i', $item->visit_date)
                                            ],
                                            'pluginOptions' => [
                                                'startDate' => date('d.m.Y H:i'),
                                                'autoclose' => true,
                                                'todayHighlight' => true,
                                                'format' => 'dd.mm.yyyy H:i',
                                                'minuteStep' => 10,
                                                'hoursDisabled' => '0,1,2,3,4,5,6,7,8,9,21,22,23',
                                                'minTime' => 0
                                            ],
                                        ]);
                                        echo '<br>';

                                        echo $form->field($item, 'comment')->textarea();

                                        Modal::end();
                                        ActiveForm::end();
                                        ?>
                                    </div>
                                <?php } ?>

                                <?php if ($item->contacted != 0 && $item->recorded == 0 && $item->cancel == 0) { ?>
                                    <?= Html::a('Снять отметку "Связались с клиентом"', ['visit/contact-unmark', 'id' => $item->id], [
                                        'class' => 'btn btn-default linkNewWindow',
                                    ]) ?>
                                <?php } ?>

                                <?php if ($item->cancel == 0 && $item->recorded == 0) { ?>
                                    <?= Html::a('Отказ от записи', ['visit/cancel', 'id' => $item->id], [
                                        'class' => 'btn btn-warning ',
                                    ]) ?>
                                <?php } elseif ($item->cancel == 1) { ?>
                                    <?= Html::a('Снять отметку "Отказ от записи"', ['visit/cancel-unmark', 'id' => $item->id], [
                                        'class' => 'btn btn-default linkNewWindow',
                                    ]) ?>
                                <?php } ?>
                                <?php if ($item->recorded == 1) { ?>
                                    <?= Html::a('Снять запись', ['visit/record-unmark', 'id' => $item->id], [
                                        'class' => 'btn btn-default linkNewWindow',
                                    ]) ?>
                                <?php } ?>
                                <?= Html::a('<span class="glyphicon glyphicon-new-window"></span> Открыть карту пациента', ['card/view', 'number' => $item->card_number], [
                                    'target' => '_blank',
                                    'class' => 'btn btn-default linkNewWindow',
                                ]) ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($item->comment) { ?>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <p><b>Коментарий:</b></p>
                                <p><?= $item->comment?></p>
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
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?= LinkPager::widget([
                'pagination' => $pages,
                'maxButtonCount' => 5,
                'firstPageLabel' => true,
                'lastPageLabel' => true,
            ]); ?>
        </div>
    </div>
</div>

<br>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <!--    <p><span class="glyphicon glyphicon-remove"></span> - пациент не пришел в указанное время</p>-->
            <p><span class="glyphicon glyphicon-hourglass"></span> - ожидание посещения</p>
            <p><span class="glyphicon glyphicon-earphone"></span> - связались с клиентом</p>
            <p><span class="glyphicon glyphicon-floppy-saved"></span> - записали клиента</p>
            <p><span class="glyphicon glyphicon-floppy-remove"></span> - отказ от записи</p>
            <p><span class="glyphicon glyphicon-alert"></span> - клиент не уложился в сроки</p>

        </div>
    </div>
</div>
