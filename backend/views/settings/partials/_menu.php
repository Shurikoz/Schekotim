<?php

use yii\widgets\Menu;

?>

<?= Menu::widget([
    'options' => ['class' => 'nav nav-pills'],
    'items' => [
        ['label' => 'Основные', 'url' => ['settings/index']],
        ['label' => 'Адреса', 'url' => ['settings/address']],

    ],
    'activeCssClass' => 'active-green',
]);
?>

<hr>