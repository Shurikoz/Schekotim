<?php

use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width"/>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body style="width: 100% !important;height: 100%;background: #efefef;-webkit-font-smoothing: antialiased;-webkit-text-size-adjust: none;">
    <?php $this->beginBody() ?>
    <table style="width: 100% !important;height: 100%;background: #efefef;-webkit-font-smoothing: antialiased;-webkit-text-size-adjust: none;">
        <tr>
            <td style="display: block !important;clear: both !important;margin: 0 auto !important;max-width: 580px !important;">
                <table style="width: 100% !important;border-collapse: collapse;">
                    <tr>
                        <td align="center" style="padding: 80px 40px;background: #71bc37;color: white;">
                            <img style="max-width: 100%;margin: 0 auto;display: block;"
                                 src="http://schekotim.ru/images/logo_white.png" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td style="background: white;padding: 30px 35px;">
                            <h2 style="font-size: 28px;margin-bottom: 20px;line-height: 1.25;">Размещен новый
                                отзыв!</h2>
                            <hr>
                            <p style="font-size: 16px;font-weight: normal;margin-bottom: 20px;">
                                <b>Имя:</b>
                            </p>
                            <p style="font-size: 16px;font-weight: normal;margin-bottom: 20px;">
                                <em><?= $reviewName ?></em>
                            </p>
                            <p style="font-size: 16px;font-weight: normal;margin-bottom: 20px;">
                                <b>Email:</b>
                            </p>
                            <p style="font-size: 16px;font-weight: normal;margin-bottom: 20px;">
                                <em><?= $reviewEmail ?></em>
                            </p>
                            <p style="font-size: 16px;font-weight: normal;margin-bottom: 20px;">
                                <b>Телефон:</b>
                            </p>
                            <p style="font-size: 16px;font-weight: normal;margin-bottom: 20px;">
                                <em><?= $reviewMobile ?></em>
                            </p>
                            <p style="font-size: 16px;font-weight: normal;margin-bottom: 20px;">
                                <b>Оценка:</b>
                            </p>
                            <p style="font-size: 16px;font-weight: normal;margin-bottom: 20px;">
                                <em><?php
                                    if ($reviewRating == 1) {
                                        echo '<span style="color: green">Положительный</span>';
                                    } elseif ($reviewRating == 2) {
                                        echo '<span style="color: grey">Нейтральный</span>';
                                    } elseif ($reviewRating == 3) {
                                        echo '<span style="color: red">Отрицательный</span>';
                                    }
                                    ?></em>
                            </p>
                            <p style="font-size: 16px;font-weight: normal;margin-bottom: 20px;">
                                <b>Отзыв:</b>
                            </p>
                            <p style="font-size: 16px;font-weight: normal;margin-bottom: 20px;">
                                <em><?= $reviewBody ?></em>
                            </p>
                            <?php if ($image) { ?>
                                <p style="font-size: 16px;font-weight: normal;margin-bottom: 20px;">
                                    <b>Прикрепленное к отзыву фото во вложении</b>
                                </p>
                            <?php } ?>


                            <table style="width: 100% !important;border-collapse: collapse;">
                                <tr>
                                    <td align="center">
                                        <p style="font-size: 16px;font-weight: normal;margin-bottom: 20px;">
                                            <a href="<?= $linkPublic ?>"
                                               style="text-decoration: none;display: inline-block;color: white;background: #71bc37;border: solid #71bc37;border-width: 10px 20px 8px;font-weight: bold;border-radius: 4px;">Опубликовать</a>
                                        </p>
                                        <p style="font-size: 16px;font-weight: normal;margin-bottom: 20px;">
                                            <a href="<?= $linkEdit ?>"
                                               style="text-decoration: none;display: inline-block;color: white;background: #71bc37;border: solid #71bc37;border-width: 10px 20px 8px;font-weight: bold;border-radius: 4px;">Редактировать</a>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <hr>
                            <p style="font-size: 16px;font-weight: normal;margin-bottom: 20px;margin-top: 50px;"><em>–
                                    Студия «Щекотливая тема»</em></p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
        <tr>
            <td style="display: block !important;clear: both !important;margin: 0 auto !important;max-width: 580px !important;">
                <table style="width: 100% !important;border-collapse: collapse;">
                    <tr>
                        <td style="background: none;padding: 30px 35px;" align="center">
                            <p style="margin-bottom: 0;color: #888;text-align: center;font-size: 12px !important;margin-top: 0;">
                                Центр <a style="color: #888;text-decoration: none;font-weight: bold;"
                                          href="http://schekotim.ru/">«Щекотливая тема»</a>, г. Москва, ул. Самуила Маршака 20, (вход со двора)</p>
                            <p style="margin-bottom: 0;color: #888;text-align: center;font-size: 12px !important;margin-top: 0;">
                                <a style="color: #888;text-decoration: none;font-weight: bold;" href="mailto:">info@schekotim.ru</a>
                            </p>
                            <p style="margin-bottom: 0;color: #888;text-align: center;font-size: 12px !important;margin-top: 0;">
                                <a style="color: #888;text-decoration: none;font-weight: bold;" href="tel:+79100048558">+7(910)004-85-58</a>
                            </p>
                            <p style="margin-bottom: 0;color: #888;text-align: center;font-size: 12px !important;margin-top: 0;">
                                <a style="color: #888;text-decoration: none;font-weight: bold;"
                                   href="https://www.instagram.com/schekotim/" target="_blank"
                                   class="icon fab fa-instagram">Instagram</a></p>
                            <p style="margin-bottom: 0;color: #888;text-align: center;font-size: 12px !important;margin-top: 0;">
                                <a style="color: #888;text-decoration: none;font-weight: bold;"
                                   href="https://api.whatsapp.com/send?phone=+79100048558&text=Здравствуйте! Хочу записаться к вам на прием!">&nbsp;WhatsApp</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>