<?php

namespace app\assets;

use yii\web\AssetBundle;


class CommentEmoji extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/app.js',
        'js/jquery.qqFace.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
