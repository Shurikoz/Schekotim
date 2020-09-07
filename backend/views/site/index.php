<?php

/* @var $this yii\web\View */

/*
 * 4 типа пользователей:
 *  admin
 *	user
 *	smm
 *	administrator
 */

use yii\helpers\Html;

$this->title = 'Учет пациентов';

$admin = Yii::$app->user->can('admin');
$administrator = Yii::$app->user->can('administrator');
$smm = Yii::$app->user->can('smm');
$podolog = Yii::$app->user->can('podolog');
$dermatolog = Yii::$app->user->can('dermatolog');
$leader = Yii::$app->user->can('leader');

?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <p>По вопросам работы программы, ошибкам и прочим багам обращаться в <b><a
                            href="https://api.whatsapp.com/send?phone=+79262643854">WhatsApp</a></b> или по телефону <b><a
                            href="tel:+79262643854">+7(926)264-38-54</a></b> Александр</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <p>По вопросам редактирования введенных данных, удалению/редактированию посещения или карты обращаться к
                руководству Центра.</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <p>Если у вас есть предложения по улучшению функционала программы, замечания к ее работе, идеи по
                реализации или расширению каких-либо функций, пожалуйста, обращайтесь по указанному выше телефону, в
                WhatsApp или пишите сообение через службу поддержки. Спасибо!</p>
        </div>
    </div>
</div>
<hr>
<br>
<div class="row">
    <?php if ($admin || $administrator || $leader) { ?>
        <div class="col-md-4 col-sm-6">
            <div class="box">
                <?= Html::a('
                    <div class="btnMenu">
                        <div class="menuIcon text-center">' . Html::img('/images/icons/compose.png') . '</div>
                        <div class="menuText text-center">
                            <h3>Создать карту</h3>
                        </div>
                    </div>',
                    ['/card/create'], ['class' => 'menuLink']) ?>
            </div>
        </div>
    <?php } ?>

    <?php if ($admin || $podolog || $dermatolog || $administrator || $leader) { ?>
        <div class="col-md-4 col-sm-6">
            <div class="box">
                <?= Html::a('
                    <div class="btnMenu">
                        <div class="menuIcon text-center">' . Html::img('/images/icons/folder.png') . '</div>
                        <div class="menuText text-center">
                            <h3>Список карт</h3>
                        </div>
                    </div>',
                    ['/card'], ['class' => 'menuLink']) ?>
            </div>
        </div>
        <?php if ($podolog || $dermatolog) { ?>
            <div class="col-md-4 col-sm-6">
                <div class="box">
                    <?= Html::a('
                    <div class="btnMenu">
                        <div class="menuIcon text-center">' . Html::img('/images/icons/calendar.png') . '</div>
                        <div class="menuText text-center">
                            <h3>Календарь</h3>
                        </div>
                    </div>',
                        ['/event'], ['class' => 'menuLink']) ?>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

    <?php if ($admin || $smm || $leader) { ?>
        <div class="col-md-4 col-sm-6">
            <div class="box">
                <?= Html::a('
                    <div class="btnMenu">
                        <div class="menuIcon text-center">' . Html::img('/images/icons/polaroids.png') . '</div>
                        <div class="menuText text-center">
                            <h3>Фото работ<br>(из посещений)</h3>
                        </div>
                    </div>',
                    ['/photo'], ['class' => 'menuLink']) ?>
            </div>
        </div>
    <?php } ?>

    <?php if ($admin || $administrator || $leader) { ?>
        <div class="col-md-4 col-sm-6">
            <div class="box">
                <?= Html::a('
                    <div class="btnMenu">
                        <div class="menuIcon text-center">' . Html::img('/images/icons/check.png') . '</div>
                        <div class="menuText text-center">
                            <h3>Запланированные посещения</h3>
                        </div>
                    </div>',
                    ['/visit/planned'], ['class' => 'menuLink']) ?>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="box">
                <?= Html::a('
                    <div class="btnMenu">
                        <div class="menuIcon text-center">' . Html::img('/images/icons/x.png') . '</div>
                        <div class="menuText text-center">
                            <h3>Пропущенные посещения</h3>
                        </div>
                    </div>',
                    ['/visit/missed'], ['class' => 'menuLink']) ?>
            </div>
        </div>
    <?php } ?>
    <?php if ($admin || $administrator || $leader) { ?>
        <div class="col-md-4 col-sm-6">
            <div class="box">
                <?= Html::a('
                    <div class="btnMenu">
                        <div class="menuIcon text-center">' . Html::img('/images/icons/nophoto.png') . '</div>
                        <div class="menuText text-center">
                            <h3>Посещения без фото</h3>
                        </div>
                    </div>',
                    ['/visit/nophotos'], ['class' => 'menuLink']) ?>
            </div>
        </div>
    <?php } ?>
</div>
<?php if ($admin || $leader) { ?>
    <hr>
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <div class="box">
                <?= Html::a('
                    <div class="btnMenu">
                        <div class="menuIcon text-center">' . Html::img('/images/icons/cone.png') . '</div>
                        <div class="menuText text-center">
                            <h3>Логи</h3>
                        </div>
                    </div>',
                    ['/log'], ['class' => 'menuLink']) ?>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="box">
                <?= Html::a('
                    <div class="btnMenu">
                        <div class="menuIcon text-center">' . Html::img('/images/icons/stack.png') . '</div>
                        <div class="menuText text-center">
                            <h3>Шаблоны для специалистов</h3>
                        </div>
                    </div>',
                    ['/problem'], ['class' => 'menuLink']) ?>
            </div>
        </div>
    </div>
<?php } ?>
<hr>
<?php if ($admin) { ?>
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <div class="box">
                <?= Html::a('
                    <div class="btnMenu">
                        <div class="menuIcon text-center">' . Html::img('/images/icons/circlecompass.png') . '</div>
                        <div class="menuText text-center">
                            <h3>Поддержка</h3>
                        </div>
                        <div>Новых обращений: <b>' . $viewed . '</b></div>
                        <div>Нерешенных обращений: <b>' . $result . '</b></div>
                    </div>',
                    ['/pages/support'], ['class' => 'menuLink']) ?>
            </div>
        </div>
    </div>
    <hr>
<?php } ?>
