<?php

use rmrevin\yii\fontawesome\FAS;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Card */

$this->title = 'Создание новой карты пациента';
$this->params['breadcrumbs'][] = ['label' => 'Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//создадим массив для выпадающего списка подологов

?>
<div class="card-create">
    <?= Html::button(FAS::icon('angle-left', ['class' => 'big', 'data-role' => 'arrow']) . '&nbsp Отмена', [
        'class' => 'btn btn-default',
        'onclick' => 'history.back();'
    ]) ?>
    <br>
    <br>
    <?= $this->render('_form', [
        'cardModel' => $cardModel,
        'visitModel' => $visitModel,
        'podologModel' => $podologModel,
    ]) ?>

</div>
