<?php
$administrator = Yii::$app->user->can('administrator');
$admin = Yii::$app->user->can('admin');
$smm = Yii::$app->user->can('smm');
$podolog = Yii::$app->user->can('podolog');
$leader = Yii::$app->user->can('leader');
?>
<div class="row">
    <div class="col-md-12">
        <h3>Как это работает?</h3>
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <p><span class="glyphicon glyphicon-hourglass"></span><b> - Отметка ожидание посещения</b></p>
        <p class="tutorialDesc">Информирует о том, что клиент должен придти на прием в указанный интервал
            времени или в обозначенное время.</p>
        <br>
        <p><span class="glyphicon glyphicon-ok-circle"></span><b> - Отметка "проблема решена"</b></p>
        <p class="tutorialDesc">Информирует, что проблема помечена решенной, редактирование посещения становится
            невозможным. Снятие отметки доступно Управляющему центра.</p>
        <br>
        <p><span class="glyphicon glyphicon-floppy-saved"></span><b> - Отметка "клиент записан на прием"</b></p>
        <p class="tutorialDesc">Информирует о том, что клиент записан на прием в определенное время. Время записи
            отображается в столбце "Дата визита" списка посещений в карте клиента.</p>
        <br>
        <p><span class="glyphicon glyphicon-floppy-remove"></span><b> - Отметка "отказ от записи"</b></p>
        <p class="tutorialDesc">Информирует о том, что с клиентом связались, но он отказался от дальнейшей записи на прием.</p>
        <br>
        <p><span class="glyphicon glyphicon-earphone"></span><b> - Отметка "связались с клиентом"</b></p>
        <p class="tutorialDesc">Информирует о том, что с клиентом связались, но он не определился с временем записи. Указывается дата и время повторного звонка клиенту.</p>
        <br>
        <p><span class="glyphicon glyphicon-ok"></span><b> - Отметка "клиент пришел"</b></p>
        <p class="tutorialDesc">Информирует о фактическом посещении клиентом центра. Отметка устанавливается при
            создании/редактировании посещения.</p>
        <br>
        <p><span class="glyphicon glyphicon-remove"></span><b> - Отметка "клиент не пришел в указанное время"</b>
        </p>
        <p class="tutorialDesc">Информирует о том, что клиент не пришел (не записался) на прием в обозначенный
            интервал времени. Посещение отмечается как "закрытое", <b>все манипуляции над ним запрещаются</b>. Если
            специалист не отметил в посещении "Пациент пришел", то по завершению дня, на который пациент был
            записан, посещение отмечается "Пропущенным".</p>
        <p class="tutorialDesc"><b>Посещение отмечается "Пропущенным" по следующим критериям:</b></p>
        <p class="tutorialDesc">1. Посещение запланированно, указан опреленный интервал дат. Если пациент не пришел до конечной даты интервала включительно, ставится отметка "Посещение пропущено".</p>
        <p class="tutorialDesc">2. Если в запланированном посещении клиент записан на определенную дату и время, но при реадактировании посещения специалистом не установлена галочка "Пациент пришел", посещение помечается как пропущенное.</p>
        <br>
        <p><span class="glyphicon glyphicon-camera"></span><b> - Отметка "не добавлены фотографии"</b></p>
        <p class="tutorialDesc">Информирует о необходимости внести в базу фотографии работ до и после прцедур.</p>
        <br>
        <p><span class="glyphicon glyphicon-alert"></span><b> - Отметка "клиент не уложился в сроки"</b></p>
        <p class="tutorialDesc">Информирует о том, что клиент не посетил центр в рекомендуемый интервал времени.</p>
    </div>
</div>
<hr>
<?php if ($podolog) { ?>
    <?= $this->render('tutorial/podolog') ?>
<?php } ?>

<?php if ($smm) { ?>
    <?= $this->render('tutorial/smm') ?>
<?php } ?>

<?php if ($administrator) { ?>
    <?= $this->render('tutorial/administrator') ?>
<?php } ?>

<?php if ($leader || $admin) { ?>
    <h4>Подолог</h4>
    <?= $this->render('tutorial/podolog') ?>
    <hr>
    <h4>Администратор центра</h4>
    <?= $this->render('tutorial/administrator') ?>
    <hr>
    <h4>SMM-специалист</h4>
    <?= $this->render('tutorial/smm') ?>
<?php } ?>
