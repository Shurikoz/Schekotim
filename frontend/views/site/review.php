<?php

use common\widgets\Alert;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\MaskedInput;

$this->title = 'Отзывы ' . '(' . $totalReviews . ')';
$header = 'Отзывы';
?>
<!-- Header -->
<?= $this->render('/partials/_header', compact('header')); ?>

<!-- Content -->
<section>
    <header class="main">
        <p class="reviewTitleText"><b>Щекотливая тема</b> благодарит вас за посещение. Если вы хотите поделиться отзывом и поставить оценку, перейдите по ссылке в QR-коде. </p>
        <?= Alert::widget() ?>
        <div class="row">
            <div id="zoon" class="col-4 col-12-medium" style="padding: 0;">
                <p class="rew-title">Оставьте отзыв на <a href="https://zoon.ru/msk/medical/tsentr_podologii_schekotlivaya_tema_na_ulitse_samuila_marshaka_vo_vnukovskom_poselenii/" target="_blank">zoon.ru</a></p>
                <a href="https://zoon.ru/msk/medical/tsentr_podologii_schekotlivaya_tema_na_ulitse_samuila_marshaka_vo_vnukovskom_poselenii/" target="_blank"><img class="qrc" src="https://zoon.ru/images/header/zoon_logo.png?v=2" alt=""></a>
                <a href="https://zoon.ru/msk/medical/tsentr_podologii_schekotlivaya_tema_na_ulitse_samuila_marshaka_vo_vnukovskom_poselenii/" target="_blank"><img class="qrc" src="http://qrcoder.ru/code/?https%3A%2F%2Fzoon.ru%2Fmsk%2Fmedical%2Ftsentr_podologii_schekotlivaya_tema_na_ulitse_samuila_marshaka_vo_vnukovskom_poselenii%2F&4&0" alt=""></a>
            </div>
            <div id="yand" class="col-4 col-12-medium" style="padding: 0;">
                <p class="rew-title">Оставьте отзыв на <a href="https://yandex.ru/profile/34151440370">Yandex.ru</a></p>
                <a href="https://yandex.ru/profile/34151440370"><img class="qrc" src="/images/yandex.jpg" alt=""></a>
                <a href="https://yandex.ru/profile/34151440370"><img class="qrc" src="/images/qryan.jpg" alt=""></a>
            </div>
            <div class="col-4 col-12-medium">
                <p class="rew-title">Оставьте отзыв на нашем сайте</p>
                <br>
                <br>
                <img class="qrc" src="/images/logoSchekotim.jpg" alt="">
                <br>
                <?= Html::button('Оставить отзыв на сайте', ['class' => 'button primary box qrc', 'id' => 'showReviewFormButton', 'onClick' => 'showReviewForm()']) ?>
                <?= Html::button('Отмена', ['class' => 'button primary box qrc', 'style' => 'display:none;', 'id' => 'hideReviewFormButton', 'onClick' => 'hideReviewForm()']) ?>
            </div>
        </div>
    </header>
    <br>
    <div class="row">
    <div class="col-12 col-12-medium">
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
                    <?= $form->field($newReview, 'mobile')->widget(MaskedInput::className(), ['mask' => '+7 (999) 999 99 99'])->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <p>Для обратной связи и получения приятных бонусов от наших мастеров, пожалуйста, оставьте свои
                    контактные данные.
                    Мы гарантируем конфиденциальность ваших персональных данных. Для безопасности наших клиентов мы не
                    передаём никакую информацию третьим лицам.</p>
            </div>
            <div class="row">
                <div class="col-12 col-12-xsmall">
                    <?= $form->field($newReview, 'rating')->inline()->radioList([1 => 'Положительно', 2 => 'Нейтрально', 3 => 'Отрицательно'], [
                        'item' => function ($index, $label, $name, $checked, $value) {
                            return '<label class="modal-radio rev_' . $value . '" style="display:inline-block;">
                  <input type="radio" name="' . $name . '" value="' . $value . '">
                  <span>' . ucwords($label) . '</span>
               </label>';
                        }
                    ])
                        ->label(true) ?>

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-12-xsmall">
                    <?= $form->field($newReview, 'text')->textarea(['rows' => 4]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-12-xsmall">

                    <?= $form->field($newReview, 'image')->fileInput(['class' => 'fileImage']) ?>
                    <a href="javascript:void(0);"
                       onclick="$('.fileImage').prop('value', null); return false;">Очистить</a>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-12 col-12-xsmall">
                <?= $form->field($newReview, 'reCaptcha')->widget(
                    \himiklab\yii2\recaptcha\ReCaptcha::className(),
                    ['siteKey' => '6Lf4qbgUAAAAAJN00e-Jk_USGrubqMJxg3qmqbKw']
                ) ?>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'button primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <br>
    <h2><?= Html::encode($this->title) ?></h2>

    <?php foreach ($reviews as $rev) : ?>
        <?php if ($rev->active == 1) : ?>
            <div class="col-12 col-12-medium">
                <div class="box">
                    <div class="reviews">
                        <?= $rev->name; ?>
                        <?php if ($rev->rating == 1) { ?>
                            <img src="/images/pos.png" alt="Положительно" title="Положительно"
                                 class="like">
                        <?php } else if ($rev->rating == 2) { ?>
                            <img src="/images/neu.png" alt="Нейтрально" title="Нейтрально"
                                 class="neutral">
                        <?php } else if ($rev->rating == 3) { ?>
                            <img src="/images/neg.png" alt="Отрицательно" title="Отрицательно"
                                 class="dislike">
                        <?php } ?>
                        <br>
                        <?= $rev->created_at; ?>
                        <br>
                        <br>
                        <blockquote style="display: flex;"><?= $rev->text . '<br>'; ?></blockquote>
                        <?php if ($rev->image != ''){ ?>
                            <a class="image-review-link" href="<?= Url::base() . '/images/reviews/' . $rev->image ?>"><span class="image"><img src="<?= Url::base() . '/images/reviews/thumbnail/' . $rev->image ?>" alt=""/></span></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <?= LinkPager::widget([
        'pagination' => $pages,
        'class' => ''
    ]); ?>
</div>
</section>
