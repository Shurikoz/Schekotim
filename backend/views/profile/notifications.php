<?php
use yii\widgets\Pjax;
use yii\helpers\Html;

?>
    <br><br><br>
    <p><?=date('H:i:s')?></p>
<?php Pjax::begin(); ?>

    <div class="form-group">
        <?= Html::a("Получить", ['profile/notif'], ['class' => 'btn btn-primary']) ?>
    </div>
    <br>
<?=$result?>

<?php Pjax::end(); ?>