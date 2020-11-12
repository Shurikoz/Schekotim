<?php

use yii\helpers\Html;

$this->title = 'Статьи';

?>


<div class="row">
    <div class="col-md-12">
        <h3>Статьи</h3>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?= Html::a('Создать новую статью', ['create'], ['class' => 'btn btn-green pull-right']) ?>
    </div>
</div>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<hr>
<br>
<div class="row">
    <div class="col-md-12">
        <table class="c-table">
            <thead class="c-table__head c-table__head--slim">
            <tr class="c-table__row">
                <th class="c-table__cell c-table__cell--head" width="10%">Дата</th>
                <th class="c-table__cell c-table__cell--head" width="50%">Заголовок</th>
                <th class="c-table__cell c-table__cell--head" width="20%"></th>
                <th class="c-table__cell c-table__cell--head" width="20%"></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($dataProvider->getModels() as $item) { ?>
                    <tr class="c-table__row">
                        <td class="c-table__cell" width="5%">
                            <?= date('d.m.Y', $item->created_at) ?>
                        </td>
                        <td class="c-table__cell" width="55%">
                            <?= $item->title ?>
                        </td>
                        <td class="c-table__cell" width="20%">
                            <em><?= $item->status == 1 ? '<span style="color: #7ba335;">Опубликована</span>' : '<span style="color: #c55;">Скрыта</span>' ?></em>

                        </td>
                        <td class="c-table__cell cardBtn" width="20%">
                            <?php if ($item->status == 1) { ?>
                                <?= Html::a('<span class="glyphicon glyphicon-ban-circle" title="Снять с публикации"></span>', ['article/unpublic', 'id' => $item->id], [
                                    'class' => 'btn',
                                    'data-confirm' => 'Опубликовать статью?'

                                ]) ?>
                            <?php } else { ?>
                                <?= Html::a('<span class="glyphicon glyphicon-ok" title="Опубликовать"></span>', ['article/public', 'id' => $item->id], [
                                    'class' => 'btn',
                                    'data-confirm' => 'Снять статью с публикации?'

                                ]) ?>
                            <?php } ?>
                            <?= Html::a('<span class="glyphicon glyphicon-pencil" title="Редактировать"></span>', ['article/update', 'id' => $item->id], ['class' => 'btn']) ?>
                            <?= Html::a('<span class="glyphicon glyphicon-trash" title="Удалить"></span>', ['article/delete', 'id' => $item->id], [
                                'class' => 'btn',
                                'data-confirm' => 'Удалить статью #' . $item->id . '?'
                            ]) ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>