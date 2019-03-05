<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Extends Assets AssetBundle
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class IoniconAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/Ionicons';
    public $css = [
        'css/ionicons.min.css',
    ];
    public $js = [
    ];
}
