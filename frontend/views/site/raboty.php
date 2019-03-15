<?php

use yii\helpers\Html;

$this->title = 'Примеры работ';
$header = 'Примеры работ';

?>

<!-- Header -->
<?= $this->render('/partials/_header', compact('header')); ?>
<style>
    .instagram iframe {
        width: 100% !important;
        min-height: 235px !important;
    }

    @media screen and (max-width: 480px) {

        iframe .lightwidget__photo {
            width: 100px !important;
            height: 100px !important;
        }
    }
</style>

<!-- Content -->
<section>
    <header class="main">
        <h1><?= Html::encode($this->title) ?></h1>
    </header>
    <hr class="major"/>

    <h3>#подология</h3>
    <div class="instagram">
        <!-- LightWidget WIDGET -->
        <script src="http://cdn.lightwidget.com/widgets/lightwidget.js"></script>
        <iframe src="http://lightwidget.com/widgets/0a44476008e05b9a8ce0129f6588e479.html" scrolling="no"
                allowtransparency="true" class="lightwidget-widget"
                style="width:100%;border:0;overflow:hidden;"></iframe>
    </div>

    <hr class="major"/>

    <!-- InstaWidget -->
    <h3>#маникюр</h3>
    <div class="instagram">
        <!-- LightWidget WIDGET -->
        <script src="http://cdn.lightwidget.com/widgets/lightwidget.js"></script>
        <iframe src="http://lightwidget.com/widgets/444b3311c1e35c1994b7e00ef271977c.html" scrolling="no"
                allowtransparency="true" class="lightwidget-widget"
                style="width:100%;border:0;overflow:hidden;"></iframe>
    </div>

    <hr class="major"/>

    <!-- InstaWidget -->
    <h3>#педикюр</h3>
    <div class="instagram">
        <!-- LightWidget WIDGET -->
        <script src="http://cdn.lightwidget.com/widgets/lightwidget.js"></script>
        <iframe src="http://lightwidget.com/widgets/d02a0dbce0ee50db942df05e79612518.html" scrolling="no"
                allowtransparency="true" class="lightwidget-widget"
                style="width:100%;border:0;overflow:hidden;"></iframe>
    </div>


</section>

