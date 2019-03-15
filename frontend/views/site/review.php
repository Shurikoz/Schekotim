<?php

use common\widgets\Alert;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Отзывы ' . '(' . $totalReviews . ')';
$header = 'Отзывы';
?>
<!-- Header -->
<?= $this->render('/partials/_header', compact('header')); ?>
<style>
    .reviews i {
        font-size: 27px;
        float: right;
        right: 15px;
        position: relative;
    }

    .reviews .like {
        color: green;
    }

    .reviews .neutral {
        color: grey;
    }

    .reviews .dislike {
        color: red
    }
    .alert button{
        box-shadow: none;
        font-size: 24px;
        height: 30px;
        width: 30px;
    }
    .alert button:hover{
        background-color: transparent;
    }

</style>
<!-- Content -->
<section>
    <header class="main">
        <h1><?= Html::encode($this->title) ?></h1>
    </header>
</section>
<div class="row">
    <div class="col-12 col-12-medium">
        <?= Alert::widget() ?>
        <?= Html::button('Оставить отзыв', ['class' => 'button primary box', 'id' => 'showReviewFormButton', 'onClick' => 'showReviewForm()']) ?>
        <?= Html::button('Отмена', ['class' => 'button primary box', 'style' => 'display:none;', 'id' => 'hideReviewFormButton', 'onClick' => 'hideReviewForm()']) ?>
        <div id="reviewForm" style="display: none" class="box">
            <h2>Оставить отзыв</h2>
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-4 col-12-xsmall">
                    <?= $form->field($newReview, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-4 col-12-xsmall">
                    <?= $form->field($newReview, 'email')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-4 col-12-xsmall">
                    <?= $form->field($newReview, 'mobile')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-12-xsmall">
                    <?= $form->field($newReview, 'rating')->inline()->radioList([1 => 'Положительно', 2 => 'Нейтрально', 3 => 'Отрицательно'])
                        ->label(true) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-12-xsmall">
                    <?= $form->field($newReview, 'text')->textarea(['rows' => 4]) ?>
                </div>
            </div>
            <div class="row">
                <?= $form->field($newReview, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="col-1 col-12-xsmall">{image}</div><div class="col-1 col-12-xsmall">{input}</div>',
                    'captchaAction' => '/site/captcha',
                ]) ?>
            </div>
            <div class="row">
                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'button primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <?php foreach ($reviews as $rev) :?>
        <?php if ($rev->active == 1) : ?>
            <div class="col-12 col-12-medium">
                <div class="box">
                    <div class="reviews">
                        <div class="col-12 col-12-small">
                            <div class="row">
                                <div class="col-12 col-12-small">
                                    <span><?= $rev->name; ?></span>
                                    <?php if ($rev->rating == 1) { ?>
                                        <i class="like fa fa-smile-o" aria-hidden="true"></i>
                                    <?php } else if ($rev->rating == 2) { ?>
                                        <i class="neutral fa fa-meh-o" aria-hidden="true"></i>
                                    <?php } else if ($rev->rating == 3) { ?>
                                        <i class="dislike fa fa-frown-o" aria-hidden="true"></i>
                                    <?php } ?>
                                    <br>
                                    <?= $rev->created_at . '<br>'; ?>
                                </div>
                                <br>
                            </div>
                        </div>
                        <div class="col-12 col-12-small">
                            <blockquote><?= $rev->text . '<br>'; ?></blockquote>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <?= LinkPager::widget([
        'pagination' => $pages,
        'class'  => ''
    ]); ?>
</div>

