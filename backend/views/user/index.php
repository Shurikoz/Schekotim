<?php

/* @var $this yii\web\View */

/* @var $model backend\models\Visit */

use yii\helpers\Html;

\yii\web\YiiAsset::register($this);
?>
<div class="row">
    <div class="col-md-12">
        <h3>Пользователи</h3>
    </div>
</div>
<br>
<table class="c-table">
    <thead class="c-table__head c-table__head--slim">
    <tr class="c-table__row">
        <th class="c-table__cell c-table__cell--head">ID</th>
        <th class="c-table__cell c-table__cell--head">Логин</th>
        <th class="c-table__cell c-table__cell--head">Роль</th>
        <th class="c-table__cell c-table__cell--head">Город / Точка</th>
        <th class="c-table__cell c-table__cell--head">Статус</th>
        <th class="c-table__cell c-table__cell--head">Дата создания</th>
        <th class="c-table__cell c-table__cell--head">Дата изменения</th>
        <th class="c-table__cell c-table__cell--head">Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($model as $item) { ?>
        <tr class="c-table__row">
            <td class="c-table__cell">
                <?= $item->id ?>
            </td>
            <td class="c-table__cell">
                <h4><?= $item->username ?></h4>
                <p><?= $item->email ?></p>
            </td>
            <td class="c-table__cell">
                <?php $role = array_keys(Yii::$app->authManager->getRolesByUser($item->id))?>
                <?= Yii::$app->authManager->getRole($role)->description;?>
            </td>
            <td class="c-table__cell">
                <?= $item->city ?>
                <br>
                <?= $item->address_point ?>
            </td>
            <td class="c-table__cell">
                <b><?= $item->status == 10 ? '<span style="color: #7ba335;">Активный</span>' : '<span style="color: #c55;">Неактивный</span>' ?></b>
            </td>
            <td class="c-table__cell">
                <?= date("d.m.Y", $item->created_at); ?>
            </td>
            <td class="c-table__cell">
                <?= date("d.m.Y <b>H:i</b>", $item->updated_at); ?>
            </td>
            <td class="c-table__cell cardBtn">
                <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['user/view', 'id' => $item->id], ['class' => 'btn linkNewWindow']) ?>
                <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['user/edit', 'id' => $item->id], ['class' => 'btn']) ?>

                <?php if (!Yii::$app->authManager->getAssignment('leader', $item->id)) { ?>
                    <?php if ($item->status == 10) { ?>
                        <?= Html::a('<span class="glyphicon glyphicon-ban-circle" title="Заблокировать"></span>', ['user/block', 'id' => $item->id], [
                            'class' => 'btn',
                            'data-confirm' => 'Заблокировать пользователя?'

                        ]) ?>
                    <?php } else { ?>
                        <?= Html::a('<span class="glyphicon glyphicon-ok-circle" title="Разблокировать"></span>', ['user/unblock', 'id' => $item->id], [
                            'class' => 'btn',
                            'data-confirm' => 'Активировать пользователя?'

                        ]) ?>
                    <?php } ?>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>