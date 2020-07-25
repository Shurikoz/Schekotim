<div class="pdfBody">
    <div class="row">
        <div style="width: 49%;float: left;">
            <img src="images/logoPdf.png" alt=""/>
        </div>
        <div style="width: 49%;float: left;">
            <img src="images/<?= $profession == 'dermatolog' ? 'headerPdfDerm.png' : 'headerPdf.png'?>" alt=""/>
        </div>
    </div>
    <div>
        <div style="width: 60%;float: left;">
            <p>ФИО: <?= $card->surname ?> <?= $card->name ?> <?= $card->middle_name ?></p>
        </div>
        <div style="width: 38%;float: left;">
        <span>
            <?php if ($visit->visit_date != null) { ?>
                <p>Дата посещения: <?= date('d.m.Y', $visit->visit_date) ?></p>
            <?php } else if ($visit->next_visit_from != null && $visit->next_visit_by != null){ ?>
                <p>Повторное посещение:</p>
                <span>c <?= date('d.m.Y', $visit->next_visit_from) ?></span><br>
                <span>по <?= date('d.m.Y', $visit->next_visit_by) ?></span>
            <?php } ?>
        </span>
        </div>
    </div>
    <!--            --><?php //if ($item->specialist->profession == 'podolog') { ?>
    <?php if ($profession == 'dermatolog') { ?>
        <h4 style="color: #0b9341">Диагноз</h4>
        <?= nl2br($visit->diagnosis) ?>
    <?php } ?>
    <h4 style="color: #0b9341">Рекомендации</h4>
    <div>
        <?= nl2br($visit->recommendation) ?>
        <?php if ($secondVisit != null) { ?>
            <hr>
            В следующий раз подолог ждет Вас с <b><?= date('d.m.Y', $secondVisit->next_visit_from)?></b> по <b><?= date('d.m.Y', $secondVisit->next_visit_by)?></b><br>
            Запись по телефону <b>+7 (495) 181-87-80</b> или через Whatsapp <b>+7 (910) 004-85-58</b>
        <?php } ?>
        <?php if ($visit->dermatolog != 0 || $visit->immunolog != 0 || $visit->ortoped != 0 || $visit->hirurg != 0) { ?>
            <hr>
            <h4 style="color: #0b9341">Рекомендовано посещение:</h4>
            <?= $visit->dermatolog == 1 ? '• Дерматолога<br>' : ''; ?>
            <?= $visit->immunolog == 1 ? '• Иммунолога<br>' : ''; ?>
            <?= $visit->ortoped == 1 ? '• Ортопеда<br>' : ''; ?>
            <?= $visit->hirurg == 1 ? '• Хирурга' : ''; ?>
        <?php } ?>
        <br>
    </div>
    <hr>
    <div>
        <div style="width: 49%;float: left;">
            <p><?= $profession == 'dermatolog' ? 'Дерматолог' : 'Подолог: ' . $specialist->name?></p>
        </div>
    </div>
</div>