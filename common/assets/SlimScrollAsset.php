<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Extends Assets AssetBundle
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class SlimScrollAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/jquery-slimscroll';
    public $css = [
    ];
    public $js = [
        'jquery.slimscroll.min.js'
    ];
}
