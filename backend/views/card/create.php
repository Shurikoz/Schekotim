<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use rmrevin\yii\fontawesome\FAS;

/* @var $this yii\web\View */
/* @var $model backend\models\Card */

$this->title = 'Создание новой карты пациента';
$this->params['breadcrumbs'][] = ['label' => 'Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//создадим массив для выпадающего списка подологов
$podologList = ArrayHelper::map($podologModel, 'id', 'name');

?>
<div class="card-create">
    <?= Html::button(FAS::icon('angle-left', ['class' => 'big', 'data-role' => 'arrow']) . '&nbsp Отмена', [
        'class' => 'btn btn-default',
        'onclick' => 'history.back();'
    ]) ?>
    <br>
    <br>
    <div class="row">
        <div class="col-md-12">
            <p class="titleNormal"><?= Html::encode($this->title) ?></p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="box">
                <div class="col-md-2"><b>Город:</b></div>
                <div class="col-md-10"><?= $location->city->name ?></div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="box">
                <div class="col-md-2"><b>Точка:</b></div>
                <div class="col-md-10"><?= $location->address_point ?></div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <p class="titleMin">Общие данные <?= FAS::i('question')?></p>
        </div>
    </div>
    <div class="card-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($cardModel, 'user_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false); ?>
        <?= $form->field($cardModel, 'city')->hiddenInput(['value' => $location->city->name])->label(false); ?>
        <?= $form->field($cardModel, 'address_point')->hiddenInput(['value' => $location->address_point])->label(false); ?>

        <div class="row">
            <div class="col-md-4">
                <div class="box">
                    <?= $form->field($cardModel, 'surname')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box">
                    <?= $form->field($cardModel, 'name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box">
                    <?= $form->field($cardModel, 'middle_name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box">
                    <?= $form->field($cardModel, 'birthday')->textInput(['type' => 'date']) ?>
                </div>
            </div>
        </div>
        <hr>
        <div class="borderDotted">
            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="titleMin">Выбор специалиста <?= FAS::i('question')?></p>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <?= $form->field($visitModel, 'podolog')
                                    ->dropDownList($podologList)
                                    ->label('Подолог') ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="titleMin">Дата и время посещения <?= FAS::i('question')?></p>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            Посещение сейчас или позже
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="box">
                                <?= $form->field($visitModel, 'next_visit_from')->textInput(['type' => 'date', 'class' => 'c-input']) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="box">
                                <?= $form->field($visitModel, 'next_visit_by')->textInput(['type' => 'date', 'class' => 'c-input']) ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box">
                                <?= $form->field($visitModel, 'visit_time')->textInput(['type' => 'time', 'class' => 'c-input']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <p class="titleMin">Данные о проблеме <?= FAS::i('question')?></p>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="box">
                        <?= $form->field($visitModel, 'reason')->textarea(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box">
                        <?= $form->field($visitModel, 'description')->textarea(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', [
                        'class' => 'btn btn-lg btn-green pull-right',
                        'data' => [
                            'confirm' => 'Вы уверены что все заполнено верно? Дальнейшие изменения возможны только администратором!',
                            'method' => 'post',
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
