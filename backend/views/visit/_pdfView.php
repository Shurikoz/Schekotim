<div class="pdfBody">
    <div class="row">
        <div style="width: 49%;float: left;">
            <img src="images/logoPdf.png" alt=""/>
        </div>
        <div style="width: 49%;float: left;">
            <img src="images/headerPdf.png" alt=""/>
        </div>
    </div>
    <div>
        <div style="width: 49%;float: left;">
            <p>ФИО:</p>
            <span><?= $card->surname ?> <?= $card->name ?> <?= $card->middle_name ?></span>
        </div>
        <div style="width: 49%;float: left;">
        <span>
            <?php if ($visit->visit_time != null && $visit->visit_date != null) { ?>
                <p>Дата посещения:</p>
                <span><?= Yii::$app->formatter->asDate($visit->visit_date) ?> <?= Yii::$app->formatter->asTime($visit->visit_time) ?></span>
            <?php } else { ?>
                <span>-</span>
            <?php } ?>
        </span>
        </div>
    </div>
    <h2 style="color: #0b9341">Рекомендации</h2>
    <div>
        <?= nl2br($visit->recommendation) ?>
        <?php if ($visit->dermatolog != 0 || $visit->immunolog != 0 || $visit->ortoped != 0 || $visit->hirurg != 0) { ?>
            <hr>
            <h3 style="color: #0b9341">Рекомендовано посещение:</h3>
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
            <p>Подолог:</p>
            <span><?= $podolog->name ?></span>
        </div>
    </div>
</div>