<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Extends Assets AssetBundle
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class JQueryUIAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/jquery-ui';
    public $css = [
    ];
    public $js = [
        'jquery-ui.min.js'
    ];
}
