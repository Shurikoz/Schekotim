<?php
use wbraganca\videojs\VideoJsWidget;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                Просмотр списка работ (посещений) с фотографиями
            </a>
        </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse">
        <div class="panel-body">
            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                deserunt mollit anim id est laborum."</p>
            <br>
            <?= VideoJsWidget::widget([
                'options' => [
//                    'class' => 'video-js vjs-default-skin vjs-big-play-centered',
//                    'poster' => "http://www.videojs.com/img/poster.jpg",
                    'class' => 'vjs-default-skin vjs-big-play-centered',
                    'controls' => true,
                    'preload' => 'auto',
                    'width' => '100%',
                    'height' => '400',
                ],
                'tags' => [
                    'source' => [
                        ['src' => 'videos/tutorial/video_2020-06-09_20-18-34_1.mp4', 'type' => 'video/mp4']
                    ]
                ]
            ]); ?>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                Отметка о использовании фотографий
            </a>
        </h4>
    </div>
    <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">
            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                deserunt mollit anim id est laborum."</p>
            <br>
            <?= VideoJsWidget::widget([
                'options' => [
//                    'class' => 'video-js vjs-default-skin vjs-big-play-centered',
//                    'poster' => "http://www.videojs.com/img/poster.jpg",
                    'class' => 'vjs-default-skin vjs-big-play-centered',
                    'controls' => true,
                    'preload' => 'auto',
                    'width' => '100%',
                    'height' => '400',
                ],
                'tags' => [
                    'source' => [
                        ['src' => 'videos/tutorial/video_2020-06-09_20-18-34_1.mp4', 'type' => 'video/mp4']
                    ]
                ]
            ]); ?>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                Скачивание фотографий на компьютер
            </a>
        </h4>
    </div>
    <div id="collapse3" class="panel-collapse collapse">
        <div class="panel-body">
            Скачивание фотографий на компьютер
        </div>
    </div>
</div>