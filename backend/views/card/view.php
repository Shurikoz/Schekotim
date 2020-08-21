<?php

use backend\models\Photo;
use backend\models\Specialist;
use backend\models\Visit;
use common\widgets\Alert;
use kartik\datetime\DateTimePicker;
use newerton\fancybox3\FancyBox;
use rmrevin\yii\fontawesome\FAS;
use russ666\widgets\Countdown;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'Карта № ' . $model->number;

\yii\web\YiiAsset::register($this);

$count_visits = (isset($_GET['per-page'])) ? $_GET['per-page'] : 20;

//посчитаем возраст пациента по дате рождения
$born = new DateTime($model->birthday); // дата рождения
$age = $born->diff(new DateTime)->format('%y');

$admin = Yii::$app->user->can('admin');
$administrator = Yii::$app->user->can('administrator');
$smm = Yii::$app->user->can('smm');
$podolog = Yii::$app->user->can('podolog');
$dermatolog = Yii::$app->user->can('dermatolog');
$leader = Yii::$app->user->can('leader');

?>

<?= FancyBox::widget();?>
<div class="card-view">
    <div class="row">
        <div class="col-md-12">
            <div class="pull-left">
                <?= Html::a(FAS::icon('angle-left', ['class' => 'big', 'data-role' => 'arrow']) . '&nbsp Вернуться к списку карт', ['/card'], ['class' => 'btn btn-default']) ?>
            </div>
            <div class="pull-right">
                <span style="display: block;margin-top: 6px;">ID: <?= $model->id ?></span>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-3 col-sm-12">
            <div class="box">
                <!--                <span class="cardHeader"><b>-->
                <? //= Html::encode($this->title) ?><!--</b></span>-->
                <span class="titleCardName"><b><?= Html::encode($this->title) ?></b></span>

            </div>
        </div>
        <div class="col-md-9 col-sm-12">
            <div class="box" style="border: 1px solid #7ba335">
                <p class="titleCardName">
                    <b>ФИО:</b> <?= $model->name ?> <?= $model->middle_name ?> <?= $model->surname ?></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="box">
                <b>Дата рождения: </b><?= Yii::$app->formatter->asDate($model->birthday) ?>
            </div>
        </div>
        <div class="col-md-2 col-sm-6">
            <div class="box">
                <b>Возраст: </b><?= $age ?>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="box">
                <b>Телефон: </b><?= $model->phone ?>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="box">
                <b>Профессия: </b><?= $model->profession == null ? 'Не указана' : $model->profession ?>
            </div>
        </div>
    </div>
    <div class="row">
        <?php if ($model->representative) { ?>
            <div class="col-md-6 col-sm-6">
                <div class="box">
                    <p><b>Представитель клиента:</b> <br> <?= $model->representative ?> </p>
                </div>
            </div>
        <?php } ?>
        <div class="col-md-6 col-sm-6">
            <div class="box">
                <p><b>Ортопедические особенности:</b>
                    <br> <?= $model->orthopedic_features == null ? 'Отсутствуют' : $model->orthopedic_features ?> </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="box">
                <b>Дата создания: </b><?= Yii::$app->formatter->asDate($model->created_at) ?>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="box">
                <?= $model->city->name ?>, <?= $model->address_point->address_point ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="pull-left cardsOnPage">
                <span>Карт на странице:</span>
                <?= Html::a(20, Url::current(['per-page' => 20]), ['class' => ($count_visits == 20) ? 'active' : '']) ?>
                <?= Html::a(40, Url::current(['per-page' => 40]), ['class' => ($count_visits == 40) ? 'active' : '']) ?>
                <?= Html::a(60, Url::current(['per-page' => 60]), ['class' => ($count_visits == 60) ? 'active' : '']) ?>
            </div>
            <div class="pull-right perPage">
                <?= LinkPager::widget([
                    'pagination' => $pages,
                    'maxButtonCount' => 5,
                ]); ?>
            </div>
        </div>
    </div>
    <table class="c-table">
        <?= Alert::widget() ?>
        <caption class="c-table__title">
            <div class="row">
                <div class="col-md-8 col-sm-4">
                    Лист посещений
                    <small>Всего посещений: <?= $dataProvider->getTotalCount() ?></small>
                </div>
                <div class="col-md-4 col-sm-8">
                    <div class="pull-right">
                        <?php if ($admin || $podolog || $dermatolog || $leader) { ?>
                            <?= Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Создать новое посещение', ['visit/create', 'id' => $model->id, 'number' => $model->number], ['class' => 'btn btn-green']) ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </caption>
        <thead class="c-table__head c-table__head--slim">
        <tr class="c-table__row">
            <th class="c-table__cell c-table__cell--head" width="5%">ID</th>
            <th class="c-table__cell c-table__cell--head" width="20%">Город / Адрес</th>
            <th class="c-table__cell c-table__cell--head" width="20%">Проблема</th>
            <th class="c-table__cell c-table__cell--head" width="20%">Специалист</th>
            <th class="c-table__cell c-table__cell--head" width="15%">Дата визита</th>
            <th class="c-table__cell c-table__cell--head" width="20%" style="text-align: center">Отметки</th>
        </tr>
        </thead>
        <tbody>
        <?php // TODO Исправить timeout?>
        <?php if ($dataProvider->getTotalCount() != 0) { ?>
            <?php foreach ($dataProvider->getModels() as $item) { ?>
                <?php
                // проверим указатель пришел ли пациент
                if ($item->has_come == 0) {
                    $hasCome = 'c-table__row--wait';
                    //иконка часы - запланированное посещение
                    $picCome = '<span class="glyphicon glyphicon-hourglass"></span>';
                } elseif ($item->has_come == 1) {
                    $hasCome = 'c-table__row--success';
                    $picCome = '<span class="glyphicon glyphicon-ok"></span>';
                } else {
                    $hasCome = 'c-table__row--danger';
                    $picCome = '<span class="glyphicon glyphicon-remove"></span>';
                }

                // проверим решена проблема или нет
                if ($item->resolve != 0) {
                    $picResolve = '<span class="glyphicon glyphicon-ok-circle"></span>';
                } else {
                    $picResolve = '';
                }

                if ($item->specialist->profession == 'podolog' && (Photo::countPhotoBefore($item->photo) == 0 || Photo::countPhotoAfter($item->photo) == 0)) {
                    $picCamera = '<span class="glyphicon glyphicon-camera"></span>';
                } elseif ($item->specialist->profession == 'dermatolog' && $item->photo == null) {
                    $picCamera = '<span class="glyphicon glyphicon-camera"></span>';
                } else {
                    $picCamera = '';
                }

                ?>
                <tr class="c-table__row <?= $hasCome ?> openBox">
                    <td class="c-table__cell">
                        <span> <?= $item->id ?></span>
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
                        <?= (new Specialist())->profession($item->specialist->profession) ?><br>
                        <?= $item->specialist->name ?>
                    </td>
                    <td class="c-table__cell">
                        <?php if (($item->next_visit_from != null && $item->next_visit_by != null && $item->has_come == 0 && $item->visit_date == null) || ($item->has_come == 2 && $item->next_visit_from != null && $item->next_visit_by != null)) { ?>
                            <p>с <?= date('d.m.Y', $item->next_visit_from) ?></p>
                            <p>до <?= date('d.m.Y', $item->next_visit_by) ?></p>
                        <?php } else if ($item->visit_date != null) { ?>
                            <span> <?= date('d.m.Y <b>H:i</b>', $item->visit_date)?></span>
                            <?php if ($item->next_visit_from != null && $item->next_visit_by != null) { ?>
                            <br>
                            <span class="em-font"><em>с <?= date('d.m.Y', $item->next_visit_from) ?> до <?= date('d.m.Y', $item->next_visit_by) ?></em></span>
                            <?php } ?>
                        <?php } else if ($item->visit_date == null) { ?>
                            <span>-</span>
                        <?php } ?>
                    </td>
                    <td class="c-table__cell" style="text-align: center">
                        <?= $picCome ?>
                        <?= $picResolve ?>
                        <?= $item->recorded == 1 ? '<span class="glyphicon glyphicon-floppy-saved"></span>' : '' ?>
                        <?= $picCamera ?>
                        <?= $item->not_in_time == 1 && ($administrator || $admin || $leader) ? '<span class="glyphicon glyphicon-alert"></span>' : '' ?>
                    </td>
                </tr>
                <tr class="c-table__row infoBlock hide hideBox">
                    <td colspan="10" class="c-table__infoBlock">
                        <?php if ($admin || $leader || $podolog || $dermatolog) { ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="userStatus pull-right">
                                            <?php if (Visit::checkSuccessCopy($item)) { ?>
                                                <div>
                                                    <?= Html::a('Создать копию', ['visit/copy', 'id' => $item->id, 'number' => $model->number], ['class' => 'btn btn-primary']) ?>
                                                </div>
                                            <?php } ?>
                                            <?php if (Visit::checkSuccessChange($item)) { ?>
                                                <div id="blockEdit_<?= $item->id ?>" data-id="<?= $item->id ?>">
                                                    <?= Html::a('Изменить посещение', ['visit/update', 'id' => $item->id, 'number' => $model->number], ['class' => 'btn btn-info']) ?>
                                                    <?php //если указан интервал посещения, то таймер не выводим ?>
                                                    <?php if ($item->next_visit_by <= time() || $item->timestamp >= time()) { ?>
                                                        <?= Countdown::widget([
                                                            'id' => 'timer_' . $item->id,
                                                            'datetime' => date('Y-m-d H:i:s O', time() + ($item->timestamp - time())),
                                                            'format' => '<span style=\"color: red\"\>%-D д. %-H:%-M:%-S</span> ',
                                                            'tagName' => 'span',
                                                            'events' => [
                                                                'finish' => 'function(){
                                                                $(\'#blockEdit_\' + $(this).parent().attr("data-id")).remove();
                                                                }',
                                                            ],
                                                            'options' => [
                                                                'class' => 'timerBox'
                                                            ]
                                                        ]) ?>
                                                    <?php } ?>
                                                </div>
                                            <?php } elseif ($admin || $leader) { ?>
                                                <div>
                                                    <?= Html::a('Изменить посещение', ['visit/update', 'id' => $item->id, 'number' => $model->number], ['class' => 'btn btn-info']) ?>
                                                </div>
                                            <?php } ?>
                                            <?php if (($admin || $leader) && $item->timestamp < time()) { ?>
                                                <div>
                                                    <?= Html::a('+24 часа', ['visit/edit24h', 'id' => $item->id, 'number' => $model->number], ['class' => 'btn btn-warning']) ?>
                                                </div>
                                            <?php } ?>
                                            <?php //кнопка «Проблема решена» доступна админу или тому, кто создал посещение?>
                                            <?php if ($item->specialist->user_id == Yii::$app->user->id || $admin || $leader) { ?>
                                                <?php if ($item->visit_date != null && $item->problem_id != 0 && $item->has_come != 2) { ?>
                                                    <div>
                                                        <?php if ($item->resolve == 0) { ?>
                                                            <?= Html::a('Проблема решена!', ['visit/completed', 'id' => $item->id, 'card' => $model->number, 'resolve' => true], [
                                                                'class' => 'btn btn-green',
                                                                'data' => [
                                                                'confirm' => 'Отметить проблему решенной?',
                                                                'method' => 'post',
                                                            ],
                                                            ]) ?>
                                                        <?php } else { ?>
                                                            <?php if ($admin || $leader) { ?>
                                                                <?= Html::a('Снять отметку «Проблема решена»!', ['visit/completed', 'id' => $item->id, 'card' => $model->number, 'resolve' => false], [
                                                                    'class' => 'btn btn-default'
                                                                ]) ?>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if ($admin || $leader) { ?>
                                                <div>
                                                    <?= Html::a('Удалить', ['visit/delete', 'id' => $item->id, 'card' => $model->number], [
                                                        'class' => 'btn btn-danger',
                                                        'data' => [
                                                            'confirm' => 'Вы уверены, что хотите удалить посещение?',
                                                            'method' => 'post',
                                                        ],
                                                    ]) ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            <?php } ?>
<!--                        --><?php //if ($administrator || $admin || $podolog || $dermatolog || $leader) { ?>
                            <?php if (!$smm) { ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            <?php if ($administrator || $admin || $leader) { ?>
                                                <?php if ($item->has_come == 0) { ?>
                                                    <div class="form-modal">
                                                        <?php
                                                        $form = ActiveForm::begin();
                                                        Modal::begin([
                                                            'header' => 'Изменить специалиста',
                                                            'toggleButton' => [
                                                                'label' => 'Изменить специалиста',
                                                                'class' => 'btn btn-primary userStatus pull-right',
                                                            ],
                                                            'footer' => Html::a('Сохранить', ['visit/setspecialist', 'id' => $item->id, 'number' => $model->number], [
                                                                'class' => 'btn btn-primary',
                                                                'data' => [
                                                                    'method' => 'post',
                                                                ],
                                                            ]),
                                                        ]);
                                                        $specialistList = ArrayHelper::map($specialistModel, 'id', 'name');
                                                        echo $form->field($item, 'specialist_id')
                                                            ->dropDownList($specialistList)
                                                            ->label('Подолог');
                                                        Modal::end();
                                                        ActiveForm::end();
                                                        ?>
                                                    </div>
                                                    <div class="form-modal">
                                                        <?php
                                                        $form = ActiveForm::begin([
                                                            'method' => 'post',
                                                        ]);
                                                        Modal::begin([
                                                            'header' => 'Указать время записи',
                                                            'size' => 'modal-custom',
                                                            'toggleButton' => [
                                                                'label' => 'Назначить время посещения',
                                                                'class' => 'btn btn-green',
                                                            ],
                                                            'footer' => Html::a('Сохранить', ['visit/record', 'id' => $item->id, 'page' => 'view', 'number' => $model->number], [
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
                                                    <?php if ($item->recorded == 1) { ?>
                                                        <?= Html::a('Снять запись', ['visit/record-unmark', 'id' => $item->id, 'page' => 'view', 'number' => $model->number], [
                                                            'class' => 'btn btn-default linkNewWindow',
                                                        ]) ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if ($item->has_come == 1) { ?>
                                                <?= Html::a('Распечатать рекомендации', ['/visit/print-pdf', 'profession' => $item->specialist->profession, 'id' => $item->id, 'card_id' => $model->id], [
                                                    'class' => 'btn btn-warning',
                                                    'target' => '_blank',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => 'Откроет сгенерированный PDF файл в новом окне'
                                                ]); ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            <?php } ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="box">
                                        <div class="col-md-12">
                                            <p><b>Анамнез:</b></p>
                                            <br>
                                            <p><?= $item->anamnes == null ? '<span class="text-red">Не заполнено</span>' : nl2br($item->anamnes) ?></p>
                                        </div>
                                    </div>
                                    <div class="box">
                                        <?php if ($item->specialist->profession == 'podolog') { ?>

                                            <div class="col-md-12">
                                                <p><b>Манипуляции:</b></p>
                                                <br>
                                                <p><?= $item->manipulation == null ? '<span class="text-red">Не заполнено</span>' : nl2br($item->manipulation) ?></p>
                                            </div>
                                        <?php } ?>

                                        <?php if ($item->specialist->profession == 'dermatolog') { ?>
                                            <div class="col-md-12">
                                                <p><b>Диагноз:</b></p>
                                                <br>
                                                <p><?= $item->diagnosis == null ? '<span class="text-red">Не заполнено</span>' : nl2br($item->diagnosis) ?></p>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="box">
                                        <div class="col-md-12">
                                            <p><b>Рекомендации:</b></p>
                                            <br>
                                            <p><?= $item->recommendation == null ? '<span class="text-red">Не заполнено</span>' : nl2br($item->recommendation) ?></p>
                                            <?php if ($item->dermatolog != 0 || $item->immunolog != 0 || $item->ortoped != 0 || $item->hirurg != 0) { ?>
                                                <hr>
                                                <p><b>Рекомендовано посещение:</b></p>
                                                <?=$item->dermatolog == 1 ? '• Дерматолога<br>' : '';?>
                                                <?=$item->immunolog == 1 ? '• Иммунолога<br>' : '';?>
                                                <?=$item->ortoped == 1 ? '• Ортопеда<br>' : '';?>
                                                <?=$item->hirurg == 1 ? '• Хирурга' : '';?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="box">
                                        <div class="col-md-12">
                                            <p><b>Комментарий:</b></p>
                                            <br>
                                            <p><?= $item->description == null ? '<span>Не заполнено</span>' : nl2br($item->description) ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <?php if ($item->specialist->profession == 'podolog') { ?>
                                        <div class="box">
                                            <div class="col-md-12">
                                                <p class="titleMin"><b>Фото до обработки:</b></p>
                                                <?php if (Photo::countPhotoBefore($item->photo) != 0) { ?>
                                                    <?php foreach ($item->photo as $photo) { ?>
                                                        <?php if ($photo->made == 'before') { ?>
                                                            <div style="float: left; margin: 0 0 20px 20px;">
                                                                <?= Html::a(Html::img($photo->thumbnail), $photo->url, ['data-fancybox' => true]); ?>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <p><span class="text-red">Не заполнено</span></p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="box">
                                            <div class="col-md-12">
                                                <p class="titleMin"><b>Фото после обработки:</b></p>
                                                <?php if (Photo::countPhotoAfter($item->photo) != 0) { ?>
                                                    <?php foreach ($item->photo as $photo) { ?>
                                                        <?php if ($photo->made == 'after') { ?>
                                                            <div style="float: left; margin: 0 0 20px 20px;">
                                                                <?= Html::a(Html::img($photo->thumbnail), $photo->url, ['data-fancybox' => true]); ?>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <p><span class="text-red">Не заполнено</span></p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if ($item->specialist->profession == 'dermatolog') { ?>
                                        <div class="box">
                                            <div class="col-md-12">
                                                <p class="titleMin"><b>Фото проблемы:</b></p>
                                                <br>
                                                <?php if (Photo::countPhotoDermatolog($item->photo) != 0) { ?>
                                                    <?php foreach ($item->photo as $photo) { ?>
                                                        <?php if ($photo->made == 'dermatolog') { ?>
                                                            <div style="float: left; margin: 0 0 20px 20px;">
                                                                <?= Html::a(Html::img($photo->thumbnail), $photo->url, ['data-fancybox' => true]); ?>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <p><span class="text-red">Не заполнено</span></p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr class="c-table__row">
                <td colspan="10" class="c-table__cell--empty">Посещений не зафиксировано</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <div class="pull-right">
        <?= LinkPager::widget([
            'pagination' => $pages,
            'maxButtonCount' => 5,
        ]); ?>
    </div>
    <br>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <p><span class="glyphicon glyphicon-hourglass"></span> - ожидание посещения</p>
            <p><span class="glyphicon glyphicon-ok-circle"></span> - проблема решена</p>
            <p><span class="glyphicon glyphicon-floppy-saved"></span> - клиент записан на прием</p>
            <p><span class="glyphicon glyphicon-ok"></span> - клиент пришел</p>
            <p><span class="glyphicon glyphicon-remove"></span> - клиент не пришел в указанное время</p>
            <p><span class="glyphicon glyphicon-camera"></span> - не добавлены фотографии</p>
            <?= $administrator || $admin || $leader ? '<p><span class="glyphicon glyphicon-alert"></span> - клиент не уложился в сроки</p>' : '' ?>
        </div>
    </div>
</div>
