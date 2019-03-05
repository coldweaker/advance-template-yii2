<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Extends Assets AssetBundle
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class MomentAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components/moment';
    public $css = [
    ];
    public $js = [
        'min/moment-with-locales.min.js'
    ];
}
