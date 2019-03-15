<?php

use yii\helpers\Html;

$this->title = 'Подология';
$header = 'Подология';
?>
<!-- Header -->
<?= $this->render('/partials/_header', compact('header')); ?>


<!-- Content -->
<section>
    <header class="main">
        <h1><?= Html::encode($this->title) ?></h1>
    </header>
</section>
<!-- Content -->
<div class="row">
    <h2 id="content">Кто такие подологи?</h2>
    <div>
        <span class="image left"><img src="images/podolog.jpg" alt=""/></span>
        <h4>Чем же, все-таки занимается подолог?</h4>
        <p>
            Если совсем просто, то - <b>подолог</b> это специалист, который занимается проблемами стопы и ногтей.
        </p>
        <p>
            Деформация ногтей стопы, изменение ногтевой пластины, изменения стопы,мозоли и дефекты - все это
            вопросы, которыми занимается подолог. Как правило, мы сами того не замечая, вредим своим ногам красивой,
            но не безопасной обувью, иногда это некачественный педикюр или материалы для него, нарушаем гигиену или
            же напротив, злоупотребляем косметическими средствами.
        </p>
    </div>
</div>
<hr/>
<div class="row">
    <dl>
        <dt>В нашей студии Вам помогут решить множество проблем:</dt>
        <dd>
            <span>- Мозоли</span>
            <br>
            <span>- Трещины</span>
            <br>
            <span>- Вросшие ногти</span>
            <br>
            <span>- Деформация ногтей</span>
            <br>
            <span>- Грибковые заболевания</span>
            <br>
            <span>- Чрезмерные шелушения стопы</span>
            <br>
            <span>- Стержневые мозоли</span>
            <br>
            <span>- Натоптыши</span>
            <br>
            <span>- Онихолизис (отхождение ногтя от ногтевого ложа)</span>
            <br>
        </dd>
    </dl>
</div>
<!--<hr class="major"/>-->
<!--<h2>Стоимость услуг</h2>-->
<!--<div class="table-wrapper">-->
<!--    <table class="alt">-->
<!--        <tbody>-->
<!--        <tr>-->
<!--            <td>Item1</td>-->
<!--            <td>Ante turpis integer aliquet porttitor.</td>-->
<!--            <td>29.99 <sup>руб.</sup></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>Item2</td>-->
<!--            <td>Vis ac commodo adipiscing arcu aliquet.</td>-->
<!--            <td>19.99 <sup>руб.</sup></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>Item3</td>-->
<!--            <td> Morbi faucibus arcu accumsan lorem.</td>-->
<!--            <td>29.99 <sup>руб.</sup></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>Item4</td>-->
<!--            <td>Vitae integer tempus condimentum.</td>-->
<!--            <td>19.99 <sup>руб.</sup></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>Item5</td>-->
<!--            <td>Ante turpis integer aliquet porttitor.</td>-->
<!--            <td>29.99 <sup>руб.</sup></td>-->
<!--        </tr>-->
<!--        </tbody>-->
<!--    </table>-->
<!--</div>-->