<?php
namespace app\models;

use Yii;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ReviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отзывы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <h3>Отзывы</h3>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="review-index">
            <!--                <p>--><? //= Html::a('Добавить отзыв', ['create'], ['class' => 'btn btn-success'])
            ?><!--</p>-->
            <div class="box">
                <table class="c-table">
                    <caption class="c-table__title">
                        Список отзывов
                        <small>Всего отзывов: <?= count($model) ?></small>
                    </caption>
                    <thead class="c-table__head c-table__head--slim">
                    <tr class="c-table__row">
                        <th class="c-table__cell c-table__cell--head">Имя</th>
                        <th class="c-table__cell c-table__cell--head">Email</th>
                        <th class="c-table__cell c-table__cell--head">Телефон</th>
                        <th class="c-table__cell c-table__cell--head">Дата</th>
                        <th class="c-table__cell c-table__cell--head">Оценка</th>
                        <th class="c-table__cell c-table__cell--head">Публикация</th>
                        <th class="c-table__cell c-table__cell--head">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($model as $item) { ?>
                        <tr class="c-table__row openBox supportMessage">
                            <td class="c-table__cell">
                                <p><?= $item->name ?></p>
                            </td>
                            <td class="c-table__cell">
                                <p><?= $item->email ?></p>
                            </td>
                            <td class="c-table__cell">
                                <p><?= $item->mobile ?></p>
                            </td>
                            <td class="c-table__cell">
                                <p><?= $item->created_at ?></p>
                            </td>
                            <td class="c-table__cell">
                                <p>
                                    <?php
                                    if ($item->rating == 1) {
                                        echo '<span style="color: #7ba335;">Полож</span>';
                                    } elseif ($item->rating == 2) {
                                        echo 'Нейтр';
                                    } else {
                                        echo '<span style="color: #c55;">Отриц</span>';
                                    }
                                    ?>
                                </p>
                            </td>
                            <td class="c-table__cell cardBtn">
                                <p><?= $item->active == 0 ? '<span style="color: #c55;">Не опубликован</span>' : '<span style="color: #7ba335;">Опубликован</span>' ?></p>
                            </td>
                            <td class="c-table__cell">
                                <?php
                                $publish = Html::a('<span style="font-size: 18px" class="glyphicon glyphicon-remove">', ['review/hide', 'id' => $item->id], ['title' => 'Снять с публикации']);
                                $unpublish = Html::a('<span style="font-size: 18px" class="glyphicon glyphicon-ok">', ['review/show', 'id' => $item->id], ['title' => 'Опубликовать']);
                                ?>
                                <?= $item->active == 0 ? $publish : $unpublish ?>
                                <?= Html::a('<span style="font-size: 18px" class="glyphicon glyphicon-pencil">', ['review/update', 'id' => $item->id], ['title' => 'Редактировать']); ?>
                                <?= Html::a('<span style="font-size: 18px" class="glyphicon glyphicon-trash">', ['review/delete', 'id' => $item->id], [
                                    'title' => 'Удалить',
                                    'data' => [
                                        'confirm' => 'Вы уверены что хотите удалить этот отзыв?',
                                        'method' => 'post',
                                    ]
                                ]); ?>

                            </td>
                        </tr>
                        <tr class="c-table__row infoBlock hide hideBox">
                            <td class="c-table__infoBlock">
                                <div class="box">
                                    <p><b>Фото:</b></p>
                                    <br>
                                    <p>
                                        <?php if ($item->image) { ?>
                                            <?php $link = Html::img('http://schekotim.ru/images/reviews/thumbnail/' . $item->image, ['alt' => 'Нет изображения', 'style' => 'width:100px;']); ?>
                                            <?= Html::a($link, 'http://schekotim.ru/images/reviews/' . $item->image, ['target' => '_blank']); ?>
                                        <?php } else { ?>
                                            -
                                        <?php } ?>
                                    </p>
                                </div>
                            </td>
                            <td colspan="6" class="c-table__infoBlock">
                                <div class="box">
                                    <p><b>Текст отзыва:</b></p>
                                    <p><?= $item->text ?></p>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>

                <!--                --><? //= GridView::widget([
                //                    'dataProvider' => $dataProvider,
                //                    'filterModel' => $searchModel,
                //                    'options' => ['width' => '100%'],
                //                    'columns' => [
                ////                        ['class' => 'yii\grid\SerialColumn',],
                ////                        'id',
                //                        'name',
                //                        'email:email',
                //                        'mobile',
                //                        'created_at',
                //                        'rating',
                //                        'active',
                //                        ['class' => 'yii\grid\ActionColumn',
                //                            'header' => 'Действия',
                //                            'template' => '{show}{hide}',
                //                            'buttons' => [
                //                                'show' => function ($model, $key, $index) {
                //                                    return Html::a('<span style="font-size: 18px" class="glyphicon glyphicon-ok">', ['review/show', 'id' => $index], ['class' => 'btn btn-primary', 'title' => 'Опубликовать']);
                //                                },
                //                                'hide' => function ($model, $key, $index) {
                //                                    return Html::a('<span style="font-size: 18px" class="glyphicon glyphicon-remove">', ['review/hide', 'id' => $index], ['class' => 'btn btn-primary', 'title' => 'Снять с публикации']);
                //                                },
                //                            ]
                //                        ],
                //                        [
                //                            'label' => 'Картинка',
                //                            'format' => 'raw',
                //                            'value' => function ($data) {
                //                                $link = Html::img('http://schekotim.ru/images/reviews/thumbnail/' . $data->image, ['alt' => 'Нет изображения', 'style' => 'width:50px;']);
                //                                return Html::a($link,'http://schekotim.ru/images/reviews/' . $data->image,['target' => '_blank']);
                //                            },
                //                        ],
                //                        'text:ntext',
                //                        ['class' => 'yii\grid\ActionColumn'],
                //                    ],
                //                ]);
                ?>
            </div>
        </div>
    </div>
</div>