<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Extends Assets AssetBundle
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class FastClickAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/fastclick/lib';
    public $css = [
    ];
    public $js = [
        'fastclick.js'
    ];
}
