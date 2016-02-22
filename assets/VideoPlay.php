<?php

namespace app\assets;

use yii\web\AssetBundle;


class VideoPlay extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'video-js/video-js.min.css',
    ];
    public $js = [
    	'video-js/video.min.js',
        'video-js/ie8/videojs-ie8.min.js',
        'video-js/lang/zh-CN.js',
        'js/app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
