<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main.css',
        'css/magnific-popup.css',
        'css/animate.min.css',
        'css/unite-gallery.css'
    ];
    public $js = [
        'js/ug-theme-tilesgrid.js',
        'js/unitegallery.min.js',
        'js/breakpoints.min.js',
        'js/browser.min.js',
        'js/main.js',
        'js/util.js',
        'js/script.js',
        'js/jquery.magnific-popup.min.js',
        'js/wow.min.js',
        'js/jquery.lazyload.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
