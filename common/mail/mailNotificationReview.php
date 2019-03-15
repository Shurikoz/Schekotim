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
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<p><b>Email:</b></p>
<p><?= $reviewEmail ?></p>
<br>
<p><b>Телефон:</b></p>
<p><?= $reviewMobile ?></p>
<br>
<p><b>Оценка:</b></p>
<p><?php
    if ($reviewRating == 1) {
        echo 'Положительный';
    } elseif ($reviewRating == 2) {
        echo 'Нейтральный';
    } elseif ($reviewRating == 3) {
        echo 'Отрицательный';
    }
    ?>
</p>
<br>
<p><b>Отзыв:</b></p>
<p><?= $reviewBody ?></p>
<br>
<a href="<?= $linkPublic ?>">Опубликовать</a>
<br>
<a href="<?= $linkEdit ?>">Редактировать</a>
<br>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


